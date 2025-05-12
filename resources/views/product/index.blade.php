@extends('layouts.app')

@section('content')
<style>
    td, tr{
        border : 1px solid black;
    }
</style>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Data Produk</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Data Produk</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Data Produk</h5>

            <table class="table table-bordered">
              <thead class="table-light">
                <tr class="text-center">
                  <th>No</th>
                  <th>Produk</th>
                  <th>Deskripsi Produk</th>
                  <th>Gambar Produk</th>
                  <th>Aksi</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                   
                @foreach ($product as $index => $produk)
                    @php 
                        $categories = App\Models\Category_product::where('product_id', $produk->id)->get(); 
                        $rowspan = $categories->count() ? $categories->count() + 1 : 1;
                    @endphp

                    @foreach ($categories as $key => $kategori)
                        @php
                            $kategori_image = \App\Models\Image_product::where('category_id', $kategori->id)->first();
                        @endphp
                        <tr>
                            @if ($key === 0)
                                <td rowspan="{{ ($categories->count() < 3) ? $rowspan : $rowspan - 1 }}" class="align-middle text-center">{{ $index + 1 }}</td>
                                <td rowspan="{{ ($categories->count() < 3) ? $rowspan : $rowspan - 1 }}" class="align-middle text-center" onclick="editProduct(this)" data-product_id="{{ $produk->id }}" data-product_name="{{ $produk->name }}">{{ $produk->name }}</td>
                            @endif
                            <td class="align-middle text-center" onclick="editKategori(this)" data-category_id="{{ $kategori->id }}" data-category_description="{{ $kategori->description }}">{{ $kategori->description }}</td>
                            <td class="text-center">
                                @if ($kategori_image)
                                    <img src="{{ asset('img_product/' . $kategori_image->image) }}" height="100px" width="auto" alt="gambar" width="50" onclick="editGambar(this)" data-image_id="{{ $kategori_image->id }}"><br>
                                    <button class="btn btn-sm btn-outline-danger mt-3 delete_image_product" data-image_product_id="{{ $kategori_image->id }}"><i class="bi bi-trash"></i></button>
                                @else
                                    <button class="btn btn-sm btn-primary d-block mx-auto" onclick="uploadGambar(this)" data-kategori_id="{{ $kategori->id }}"><i class="bi bi-upload"></i></button>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-sm btn-outline-danger delete_category_product" data-category_id="{{ $kategori->id }}"><i class="bi bi-x"></i></button>
                            </td>
                            @if ($key === 0)
                                <td rowspan="{{ ($categories->count() < 3) ? $rowspan : $rowspan - 1 }}" class="text-center align-middle">
                                    <button class="btn btn-sm btn-danger delete_product" data-product_id="{{ $produk->id }}">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                        @if ($loop->last && $categories->count() < 3)
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-success" onclick="tambahKategori(this)" data-product_id="{{ $produk->id }}">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach

                    @if ($categories->isEmpty())
                        <tr>
                            <td class="align-middle text-center">{{ $index + 1 }}</td>
                            <td class="align-middle text-center" onclick="editProduct(this)" data-product_id="{{ $produk->id }}" data-product_name="{{ $produk->name }}">{{ $produk->name }}</td>
                            <td></td>
                            <td></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-success" onclick="tambahKategori(this)" data-product_id="{{ $produk->id }}">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </td>
                            <td  class="text-center">
                                <button class="btn btn-sm btn-danger delete_product" data-product_id="{{ $produk->id }}"><i class="bi bi-x"></i></button>
                            </td>
                        </tr>
                    @endif
                @endforeach

                @if($product->count() < 5)
                    <tr>
                        <td class="align-middle text-center">{{ ($product) ? $product->count() + 1 : 1 }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#produk">
                                <i class="bi bi-plus"></i>
                            </button>
                        </td>
                    </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>

<!-- Modal Tambah produk -->
<div class="modal fade" id="produk" tabindex="-1" aria-labelledby="produkLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="produkLabel">Tambah Produk</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit produk -->
<div class="modal fade" id="product_edit" tabindex="-1" aria-labelledby="produkLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('edit_product') }}" method="POST" enctype="multipart/form-data">
      @method('PUT')
      @csrf
      <input type="hidden" name="product_id" id="edit_product_id">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="produkLabel">Edit Produk</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="form_product_name" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="kategori" tabindex="-1" aria-labelledby="kategoriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('create_category') }}" method="POST" enctype="multipart/form-data" id="kategoriForm">
      @csrf
      <input type="hidden" id="product_id_kategori" name="product_id">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="kategoriLabel">Tambah Kategori</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="form_deskripsi" class="form-label">Deskripsi Kategori Produk</label>
            <input type="text" class="form-control" name="description" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="kategori_edit" tabindex="-1" aria-labelledby="kategoriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('edit_category') }}" method="POST" enctype="multipart/form-data" id="kategoriForm">
      @method('PUT')
      @csrf
      <input type="hidden" id="category_id" name="category_id">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="kategoriLabel">Edit Kategori</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="form_deskripsi" class="form-label">Deskripsi Kategori Produk</label>
            <input type="text" class="form-control" id="form_category_description" name="description" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tambah image -->
<div class="modal fade" id="image" tabindex="-1" aria-labelledby="kategoriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('create_image') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" id="kategori_id_image" name="category_id">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="kategoriLabel">Tambah Image</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit image -->
<div class="modal fade" id="edit_image" tabindex="-1" aria-labelledby="kategoriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('edit_image') }}" method="POST" enctype="multipart/form-data">
      @method('PUT')
      @csrf
      <input type="hidden" id="category_image_id" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="kategoriLabel">Edit Image</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="form_image" name="image" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script>

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: @json(session('success')),
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    @if(session('max') == 1)
        setTimeout(() => {
            Swal.fire({
                icon: 'warning',
                title: 'Jumlah kategori maksimum tercapai!',
                showConfirmButton: false,
                timer: 1500
            });
        }, 2000);
    @endif

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    $('.delete_product').on('click', function () {
        const productId = $(this).data('product_id');
        let baseUrl = "{{ route('product.destroy', ':id') }}"; 
        baseUrl = baseUrl.replace(':id', productId);

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus produk ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#D22B2B',
            cancelButtonColor: '#808080',
            confirmButtonText: '  Hapus',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl,
                    type: 'GET',
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Produk berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });
    });

    $('.delete_image_product').on('click', function () {
        const productId = $(this).data('image_product_id');
        let baseUrl = "{{ route('delete_image', ':id') }}"; 
        baseUrl = baseUrl.replace(':id', productId);

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus gambar ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#D22B2B',
            cancelButtonColor: '#808080',
            confirmButtonText: '  Hapus',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl,
                    type: 'GET',
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Gambar berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });
    });

    $('.delete_category_product').on('click', function () {
        const productId = $(this).data('category_id');
        let baseUrl = "{{ route('delete_category', ':id') }}"; 
        baseUrl = baseUrl.replace(':id', productId);

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus category ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#D22B2B',
            cancelButtonColor: '#808080',
            confirmButtonText: '  Hapus',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl,
                    type: 'GET',
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Category berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });
    });

    function tambahKategori(button) {
        const productId = button.getAttribute('data-product_id');
        document.getElementById('product_id_kategori').value = productId;
        const modal = new bootstrap.Modal(document.getElementById('kategori'));
        modal.show();
    }

    function editKategori(button) {
        const categoryId = button.getAttribute('data-category_id');
        const description = button.getAttribute('data-category_description');

        document.getElementById('category_id').value = categoryId;
        document.getElementById('form_category_description').value = description;

        const modal = new bootstrap.Modal(document.getElementById('kategori_edit'));
        modal.show();
    }

    function editProduct(button) {
        const productId = button.getAttribute('data-product_id');
        const name = button.getAttribute('data-product_name');

        document.getElementById('edit_product_id').value = productId;
        document.getElementById('form_product_name').value = name;

        const modal = new bootstrap.Modal(document.getElementById('product_edit'));
        modal.show();
    }

    function uploadGambar(button) {
        const kategoriId = button.getAttribute('data-kategori_id');
        document.getElementById('kategori_id_image').value = kategoriId;
        const modal = new bootstrap.Modal(document.getElementById('image'));
        modal.show();
    }

    function editGambar(button) {
        const imageId = button.getAttribute('data-image_id');
        
        document.getElementById('category_image_id').value = imageId;
        const modal = new bootstrap.Modal(document.getElementById('edit_image'));
        modal.show();
    }
</script>
@endsection
