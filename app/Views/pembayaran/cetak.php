<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi - <?= $pembayaran['no_tagihan']; ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 14px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px dashed #000; padding-bottom: 10px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { text-align: left; padding: 5px 0; }
        .border-top { border-top: 1px dashed #000; }
        .border-bottom { border-bottom: 1px dashed #000; }
        .text-right { text-align: right; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; }
        /* Hilangkan tombol print saat dicetak */
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div style="max-width: 400px; margin: auto;">
        <div class="header">
            <h3>KLINIK MEDIKA SISTEM</h3>
            <p>Jl. Kesehatan No. 123, Jakarta<br>Telp: 021-5551234</p>
        </div>

        <div class="info">
            <table style="width: 100%;">
                <tr><td>No. Kwitansi</td><td>: <?= $pembayaran['no_tagihan']; ?></td></tr>
                <tr><td>Tanggal</td><td>: <?= date('d/m/Y H:i', strtotime($pembayaran['tanggal_bayar'])); ?></td></tr>
                <tr><td>Pasien</td><td>: <?= $pembayaran['nama_pasien']; ?></td></tr>
                <tr><td>Metode</td><td>: <?= $pembayaran['metode_pembayaran']; ?></td></tr>
            </table>
        </div>

        <table>
            <tr class="border-top border-bottom">
                <th>Item</th>
                <th class="text-right">Harga</th>
            </tr>
            
            <!-- Jika di Controller kamu melempar detail layanan, tampilkan di sini -->
            <tr>
                <td>Total Tagihan Layanan & Obat</td>
                <td class="text-right">Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.'); ?></td>
            </tr>

            <tr class="border-top">
                <th>GRAND TOTAL</th>
                <th class="text-right">Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.'); ?></th>
            </tr>
        </table>

        <div class="footer">
            <p><strong>STATUS: <?= strtoupper($pembayaran['status_pembayaran']); ?></strong></p>
            <p>Terima kasih atas kunjungan Anda.<br>Semoga lekas sembuh.</p>
            
            <button class="no-print" style="margin-top:20px; padding: 10px 20px; cursor: pointer;" onclick="window.print()">Cetak Struk (Ctrl+P)</button>
        </div>
    </div>
</body>
</html> 