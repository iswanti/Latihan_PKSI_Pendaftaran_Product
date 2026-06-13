<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    @if(session('success'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });

        });
        </script>
    @endif

    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold">Daftar Produk</h2>
        <p class="text-muted mb-0">
            Kelola data produk yang telah terdaftar.
        </p>
    </div>

    <!-- Search dan Tombol Tambah -->
    <div class="row mb-4">

        <div class="col-md-10">
            <form action="/products" method="GET">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari kode produk, nama produk, dan kategori..." value="{{ request('keyword') }}">

                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>
                    <a href="/products" class="btn btn-secondary">
                    Reset
                </a>
                </div>
            </form>
        </div>

        <div class="col-md-2 text-end">
            <a href="/products/create" class="btn btn-success">
                + Tambah Produk
            </a>
        </div>

    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
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
            <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }} </td>
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

                <form action="/products/{{ $product->id }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')

                    <button type="button"
                            class="btn btn-danger btn-sm btn-delete">
                        Hapus
                    </button>

                </form>
            </td>
        </tr>

        @endforeach

        </tbody>

    </table>
    <div class="d-flex justify-content-center mt-3">

        {{ $products->links() }}

    </div>

</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-delete').forEach(button => {

    button.addEventListener('click', function() {

        let form = this.closest('.delete-form');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});
</script>
</html>