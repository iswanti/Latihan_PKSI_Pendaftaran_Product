<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Produk</h2>

        <a href="/products/create" class="btn btn-primary">
            Tambah Produk
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Dokumen</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @foreach($products as $product)

        <tr>
            <td>{{ $product->kode_produk }}</td>
            <td>{{ $product->nama_produk }}</td>
            <td>{{ $product->kategori }}</td>
            <td>Rp {{ number_format($product->harga,0,',','.') }}</td>

            <td>
                @if($product->dokumen)
                    <a href="{{ asset('storage/products/'.$product->dokumen) }}"
                       class="btn btn-success btn-sm"
                       target="_blank">
                        Lihat
                    </a>
                @endif
            </td>

            <td>

                <a href="/products/{{ $product->id }}/edit"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="/products/{{ $product->id }}"
                      method="POST"
                      class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm">
                        Hapus
                    </button>

                </form>

            </td>
        </tr>

        @endforeach

        </tbody>

    </table>

</div>

</body>
</html>