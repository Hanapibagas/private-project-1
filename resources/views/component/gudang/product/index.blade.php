@extends('layouts.gudang-app')

@section('title')
Product Expired
@endsection

@section('content')

@if (session('status'))
<script>
    Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "{{ session('status') }}",
            });
</script>
@endif

<section class="table-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Data Product Expired</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ul class="buttons-group">
                                <li class="breadcrumb-item">
                                    <a type="button" class="main-btn success-btn rounded-md btn-hover"
                                        data-toggle="modal" data-target="#tambahDataModal">+ Tambah Data</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead>
                                    <tr>
                                        <th>Nama product</th>
                                        <th>Tanggal pembuatan</th>
                                        <th>Jumlah barang</th>
                                        <th>keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expired as $data)
                                    <tr>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->total }}</td>
                                        <td>{{ $data->jumlah }}</td>
                                        <td>{{ $data->keterangan }}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#tambahDataModal-{{ $data->id }}"
                                                class="btn btn-primary">
                                                <i class="lni lni-pencil" style="color: whitesmoke"></i>
                                            </a>
                                            <form action="{{ route('get.DeleteProductExpired', $data->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger delete-btn" data-id="{{ $data->id }}">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </form>
                                            </p>
                                        </td>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Product Expired</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('get.StoreProductExpired') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_product">Nama Product</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_product">Tanggal Pembuatan</label>
                        <input type="date" class="form-control" id="total" name="total" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_product">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                    </div>
                    <button type="submit" style="margin-top: 10px;" class="btn btn-primary">Tambah Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ( $expired as $expireds )
<div class="modal fade" id="tambahDataModal-{{ $expireds->id }}" tabindex="-1" role="dialog"
    aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Product Expired</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('get.UpdateProductExpired', $expireds->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="nama_product">Nama Product</label>
                        <input type="text" value="{{ $expireds->nama }}" class="form-control" id="nama" name="nama"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="nama_product">Tanggal Pembuatan</label>
                        <input type="date" value="{{ $expireds->total }}" class="form-control" id="total" name="total"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="nama_product">Jumlah Barang</label>
                        <input type="number" value="{{ $expireds->jumlah }}" class="form-control" id="jumlah"
                            name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan"
                            required>{{ $expireds->keterangan }}</textarea>
                    </div>
                    <button type="submit" style="margin-top: 10px;" class="btn btn-primary">Tambah Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SweetAlert Delete Confirmation
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const form = button.parentNode;
                const id = button.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus data ini!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
    const dataTable = new simpleDatatables.DataTable("#table", {
            searchable: true,
        });
</script>
@endpush