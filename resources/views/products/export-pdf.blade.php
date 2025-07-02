<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Data Produk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Developer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->category }}</td>
                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->developer }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 