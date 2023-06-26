@extends('layouts.admin-app')

@section('title')
Barang Masuk
@endsection

@section('content')
<section class="table-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Data Barang Masuk</h2>
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
                                        <th>Bahan Baku</th>
                                        <th>total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $data as $data )
                                    <tr>
                                        <td>{{ $data->tanggal }}</td>
                                        <td>{{ $data->bahanBaku->nama }}</td>
                                        <td>{{ $data->total }}</td>
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