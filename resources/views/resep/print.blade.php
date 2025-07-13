<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resep Obat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }

        .prescription-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background: white;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #10b981;
            padding-bottom: 20px;
        }

        .clinic-name {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 5px;
        }

        .clinic-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .prescription-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-top: 15px;
        }

        .prescription-number {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .info-section {
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            color: #333;
        }

        .info-value {
            color: #666;
        }

        .racikan-info {
            background: #ecfdf5;
            border-left-color: #10b981;
            margin-bottom: 20px;
        }

        .medication-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .medication-table th {
            background: linear-gradient(135deg, #10b981, #3b82f6);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .medication-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .medication-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .medication-table tr:hover {
            background: #f3f4f6;
        }

        .medication-name {
            font-weight: 600;
            color: #333;
        }

        .medication-code {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }

        .quantity-badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .signa-info {
            background: #fef3c7;
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid #f59e0b;
        }

        .signa-code {
            font-weight: 600;
            color: #92400e;
        }

        .signa-desc {
            font-size: 12px;
            color: #78350f;
            margin-top: 2px;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .patient-info {
            flex: 1;
        }

        .doctor-signature {
            text-align: center;
            flex: 1;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            width: 200px;
            margin: 60px auto 10px;
        }

        .date-issued {
            text-align: right;
            margin-bottom: 20px;
            color: #666;
            font-size: 14px;
        }

        @media print {
            .prescription-container {
                padding: 20px;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="prescription-container">
        <div class="header">
            <div class="clinic-name">KLINIK SEHAT BERSAMA</div>
            <div class="clinic-info">
                Jl. Kesehatan No. 123, Jakarta Selatan<br>
                Telp: (021) 1234-5678 | Email: info@kliniksehat.com
            </div>
            <div class="prescription-title">RESEP OBAT</div>
            <div class="prescription-number">No. Resep: {{ str_pad($resep->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>

        <div class="date-issued">
            Tanggal: {{ \Carbon\Carbon::parse($resep->tanggal)->format('d F Y') }}
        </div>

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Tanggal Resep:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($resep->tanggal)->format('d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jenis Resep:</span>
                <span class="info-value">{{ $resep->isRacikan() ? 'Racikan' : 'Non Racikan' }}</span>
            </div>
        </div>

        @if($resep->isRacikan())
        <div class="info-section racikan-info">
            <div class="info-row">
                <span class="info-label">Nama Racikan:</span>
                <span class="info-value">{{ $resep->nama_racikan }}</span>
            </div>
        </div>
        @endif

        <table class="medication-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Obat</th>
                    <th style="width: 100px;">Jumlah</th>
                    <th style="width: 200px;">Aturan Pakai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resep->details as $detail)
                <tr>
                    <td style="text-align: center; font-weight: 600;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="medication-name">{{ $detail->obat->obatalkes_nama }}</div>
                        <div class="medication-code">Kode: {{ $detail->obat->obatalkes_kode }}</div>
                    </td>
                    <td style="text-align: center;">
                        <span class="quantity-badge">{{ $detail->jumlah }} unit</span>
                    </td>
                    <td>
                        <div class="signa-info">
                            <div class="signa-code">{{ $detail->signa->signa_kode }}</div>
                            <div class="signa-desc">{{ $detail->signa->signa_nama }}</div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <div class="patient-info">
                <strong>Catatan untuk Pasien:</strong><br>
                • Minum obat sesuai aturan pakai<br>
                • Habiskan obat yang diberikan<br>
                • Konsultasi jika ada efek samping
            </div>
            <div class="doctor-signature">
                <p><strong>Dokter Pemeriksa</strong></p>
                <div class="signature-line"></div>
                <p>dr. [Nama Dokter]</p>
                <p style="font-size: 12px; color: #666;">SIP: [Nomor SIP]</p>
            </div>
        </div>
    </div>
</body>
</html>
