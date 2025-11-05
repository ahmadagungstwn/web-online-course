<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Transaksi Disetujui</title>
</head>

<body>
    <h2>Halo, {{ $transaction->student->name }} 👋</h2>

    <p>Transaksi kamu dengan ID <strong>{{ $transaction->booking_trx_id }}</strong> telah disetujui.</p>

    <p><strong>Detail Transaksi:</strong></p>
    <ul>
        <li>Kursus: {{ $transaction->pricing->name }}</li>
        <li>Total Pembayaran: Rp{{ number_format($transaction->grand_total_amount, 0, ',', '.') }}</li>
        <li>Tanggal Mulai: {{ $transaction->started_at }}</li>
        <li>Tanggal Berakhir: {{ $transaction->ended_at }}</li>
    </ul>

    <p>Terima kasih telah mempercayai layanan kami 🎉</p>
</body>

</html>
