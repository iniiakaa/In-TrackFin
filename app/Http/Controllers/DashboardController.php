<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Today's metrics
        $totalPaketMasuk = Resi::whereDate('created_at', $today)->count();
        $totalPaketSelesai = Resi::whereDate('updated_at', $today)->where('status', 'selesai')->count();
        $totalPendapatan = Income::whereDate('tanggal', $today)->sum('nominal');
        $totalPengeluaran = Expense::whereDate('tanggal', $today)->sum('nominal');
        $labaRugi = $totalPendapatan - $totalPengeluaran;

        // Last 7 days chart data
        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartPemasukan[] = (float) Income::whereDate('tanggal', $date)->sum('nominal');
            $chartPengeluaran[] = (float) Expense::whereDate('tanggal', $date)->sum('nominal');
        }

        // Recent shipments
        $recentResis = Resi::latest()->take(5)->get();

        // Status counts
        $statusCounts = [
            'tiba_di_cabang' => Resi::where('status', 'tiba_di_cabang')->count(),
            'sedang_diproses' => Resi::where('status', 'sedang_diproses')->count(),
            'dibawa_kurir' => Resi::where('status', 'dibawa_kurir')->count(),
            'selesai' => Resi::where('status', 'selesai')->count(),
        ];

        return view('dashboard', compact(
            'totalPaketMasuk',
            'totalPaketSelesai',
            'totalPendapatan',
            'totalPengeluaran',
            'labaRugi',
            'chartLabels',
            'chartPemasukan',
            'chartPengeluaran',
            'recentResis',
            'statusCounts'
        ));
    }
}
