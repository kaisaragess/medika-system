<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran Kasir</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KLINIK MEDIKA SISTEM</h2>
        <p>Jl. Kesehatan No. 123, Jakarta | Telp: 021-5551234</p>
        <h3>LAPORAN PEMBAYARAN KASIR</h3>
    </div>

    <div class="info">
        <p><strong>Periode:</strong> 
            <?php 
                if ($start_date && $end_date) {
                    echo date('d/m/Y', strtotime($start_date)) . ' s/d ' . date('d/m/Y', strtotime($end_date));
                } elseif ($start_date) {
                    echo 'Mulai ' . date('d/m/Y', strtotime($start_date));
                } elseif ($end_date) {
                    echo 'Sampai ' . date('d/m/Y', strtotime($end_date));
                } else {
                    echo 'Semua Waktu';
                }
            ?>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">No. Tagihan</th>
                <th width="15%">Tgl Bayar</th>
                <th width="20%">Nama Pasien</th>
                <th width="15%" class="text-right">Total Tagihan</th>
                <th width="15%" class="text-center">Metode</th>
                <th width="15%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; $totalSemua = 0; ?>
            <?php foreach ($pembayaran as $p): ?>
                <?php $totalSemua += $p['total_bayar']; ?>
                <tr>
                    <td class="text-center"><?= $i++; ?></td>
                    <td><?= $p['no_tagihan']; ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($p['tgl_bayar'])); ?></td>
                    <td><?= $p['nama_pasien']; ?></td>
                    <td class="text-right">Rp <?= number_format($p['total_bayar'], 0, ',', '.'); ?></td>
                    <td class="text-center"><?= $p['metode_bayar']; ?></td>
                    <td class="text-center"><?= $p['status_pembayaran']; ?></td>
                </tr>
            <?php endforeach; ?>
            
            <?php if (empty($pembayaran)): ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pembayaran pada periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">GRAND TOTAL KESELURUHAN</th>
                <th class="text-right">Rp <?= number_format($totalSemua, 0, ',', '.'); ?></th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Jakarta, <?= date('d/m/Y'); ?></p>
        <br><br><br>
        <p><strong>Bagian Keuangan / Kasir</strong></p>
    </div>
</body>
</html>
