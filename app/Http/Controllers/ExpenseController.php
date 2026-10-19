<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
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
        $query = Expense::query()->latest('tanggal');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $expenses   = $query->paginate(15);
        $categories = Expense::distinct()->pluck('kategori');

        return view('expenses.index', compact('expenses', 'categories'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'kategori'    => 'required|string|max:255',
            'nominal'     => 'required|numeric|min:0',
            'keterangan'  => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        $expense = Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'kategori'   => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy(Expense $expense)
    {
        $kategori = $expense->kategori;
        $nominal  = $expense->nominal;

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
