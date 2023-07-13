@extends('layouts.admin-app')

@section('title')
Product Expired
@endsection

@section('content')
<section class="table-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Data Product Expired</h2>
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
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($layak as $data)
                                    <tr>
                                        <td>{{ $data->nama_product }}</td>
                                        <td>{{ $data->keterangan }}</td>
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
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Data laporan transaksi </h2>
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
                                        <th>Status</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Total</th>
                                        <th>Keterangan</th>
                                        <th>Bukti Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi as $data)
                                    <tr>
                                        <td>{{ $data->tgl_pemesanan }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td>Rp.{{ number_format($data->jumlah_bayar) }}</td>
                                        <td>Rp.{{ number_format($data->total) }}</td>
                                        <td>{{ $data->keterangan }}</td>
                                        <td>
                                            <img src="{{ Storage::url($data->bukti_bayar) }}" alt=""
                                                style="width: 150px" class="img-thumbnail">
                                        </td>
                                    </tr>
                                    @endforeach
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