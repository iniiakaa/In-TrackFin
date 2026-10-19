<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Resi Pengiriman</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Helvetica", "Arial", sans-serif; font-size: 10px; color: #1a1a2e; padding: 24px 30px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 3px solid #0058bc; }
        .header-left h1 { font-size: 16px; font-weight: bold; color: #1a1a2e; }
        .header-left h2 { font-size: 11px; color: #0058bc; margin-top: 2px; }
        .header-left p { font-size: 9px; color: #888; margin-top: 2px; }
        .header-right { text-align: right; }
        .doc-title { font-size: 13px; font-weight: bold; color: #0058bc; text-transform: uppercase; letter-spacing: 1px; }
        .doc-meta { font-size: 9px; color: #888; margin-top: 4px; line-height: 1.5; }
        .filter-info { background: #f0f4ff; border: 1px solid #c7d9ff; border-radius: 6px; padding: 6px 10px; margin-bottom: 14px; font-size: 9px; color: #444; }
        .filter-info strong { color: #0058bc; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead tr { background: #1a1a2e; color: white; }
        th { padding: 7px 8px; text-align: left; font-size: 9px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.4px; }
        td { padding: 5px 8px; font-size: 9.5px; border-bottom: 1px solid #e8ecf0; vertical-align: middle; }
        tr:nth-child(even) td { background: #f7f9ff; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 7px; border-radius: 4px; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .badge-tiba    { background: #e0f2fe; color: #0369a1; }
        .badge-proses  { background: #fef9c3; color: #854d0e; }
        .badge-kurir   { background: #ede9fe; color: #5b21b6; }
        .badge-selesai { background: #dcfce7; color: #166534; }
        .total-row td  { background: #f0f4ff !important; font-weight: bold; font-size: 10px; border-top: 2px solid #0058bc; }
        .summary-section { margin-top: 10px; display: flex; gap: 12px; }
        .summary-box { flex: 1; border: 1.5px solid #0058bc; border-radius: 8px; padding: 10px 14px; }
        .summary-box h4 { font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; color: #888; margin-bottom: 6px; }
        .summary-row { display: flex; justify-content: space-between; padding: 3px 0; font-size: 10px; border-bottom: 1px solid #eee; }
        .summary-row:last-child { border-bottom: none; }
        .summary-row .label { color: #555; }
        .summary-row .value { font-weight: bold; color: #1a1a2e; }
        .summary-row.highlight .value { color: #0058bc; font-size: 12px; }
        .no-resi { font-family: monospace; font-weight: bold; color: #0058bc; font-size: 9px; }
        .tarif { font-weight: bold; }
        .footer { margin-top: 24px; border-top: 1px solid #ddd; padding-top: 8px; display: flex; justify-content: space-between; font-size: 8px; color: #aaa; }
    </style>
</head>
<body>

<div class="header">
    <div class="header-left">
        <h1>PT INDAH LOGISTIK</h1>
        <h2>Cabang Cianjur</h2>
        <p>Jl. Raya Cianjur No. 1, Cianjur, Jawa Barat</p>
    </div>
    <div class="header-right">
        <div class="doc-title">Data Resi Pengiriman</div>
        <div class="doc-meta">
            Dicetak: {{ now()->format('d/m/Y H:i') }} WIB<br>
            Total data: {{ $resis->count() }} resi
        </div>
    </div>
</div>

@if($filterInfo !== 'semua' || $searchInfo)
<div class="filter-info">
    Filter aktif:
    @if($filterInfo !== 'semua')
        Status = <strong>{{ str_replace('_', ' ', ucwords($filterInfo)) }}</strong>
    @endif
    @if($searchInfo)
        @if($filterInfo !== 'semua') &nbsp;|&nbsp; @endif
        Pencarian = <strong>"{{ $searchInfo }}"</strong>
    @endif
</div>
@endif

<table>
    <thead>
        <tr>
            <th style="width:4%">#</th>
            <th style="width:13%">No. Resi</th>
            <th style="width:13%">Pengirim</th>
            <th style="width:13%">Penerima</th>
            <th style="width:22%">Alamat Tujuan</th>
            <th style="width:8%" class="text-center">Berat (kg)</th>
            <th style="width:12%" class="text-right">Tarif (Rp)</th>
            <th style="width:10%" class="text-center">Status</th>
            <th style="width:10%">Tgl. Input</th>
        </tr>
    </thead>
    <tbody>
        @forelse($resis as $i => $resi)
        @php
            $statusMap = [
                'tiba_di_cabang'  => ['label' => 'Tiba di Cabang', 'class' => 'badge-tiba'],
                'sedang_diproses' => ['label' => 'Sedang Diproses', 'class' => 'badge-proses'],
                'dibawa_kurir'    => ['label' => 'Dibawa Kurir',   'class' => 'badge-kurir'],
                'selesai'         => ['label' => 'Selesai',        'class' => 'badge-selesai'],
            ];
            $s = $statusMap[$resi->status] ?? ['label' => $resi->status, 'class' => ''];
        @endphp
        <tr>
            <td class="text-center" style="color:#aaa;">{{ $i + 1 }}</td>
            <td><span class="no-resi">{{ $resi->nomor_resi }}</span></td>
            <td>{{ $resi->nama_pengirim }}</td>
            <td>{{ $resi->nama_penerima }}</td>
            <td>{{ $resi->alamat_tujuan }}</td>
            <td class="text-center">{{ number_format($resi->berat_barang, 1) }}</td>
            <td class="text-right tarif">{{ number_format($resi->tarif, 0, ',', '.') }}</td>
            <td class="text-center"><span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span></td>
            <td>{{ $resi->created_at->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center" style="padding: 20px; color: #aaa;">Tidak ada data resi.</td>
        </tr>
        @endforelse
        @if($resis->count() > 0)
        <tr class="total-row">
            <td colspan="6" class="text-right" style="padding: 7px 8px;">TOTAL TARIF</td>
            <td class="text-right" style="color:#0058bc; padding: 7px 8px;">{{ number_format($resis->sum('tarif'), 0, ',', '.') }}</td>
            <td colspan="2"></td>
        </tr>
        @endif
    </tbody>
</table>

@if($resis->count() > 0)
@php
    $byStatus = $resis->groupBy('status')->map->count();
    $statusNames = [
        'tiba_di_cabang'  => 'Tiba di Cabang',
        'sedang_diproses' => 'Sedang Diproses',
        'dibawa_kurir'    => 'Dibawa Kurir',
        'selesai'         => 'Selesai Terkirim',
    ];
@endphp
<div class="summary-section">
    <div class="summary-box" style="flex:1.5;">
        <h4>Rekap Per Status</h4>
        @foreach($statusNames as $key => $label)
        <div class="summary-row">
            <span class="label">{{ $label }}</span>
            <span class="value">{{ $byStatus[$key] ?? 0 }} resi</span>
        </div>
        @endforeach
    </div>
    <div class="summary-box" style="flex:1;">
        <h4>Ringkasan Keseluruhan</h4>
        <div class="summary-row">
            <span class="label">Total Resi</span>
            <span class="value">{{ $resis->count() }} resi</span>
        </div>
        <div class="summary-row">
            <span class="label">Total Berat</span>
            <span class="value">{{ number_format($resis->sum('berat_barang'), 1) }} kg</span>
        </div>
        <div class="summary-row highlight">
            <span class="label">Total Pendapatan Tarif</span>
            <span class="value">Rp {{ number_format($resis->sum('tarif'), 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endif

<div class="footer">
    <span>In-TrackFin &mdash; Sistem Manajemen Ekspedisi &amp; Keuangan Indah Logistik</span>
    <span>PT Indah Logistik Cabang Cianjur &copy; {{ now()->year }}</span>
</div>

</body>
</html>
