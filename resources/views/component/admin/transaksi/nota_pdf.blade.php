<!DOCTYPE html>
<html>

<head>
    <title>Nota Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
        }

        .nota-table {
            width: 100%;
            border-collapse: collapse;
        }

        .nota-table th,
        .nota-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }

        .nota-table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .nota-table td:first-child {
            width: 60%;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>NOTA PEMBELIAN</h3>
        <span>{{ $transaksi->tgl_pemesanan }}</span><br>
        <table class="nota-table">
            <tr>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
            @foreach ($data as $value)
            <tr>
                <td>{{ $value->bahanBaku->nama }}</td>
                <td>{{ $value->jumlah }}</td>
                <td>Rp. {{ number_format($value->bahanBaku->harga) }}</td>
            </tr>
            @endforeach
        </table>
        <div class="total">
            Total: Rp. {{ number_format($transaksi->total) }}
        </div>
    </div>
</body>

</html>