<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Data Laporan Pengadu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>
    <h2 style="text-align: center">Daftar Rekap Transaksi</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Status</th>
                <th scope="col">Jumlah Bayar</th>
                <th scope="col">Total</th>
                <th scope="col">Keterangan</th>
        </thead>
        <tbody>
            @foreach ( $data as $items )
            <tr>
                <td>{{ $items->tgl_pemesanan }}</td>
                <td>{{ $items->status }}</td>
                <td>Rp.{{ number_format($items->jumlah_bayar) }}</td>
                <td>Rp.{{ number_format($items->total) }}</td>
                <td>{{ $items->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>