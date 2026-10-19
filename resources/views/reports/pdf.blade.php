<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi - {{ $periodLabel }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; padding: 30px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #0058bc; padding-bottom: 15px; }
        .header h1 { font-size: 18px; color: #1a1a2e; margin-bottom: 3px; }
        .header h2 { font-size: 14px; color: #0058bc; margin-bottom: 3px; }
        .header p { font-size: 10px; color: #666; }
        .section-title { font-size: 13px; font-weight: bold; color: #1a1a2e; margin: 20px 0 8px; padding: 5px 10px; background: #f0f0ff; border-left: 3px solid #0058bc; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th { background: #1a1a2e; color: white; padding: 6px 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 5px 8px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #fafafa; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background: #f0f0ff !important; border-top: 2px solid #ddd; }
        .total-row td { padding: 8px; font-size: 11px; }
        .summary-box { margin-top: 25px; border: 2px solid #0058bc; border-radius: 8px; padding: 15px; }
        .summary-box h3 { font-size: 14px; text-align: center; margin-bottom: 10px; color: #0058bc; }
        .summary-row { display: flex; justify-content: space-between; padding: 4px 0; }
        .laba { color: #10b981; }
        .rugi { color: #f43f5e; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT INDAH LOGISTIK</h1>
        <h2>Cabang Cianjur</h2>
        <p>LAPORAN LABA RUGI OPERASIONAL</p>
        <p>Periode: {{ $periodLabel }}</p>
    </div>

    {{-- PEMASUKAN --}}
    <div class="section-title">PEMASUKAN (CASH IN)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 15%">Sumber</th>
                <th style="width: 45%">Keterangan</th>
                <th style="width: 25%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomes as $income)
            <tr>
                <td>{{ $income->tanggal->format('d/m/Y') }}</td>
                <td>{{ $income->sumber === 'resi' ? 'Tarif Resi' : 'Lainnya' }}</td>
                <td>{{ $income->keterangan }}</td>
                <td class="text-right">Rp {{ number_format($income->nominal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">TOTAL PEMASUKAN</td>
                <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- PENGELUARAN --}}
    <div class="section-title">PENGELUARAN (CASH OUT)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 15%">Kategori</th>
                <th style="width: 45%">Keterangan</th>
                <th style="width: 25%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->tanggal->format('d/m/Y') }}</td>
                <td>{{ $expense->kategori }}</td>
                <td>{{ $expense->keterangan }}</td>
                <td class="text-right">Rp {{ number_format($expense->nominal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">TOTAL PENGELUARAN</td>
                <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- LABA RUGI --}}
    <div class="summary-box">
        <h3>RINGKASAN LABA RUGI</h3>
        <table>
            <tr>
                <td style="border: none; padding: 4px 8px;">Total Pemasukan</td>
                <td style="border: none; padding: 4px 8px;" class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 4px 8px;">Total Pengeluaran</td>
                <td style="border: none; padding: 4px 8px;" class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 2px solid #0058bc;">
                <td style="border: none; padding: 8px; font-weight: bold; font-size: 13px;">
                    {{ $labaRugi >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}
                </td>
                <td style="border: none; padding: 8px; font-weight: bold; font-size: 13px;" class="text-right {{ $labaRugi >= 0 ? 'laba' : 'rugi' }}">
                    Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak dari In-TrackFin &middot; {{ now()->format('d M Y H:i') }} &middot; PT Indah Logistik Cabang Cianjur</p>
    </div>
</body>
</html>
