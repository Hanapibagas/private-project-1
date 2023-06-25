@extends('layouts.suplier-app')

@section('title')
Barang Keluar
@endsection

@section('content')
<section class="table-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Data Barang Keluar</h2>
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
                                        <th>Tanggal</th>
                                        <th>Harga</th>
                                        <th>Satuan</th>
                                        <th>Stok</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $bahankeluar as $data )
                                    <tr>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->harga }}</td>
                                        <td>{{ $data->satuan }}</td>
                                        <td>{{ $data->stok }}</td>
                                        <td>
                                            <img src="{{ Storage::url($data->gambar) }}" alt="" style="width: 150px"
                                                class="img-thumbnail">
                                        </td>
                                    </tr>
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
@endsection

@push('js')
<script>
    const dataTable = new simpleDatatables.DataTable("#table", {
      searchable: true,
    });
</script>
@endpush