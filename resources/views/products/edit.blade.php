<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <div class="card">

        <div class="card-header bg-warning">
            Edit Produk
        </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="/products/{{ $product->id }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Kode Produk</label>
                    <input type="text"
                           name="kode_produk"
                           value="{{ $product->kode_produk }}"
                           class="form-control">
                    @error('kode_produk')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text"
                           name="nama_produk"
                           value="{{ $product->nama_produk }}"
                           class="form-control">
                    @error('nama_produk')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text"
                           name="kategori"
                           value="{{ $product->kategori }}"
                           class="form-control">
                    @error('kategori')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number"
                           name="harga"
                           value="{{ $product->harga }}"
                           class="form-control">
                    @error('harga')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi"
                              class="form-control"
                              rows="4">{{ $product->deskripsi }}</textarea>
                    @error('deskripsi')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Upload Dokumen Baru</label>
                    <input type="file"
                           name="dokumen"
                           class="form-control">
                    @error('deskripsi')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit"
                        class="btn btn-primary">
                    Update
                </button>

                <a href="/products"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
