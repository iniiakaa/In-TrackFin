<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->canManageFinance()) {
            abort(403, 'Akses ditolak.');
        }

        $filter = $request->get('filter', 'hari');
        $tanggal = $request->get('tanggal', now()->toDateString());

        switch ($filter) {
            case 'minggu':
                $startDate = Carbon::parse($tanggal)->startOfWeek();
                $endDate = Carbon::parse($tanggal)->endOfWeek();
                $periodLabel = $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
                break;
            case 'bulan':
                $startDate = Carbon::parse($tanggal)->startOfMonth();
                $endDate = Carbon::parse($tanggal)->endOfMonth();
                $periodLabel = Carbon::parse($tanggal)->translatedFormat('F Y');
                break;
            default: // hari
                $startDate = Carbon::parse($tanggal)->startOfDay();
                $endDate = Carbon::parse($tanggal)->endOfDay();
                $periodLabel = Carbon::parse($tanggal)->translatedFormat('d F Y');
                break;
        }

        $incomes = Income::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('tanggal')
            ->get();

        $expenses = Expense::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('tanggal')
            ->get();

        $totalPemasukan = $incomes->sum('nominal');
        $totalPengeluaran = $expenses->sum('nominal');
        $labaRugi = $totalPemasukan - $totalPengeluaran;

        // Group by category
        $pemasukanBySource = $incomes->groupBy('sumber')->map->sum('nominal');
        $pengeluaranByCategory = $expenses->groupBy('kategori')->map->sum('nominal');

        return view('reports.index', compact(
            'filter',
            'tanggal',
            'periodLabel',
            'incomes',
            'expenses',
            'totalPemasukan',
            'totalPengeluaran',
            'labaRugi',
            'pemasukanBySource',
            'pengeluaranByCategory'
        ));
    }

    public function exportPdf(Request $request)
    {
        if (!auth()->user()->canManageFinance()) {
            abort(403, 'Akses ditolak.');
        }

        $filter = $request->get('filter', 'hari');
        $tanggal = $request->get('tanggal', now()->toDateString());

        switch ($filter) {
            case 'minggu':
                $startDate = Carbon::parse($tanggal)->startOfWeek();
                $endDate = Carbon::parse($tanggal)->endOfWeek();
                $periodLabel = $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
                break;
            case 'bulan':
                $startDate = Carbon::parse($tanggal)->startOfMonth();
                $endDate = Carbon::parse($tanggal)->endOfMonth();
                $periodLabel = Carbon::parse($tanggal)->translatedFormat('F Y');
                break;
            default:
                $startDate = Carbon::parse($tanggal)->startOfDay();
                $endDate = Carbon::parse($tanggal)->endOfDay();
                $periodLabel = Carbon::parse($tanggal)->translatedFormat('d F Y');
                break;
        }

        $incomes = Income::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('tanggal')->get();
        $expenses = Expense::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('tanggal')->get();

        $totalPemasukan = $incomes->sum('nominal');
        $totalPengeluaran = $expenses->sum('nominal');
        $labaRugi = $totalPemasukan - $totalPengeluaran;

        $pdf = Pdf::loadView('reports.pdf', compact(
            'periodLabel', 'filter', 'incomes', 'expenses',
            'totalPemasukan', 'totalPengeluaran', 'labaRugi'
        ));

        $filename = 'laporan-laba-rugi-' . str_replace(' ', '-', strtolower($periodLabel)) . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        if (!auth()->user()->canManageFinance()) {
            abort(403, 'Akses ditolak.');
        }

        $filter = $request->get('filter', 'hari');
        $tanggal = $request->get('tanggal', now()->toDateString());

        switch ($filter) {
            case 'minggu':
                $startDate = Carbon::parse($tanggal)->startOfWeek();
                $endDate = Carbon::parse($tanggal)->endOfWeek();
                break;
            case 'bulan':
                $startDate = Carbon::parse($tanggal)->startOfMonth();
                $endDate = Carbon::parse($tanggal)->endOfMonth();
                break;
            default:
                $startDate = Carbon::parse($tanggal)->startOfDay();
                $endDate = Carbon::parse($tanggal)->endOfDay();
                break;
        }

        $incomes = Income::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('tanggal')->get();
        $expenses = Expense::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('tanggal')->get();

        $totalPemasukan = $incomes->sum('nominal');
        $totalPengeluaran = $expenses->sum('nominal');

        // Generate CSV
        $filename = 'laporan-laba-rugi-' . $tanggal . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($incomes, $expenses, $totalPemasukan, $totalPengeluaran) {
            $file = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['LAPORAN LABA RUGI OPERASIONAL']);
            fputcsv($file, ['PT Indah Logistik - Cabang Cianjur']);
            fputcsv($file, []);

            fputcsv($file, ['== PEMASUKAN ==']);
            fputcsv($file, ['Tanggal', 'Sumber', 'Keterangan', 'Nominal']);
            foreach ($incomes as $income) {
                fputcsv($file, [
                    $income->tanggal->format('d/m/Y'),
                    $income->sumber,
                    $income->keterangan,
                    $income->nominal,
                ]);
            }
            fputcsv($file, ['', '', 'Total Pemasukan', $totalPemasukan]);
            fputcsv($file, []);

            fputcsv($file, ['== PENGELUARAN ==']);
            fputcsv($file, ['Tanggal', 'Kategori', 'Keterangan', 'Nominal']);
            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->tanggal->format('d/m/Y'),
                    $expense->kategori,
                    $expense->keterangan,
                    $expense->nominal,
                ]);
            }
            fputcsv($file, ['', '', 'Total Pengeluaran', $totalPengeluaran]);
            fputcsv($file, []);

            fputcsv($file, ['', '', 'LABA/RUGI', $totalPemasukan - $totalPengeluaran]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
