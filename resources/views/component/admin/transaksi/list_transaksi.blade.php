@extends('layouts.admin-app')

@section('title')
    List Transaksi
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

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: "{{ session('warning') }}",
            });
        </script>
    @endif

    <section class="table-components">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-12 bg-white p-4">
                        <div class="title">
                            <h2>List Transaksi</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                @forelse ($data as $list)
                    <div class="col-md-12 mb-3">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @foreach ($list->detailTransaksi as $value)
                                            <div class="col-md-10">
                                                <div class="card p-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="image">
                                                                <img src="{{ asset('storage/bahan-baku-suplier/' . $value->bahanBaku->gambar) }}"
                                                                    style="width:70%">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="d-flex flex-column">
                                                                <span>Nama barang : {{ $value->bahanBaku->nama }}</span>
                                                                <span><strong>Harga : Rp.
                                                                        {{ number_format($value->bahanBaku->harga) }}</strong>
                                                                </span>
                                                                <span>jumlah : {{ $value->jumlah }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-3">
                                            <div class="d-flex flex-column">
                                                <span>Tanggal Pemesanan : {{ $list->tgl_pemesanan }}</span>
                                                <span><strong>Total Harga : Rp.
                                                        {{ number_format($list->total) }}</strong>
                                                </span>
                                                @if ($list->bukti_bayar == null)
                                                    <span>Status : <div class="bg-secondary p-2">belum bayar</div></span>
                                                @elseif ($list->status == 'proses')
                                                    <span>Status : <div class="bg-primary p-2">{{ $list->status }}</div>
                                                    </span>
                                                @elseif ($list->status == 'selesai')
                                                    <span>Status : <div class="bg-success p-2">{{ $list->status }}</div>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <h3 class="text-center text-danger">Daftar transaksi belum ada </h3>
                    </div>
                @endforelse
            </div>
            <div class="paginate">
                {{ $data->links() }}
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush
