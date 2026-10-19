<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->canManageFinance()) {
                abort(403, 'Akses ditolak. Hanya Admin Accounting dan Kepala Cabang yang dapat mengakses keuangan.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Income::query()->latest('tanggal');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('sumber')) {
            $query->where('sumber', $request->sumber);
        }

        $incomes = $query->paginate(15);

        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        return view('incomes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'nominal'    => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['sumber']  = 'lainnya';
        $validated['user_id'] = auth()->id();

        $income = Income::create($validated);

        return redirect()->route('incomes.index')->with('success', 'Pemasukan berhasil dicatat!');
    }

    public function edit(Income $income)
    {
        if ($income->sumber === 'resi') {
            return redirect()->route('incomes.index')->with('error', 'Pemasukan dari resi tidak bisa diedit langsung.');
        }
        return view('incomes.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        if ($income->sumber === 'resi') {
            return redirect()->route('incomes.index')->with('error', 'Pemasukan dari resi tidak bisa diedit langsung.');
        }

        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'nominal'    => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $income->update($validated);

        return redirect()->route('incomes.index')->with('success', 'Pemasukan berhasil diperbarui!');
    }

    public function destroy(Income $income)
    {
        if ($income->sumber === 'resi') {
            return redirect()->route('incomes.index')->with('error', 'Pemasukan dari resi tidak bisa dihapus langsung.');
        }

        $nominal = $income->nominal;
        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Pemasukan berhasil dihapus!');
    }
}
