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
                            <div class="col-md-5">
                                @foreach ($list->detailTransaksi as $value)
                                <div class="col-md-12 m-0">
                                    <div class="card p-2 mb-1">
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
                                                    <span>
                                                        <strong>Harga : Rp.
                                                            {{ number_format($value->bahanBaku->harga) }}
                                                        </strong>
                                                    </span>
                                                    <span>jumlah : {{ $value->jumlah }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-7">
                                <div class="card p-3">
                                    <div class="d-flex flex-column">
                                        <span>Tanggal Pemesanan : {{ $list->tgl_pemesanan }}</span>
                                        <span>
                                            <strong>Total Harga : Rp.
                                                {{ number_format($list->total) }}
                                            </strong>
                                        </span>
                                        @if ($list->bukti_bayar == null)
                                        <span>Status :
                                            <span class="badge bg-secondary">Belum Bayar</span>
                                        </span>
                                        <a href="javascript:void(0)" class="bayar btn btn-success mt-3"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            data-id='{{ $list->id }}' data-total='{{ $list->total }}'> <i
                                                class="fa fa-money fa-lg" aria-hidden="true"></i> Lakukan
                                            Pembayaran</a>
                                        @elseif ($list->status == 'proses')
                                        <span>Status :
                                            <span class="badge bg-primary">{{ $list->status }}</span>
                                        </span>
                                        @if ($list->keterangan != null)
                                        <span class="text-danger" style="font-size: 13px">
                                            {{ $list->keterangan }}</span>
                                        @endif
                                        <a href="javascript:void(0)" class="bukti-bayar btn btn-secondary mt-3"
                                            data-id='{{ $list->id }}'>
                                            <i class="fa fa-file-archive-o" aria-hidden="true"></i> Bukti
                                            bayar</a>
                                        @elseif ($list->status == 'selesai')
                                        <span>Status :
                                            <span class="badge bg-success">{{ $list->status }}</span>
                                        </span>
                                        @if ($list->keterangan != null)
                                        <span class="text-danger" style="font-size: 13px">
                                            {{ $list->keterangan }}</span>
                                        @endif
                                        <a href="print-nota/{{ $list->id }}" class="btn btn-primary mt-3"
                                            target="_blank"> <i class="fa fa-print fa-lg" aria-hidden="true"></i> Cetak
                                            Nota</a>
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
        <!-- Modal pembayaran-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('payment') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type=hidden id="id" name="id">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jumlah Bayar</label>
                                <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Bukti Bayar</label>
                                <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar" required>
                            </div>
                            <div class="total mt-2">
                                <h5 id="total_bayar"></h5>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal bukti bayar-->
        <div class="modal fade" id="modal-bukti-bayar" tabindex="-1" aria-labelledby="modal-bukti-bayar-label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-bukti-bayar-label">Bukti Bayar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div id="bukti_image"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.bayar').click(function() {
            var totalBayar = document.getElementById('total_bayar');
            var id = this.getAttribute('data-id');
            var total = this.getAttribute('data-total');
            document.getElementById('id').value = id;
            formated = parseFloat(total).toLocaleString(undefined, {
                minimumFractionDigits: 0
            });

            totalBayar.textContent = "Total harga : Rp. " + formated;
        });
</script>

<script>
    $('.bukti-bayar').click(function() {
            var id = this.getAttribute('data-id');
            var url = '/get-bukti-bayar/' + id;
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    var modal = new bootstrap.Modal(document.getElementById('modal-bukti-bayar'));

                    $('#bukti_image').html('')
                    if (data.bukti_bayar) {
                        $('#bukti_image').append(
                            `  <img src="{{ asset('storage/${data.bukti_bayar}') }}"  width="100%" >`
                        );
                    }
                    // Tampilkan modal setelah mengambil data
                    modal.show();
                })
                .catch(error => {
                    // Handle any errors
                    console.error('Error:', error);
                });
        });
</script>
<script>
    function bukaTab(url) {
            window.open(url, '_blank');
        }
</script>
@endpush