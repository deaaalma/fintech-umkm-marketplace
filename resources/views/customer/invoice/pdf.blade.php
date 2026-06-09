<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $transactionId }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* === FONT SYSTEM ===
           Heading / Logo / Labels : Helvetica (Bold)
           Body / Table Content    : Arial (Regular)
        */
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #1a1a2e;
            background: #fff;
            line-height: 1.6;
        }
        .font-heading {
            font-family: Helvetica, Arial, sans-serif;
        }

        /* ===== TOP ACCENT BAR ===== */
        .top-bar {
            height: 6px;
            background: linear-gradient(90deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            width: 100%;
            margin-bottom: 0;
        }

        /* ===== HEADER ===== */
        .header {
            background: #1a1a2e;
            color: #fff;
            padding: 28px 36px 24px;
        }
        .header-table {
            width: 100%;
        }
        .umkm-name {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #fff;
            margin-bottom: 4px;
        }
        .umkm-sub {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #a0aec0;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .invoice-badge {
            text-align: right;
        }
        .invoice-badge .label {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #a0aec0;
        }
        .invoice-badge .number {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            margin-top: 2px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 8px;
        }
        .status-lunas {
            background: rgba(72, 187, 120, 0.2);
            color: #68d391;
            border: 1px solid rgba(72, 187, 120, 0.4);
        }
        .status-belum {
            background: rgba(246, 173, 85, 0.2);
            color: #f6ad55;
            border: 1px solid rgba(246, 173, 85, 0.4);
        }

        /* ===== BODY CONTENT ===== */
        .content {
            padding: 30px 36px;
        }

        /* ===== INFO CARDS ===== */
        .info-row {
            width: 100%;
            margin-bottom: 28px;
        }
        .info-card {
            display: inline-block;
            vertical-align: top;
            width: 48%;
        }
        .info-card-right {
            text-align: right;
        }
        .info-card-label {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #718096;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        .info-card-name {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: bold;
            color: #1a1a2e;
            margin-bottom: 3px;
        }
        .info-card-detail {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #4a5568;
            line-height: 1.7;
        }

        /* ===== DIVIDER ===== */
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 0 0 24px 0;
        }

        /* ===== META GRID ===== */
        .meta-grid {
            width: 100%;
            margin-bottom: 28px;
        }
        .meta-cell {
            display: inline-block;
            vertical-align: top;
            width: 30%;
            padding-right: 10px;
        }
        .meta-label {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #718096;
            margin-bottom: 4px;
        }
        .meta-value {
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
            color: #1a1a2e;
        }

        /* ===== ITEMS TABLE ===== */
        .section-title {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #718096;
            margin-bottom: 10px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table thead th {
            background: #f7fafc;
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #718096;
            padding: 10px 12px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }
        .items-table thead th.right {
            text-align: right;
        }
        .items-table tbody td {
            padding: 12px 12px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: top;
        }
        .item-name {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            font-weight: bold;
            color: #1a1a2e;
        }
        .item-sub {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #a0aec0;
            margin-top: 2px;
        }
        .item-amount {
            font-family: Arial, sans-serif;
            text-align: right;
            font-size: 13px;
            font-weight: normal;
            color: #1a1a2e;
            white-space: nowrap;
        }

        /* ===== TOTALS ===== */
        .totals-wrapper {
            width: 100%;
        }
        .totals-table {
            width: 44%;
            float: right;
            border-collapse: collapse;
        }
        .totals-table tr td {
            font-family: Arial, sans-serif;
            padding: 7px 0;
            font-size: 12px;
        }
        .totals-table tr td:first-child {
            color: #718096;
        }
        .totals-table tr td:last-child {
            text-align: right;
            font-weight: normal;
            color: #1a1a2e;
        }
        .totals-table .total-row {
            border-top: 2px solid #1a1a2e;
            margin-top: 4px;
        }
        .totals-table .total-row td {
            font-family: Helvetica, Arial, sans-serif;
            padding-top: 10px;
            font-size: 15px;
            font-weight: bold;
            color: #1a1a2e;
        }
        .totals-table .total-row td:first-child {
            color: #1a1a2e;
        }

        /* ===== NOTES ===== */
        .notes-box {
            float: left;
            width: 52%;
            background: #f7fafc;
            border-left: 3px solid #1a1a2e;
            padding: 14px 16px;
            border-radius: 0 6px 6px 0;
        }
        .notes-box .notes-title {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #718096;
            margin-bottom: 6px;
        }
        .notes-box p {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #4a5568;
            line-height: 1.6;
        }

        /* ===== FOOTER ===== */
        .footer-wrap {
            clear: both;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid #e2e8f0;
        }
        .footer-table {
            width: 100%;
        }
        .footer-left {
            font-size: 11px;
            color: #a0aec0;
            vertical-align: bottom;
        }
        .footer-right {
            text-align: right;
            vertical-align: bottom;
        }
        .footer-tagline {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #cbd5e0;
        }
        .footer-brand {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: bold;
            color: #1a1a2e;
        }

        /* ===== BOTTOM BAR ===== */
        .bottom-bar {
            height: 4px;
            background: linear-gradient(90deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="top-bar"></div>

    {{-- ===== HEADER ===== --}}
    <div class="header">
        <table class="header-table" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    @if($order->umkm && $order->umkm->logo_url)
                        <img src="{{ public_path('storage/' . $order->umkm->logo_url) }}"
                             alt="Logo"
                             style="height: 40px; width: auto; object-fit: contain; margin-bottom: 8px; display: block;">
                    @endif
                    <div class="umkm-name">{{ $order->umkm->name ?? 'Layanan Jasa UMKM' }}</div>
                    <div class="umkm-sub">
                        {{ $order->umkm->category->name ?? 'Penyedia Layanan Profesional' }}
                        &nbsp;•&nbsp;
                        {{ $order->umkm->city ?? 'Indonesia' }}
                    </div>
                </td>
                <td class="invoice-badge">
                    <div class="label">Invoice / Faktur</div>
                    <div class="number">{{ $transactionId }}</div>
                    @if($order->status === 'paid' || $order->status === 'completed' || $successPayment)
                        <div><span class="status-badge status-lunas">LUNAS</span></div>
                    @else
                        <div><span class="status-badge status-belum">BELUM LUNAS</span></div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="content">

        {{-- ===== META INFO ===== --}}
        <div class="meta-grid" style="margin-bottom: 24px;">
            <div class="meta-cell">
                <div class="meta-label">Tanggal Invoice</div>
                <div class="meta-value">{{ $order->created_at->format('d F Y') }}</div>
            </div>
            @if($successPayment)
            <div class="meta-cell">
                <div class="meta-label">Tanggal Lunas</div>
                <div class="meta-value">
                    {{ ($successPayment->paid_at ?? $successPayment->updated_at)->format('d F Y') }}
                </div>
            </div>
            @endif
            <div class="meta-cell">
                <div class="meta-label">Metode Pembayaran</div>
                <div class="meta-value">{{ $successPayment->payment_method ?? 'QRIS / Transfer' }}</div>
            </div>
        </div>

        <hr class="divider">

        {{-- ===== BILLING TO / FROM ===== --}}
        <table class="info-row" cellspacing="0" cellpadding="0">
            <tr>
                <td class="info-card" style="width: 48%;">
                    <div class="info-card-label">Ditagihkan kepada</div>
                    <div class="info-card-name">{{ $order->customer->name ?? 'Pelanggan' }}</div>
                    <div class="info-card-detail">
                        {{ $order->customer->email ?? '' }}<br>
                        {{ $order->customer->phone ?? '' }}
                    </div>
                    @if($order->service_address)
                    <div class="info-card-detail" style="margin-top: 6px; color: #718096;">
                        📍 {{ $order->service_address }}
                    </div>
                    @endif
                </td>
                <td style="width: 4%;"></td>
                <td class="info-card info-card-right" style="width: 48%;">
                    <div class="info-card-label" style="text-align: right;">Diterbitkan oleh</div>
                    <div class="info-card-name">{{ $order->umkm->name ?? 'Mitra UMKM' }}</div>
                    <div class="info-card-detail" style="text-align: right;">
                        {{ $order->umkm->address ?? '' }}<br>
                        @if($order->umkm->detail && $order->umkm->detail->contact_person)
                            CP: {{ $order->umkm->detail->contact_person }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <hr class="divider">

        {{-- ===== ITEMS TABLE ===== --}}
        <div class="section-title">Rincian Layanan</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 55%;">Deskripsi</th>
                    <th class="right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                {{-- Main Service --}}
                <tr>
                    <td>
                        <div class="item-name">{{ $order->product->name ?? 'Jasa Layanan Utama' }}</div>
                        <div class="item-sub">Harga disepakati setelah negosiasi</div>
                    </td>
                    <td class="item-amount">
                        {{ number_format($subtotal, 0, ',', '.') }}
                    </td>
                </tr>

                {{-- Additional Fees --}}
                @foreach($additionalFees as $fee)
                <tr>
                    <td>
                        <div class="item-name">{{ $fee->fee_name }}</div>
                        <div class="item-sub">Biaya tambahan yang telah disetujui pelanggan</div>
                    </td>
                    <td class="item-amount">
                        {{ number_format($fee->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ===== TOTALS + NOTES ===== --}}
        <div class="totals-wrapper">

            {{-- Notes / Catatan --}}
            <div class="notes-box">
                <div class="notes-title">Catatan</div>
                <p>
                    @if($order->customer_note)
                        Catatan pelanggan: {{ $order->customer_note }}<br><br>
                    @endif
                    Dokumen ini merupakan bukti pembayaran yang sah atas
                    layanan yang telah diselesaikan oleh
                    <strong>{{ $order->umkm->name ?? 'Mitra UMKM' }}</strong>.
                    Harap simpan dokumen ini sebagai arsip Anda.
                </p>
            </div>

            {{-- Totals --}}
            <table class="totals-table" cellspacing="0" cellpadding="0">
                <tr>
                    <td>Subtotal Layanan</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($additionalTotal > 0)
                <tr>
                    <td>Biaya Tambahan</td>
                    <td>Rp {{ number_format($additionalTotal, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($platformFee > 0)
                <tr>
                    <td>Biaya Platform</td>
                    <td>Rp {{ number_format($platformFee, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>TOTAL</td>
                    <td>Rp {{ number_format($grandTotal + $platformFee, 0, ',', '.') }}</td>
                </tr>
            </table>

        </div>

        {{-- ===== FOOTER ===== --}}
        <div class="footer-wrap">
            <table class="footer-table" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="footer-left">
                        Terima kasih telah mempercayakan kebutuhan Anda kepada
                        <strong>{{ $order->umkm->name ?? 'kami' }}</strong>.<br>
                        Dokumen ini digenerate secara otomatis dan sah tanpa tanda tangan basah.
                    </td>
                    <td class="footer-right">
                        <div class="footer-tagline">Powered by</div>
                        <div class="footer-brand">JOS</div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    <div class="bottom-bar"></div>

</body>
</html>
