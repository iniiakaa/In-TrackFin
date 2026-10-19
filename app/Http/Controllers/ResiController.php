<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use App\Models\Income;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ResiController extends Controller
{
    public function __construct()
    {
        // Hanya admin_ekspedisi dan kepala_cabang bisa create/edit/delete/updateStatus
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->canManageResi()) {
                abort(403, 'Akses ditolak. Hanya Admin Ekspedisi dan Kepala Cabang yang dapat mengelola resi.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy', 'updateStatus']);
    }

    public function index(Request $request)
    {
        $query = Resi::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_resi', 'like', "%{$search}%")
                  ->orWhere('nama_pengirim', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $resis = $query->paginate(15);

        return view('resi.index', compact('resis'));
    }

    public function create()
    {
        return view('resi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'alamat_tujuan' => 'required|string|max:255',
            'berat_barang'  => 'required|numeric|min:0.1',
            'tarif'         => 'required|numeric|min:0',
            'catatan'       => 'nullable|string',
        ]);

        $validated['nomor_resi'] = Resi::generateNomorResi();
        $validated['user_id']    = auth()->id();
        $validated['status']     = 'tiba_di_cabang';

        $resi = Resi::create($validated);

        return redirect()->route('resi.index')->with('success', 'Resi berhasil ditambahkan!');
    }

    public function show(Resi $resi)
    {
        return view('resi.show', compact('resi'));
    }

    public function edit(Resi $resi)
    {
        return view('resi.edit', compact('resi'));
    }

    public function update(Request $request, Resi $resi)
    {
        $validated = $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'alamat_tujuan' => 'required|string|max:255',
            'berat_barang'  => 'required|numeric|min:0.1',
            'tarif'         => 'required|numeric|min:0',
            'catatan'       => 'nullable|string',
        ]);

        $resi->update($validated);

        return redirect()->route('resi.index')->with('success', 'Resi berhasil diperbarui!');
    }

    public function updateStatus(Request $request, Resi $resi)
    {
        $request->validate([
            'status' => 'required|in:tiba_di_cabang,sedang_diproses,dibawa_kurir,selesai',
        ]);

        $oldStatus = $resi->status;
        $newStatus = $request->status;

        $resi->update(['status' => $newStatus]);

        $statusLabel = [
            'tiba_di_cabang'  => 'Tiba di Cabang',
            'sedang_diproses' => 'Sedang Diproses',
            'dibawa_kurir'    => 'Dibawa Kurir',
            'selesai'         => 'Selesai',
        ];

        // Auto-create income when status changes to 'selesai'
        if ($newStatus === 'selesai' && $oldStatus !== 'selesai') {
            Income::create([
                'tanggal'     => now()->toDateString(),
                'sumber'      => 'resi',
                'nominal'     => $resi->tarif,
                'keterangan'  => "Ongkir resi {$resi->nomor_resi} - {$resi->nama_pengirim} ke {$resi->nama_penerima}",
                'resi_id'     => $resi->id,
                'user_id'     => auth()->id(),
            ]);

        }

        // Remove auto-income if status changed FROM selesai to something else
        if ($oldStatus === 'selesai' && $newStatus !== 'selesai') {
            Income::where('resi_id', $resi->id)->where('sumber', 'resi')->delete();

        }

        return redirect()->back()->with('success', "Status resi berhasil diubah ke " . str_replace('_', ' ', $newStatus) . "!");
    }

    public function destroy(Resi $resi)
    {
        $nomor = $resi->nomor_resi;
        $pengirim = $resi->nama_pengirim;

        $resi->delete();

        return redirect()->route('resi.index')->with('success', 'Resi berhasil dihapus!');
    }

    public function exportCsv(Request $request)
    {
        if (!auth()->user()->isAdminAccounting()) {
            abort(403, 'Akses ditolak. Hanya Admin Accounting yang dapat mengekspor data.');
        }

        $query = Resi::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_resi', 'like', "%{$search}%")
                  ->orWhere('nama_pengirim', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $resis = $query->get();

        $statusLabel = [
            'tiba_di_cabang'  => 'Tiba di Cabang',
            'sedang_diproses' => 'Sedang Diproses',
            'dibawa_kurir'    => 'Dibawa Kurir',
            'selesai'         => 'Selesai',
        ];

        $filename = 'data-resi-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($resis, $statusLabel) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['DATA RESI PENGIRIMAN']);
            fputcsv($file, ['PT Indah Logistik - Cabang Cianjur']);
            fputcsv($file, ['Dicetak:', now()->format('d/m/Y H:i')]);
            fputcsv($file, []);

            fputcsv($file, ['No. Resi', 'Pengirim', 'Penerima', 'Alamat Tujuan', 'Berat (kg)', 'Tarif (Rp)', 'Status', 'Tanggal Dibuat']);
            foreach ($resis as $resi) {
                fputcsv($file, [
                    $resi->nomor_resi,
                    $resi->nama_pengirim,
                    $resi->nama_penerima,
                    $resi->alamat_tujuan,
                    $resi->berat_barang,
                    $resi->tarif,
                    $statusLabel[$resi->status] ?? $resi->status,
                    $resi->created_at->format('d/m/Y H:i'),
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['Total Resi:', $resis->count()]);
            fputcsv($file, ['Total Tarif:', 'Rp ' . number_format($resis->sum('tarif'), 0, ',', '.')]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        if (!auth()->user()->isAdminAccounting()) {
            abort(403, 'Akses ditolak. Hanya Admin Accounting yang dapat mengekspor data.');
        }

        $query = Resi::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_resi', 'like', "%{$search}%")
                  ->orWhere('nama_pengirim', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $resis      = $query->get();
        $filterInfo = $request->filled('status') ? ($request->status) : 'semua';
        $searchInfo = $request->filled('search') ? $request->search : null;

        $pdf = Pdf::loadView('resi.pdf', compact('resis', 'filterInfo', 'searchInfo'))
                  ->setPaper('a4', 'landscape');

        $filename = 'data-resi-' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
