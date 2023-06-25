@extends('layouts.suplier-app')

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
            <div class="col-md-12 mb-3 pembungkus">
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
                                                    <img src="{{ Storage::url($value->bahanBaku->gambar) }}"
                                                        style="width:70%">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="d-flex flex-column">
                                                    <input type="text" hidden class="bahanbakuid"
                                                        value="{{ $value->bahanBaku->id }}">
                                                    <span>Nama barang : {{ $value->bahanBaku->nama }}</span>
                                                    <span>Nama suplier : {{ $value->bahanBaku->users->name }}</span>
                                                    <span>
                                                        <strong>Harga : Rp.
                                                            {{ number_format($value->bahanBaku->harga) }}
                                                        </strong>
                                                    </span>
                                                    <span>jumlah : {{ $value->jumlah }}</span>
                                                    <input type="text" hidden class="total_checkout"
                                                        value="{{ $value->jumlah }}">
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
                                        <a href="" class="bayar btn btn-success mt-3" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-{{ $list->id }}"> <i class="fa fa-money fa-lg"
                                                aria-hidden="true"></i> Lakukan
                                            pemproses</a>
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

        @foreach ( $data as $datas )
        <div class="modal fade" id="exampleModal-{{ $datas->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('get.update.suplier', $datas->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Ubah Status</label>
                                <select name="status" class="form-control">
                                    <option value="">{{ $datas->status }}</option>
                                    <option value="">-- Silahkan ubah status --</option>
                                    <option value="proses">Proses</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Bukti Bayar</label>
                                <img style="width: 100%;" src="{{ Storage::url($datas->bukti_bayar) }}" alt=""
                                    srcset="">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kirim pembaruan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection

@push('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function bukaTab(url) {
            window.open(url, '_blank');
        }
</script>
<script>
    // Mengambil semua elemen dengan class "pembungkus"
const pembungkusElements = document.querySelectorAll('.pembungkus');

// Loop melalui setiap elemen pembungkus
pembungkusElements.forEach((pembungkus) => {
  // Mengambil tombol "Lakukan proses" di dalam elemen pembungkus
  const tombolProses = pembungkus.querySelector('.bayar');

  // Menambahkan event click listener pada tombol "Lakukan proses"
  tombolProses.addEventListener('click', () => {
    // Mengambil ID modal berdasarkan atribut data-bs-target pada tombol "Lakukan proses"
    const modalId = tombolProses.dataset.bsTarget;

    // Mengambil semua elemen dengan class "bahanbakuid" dan "total_checkout" di dalam elemen pembungkus
    const bahanBakuIdElements = pembungkus.querySelectorAll('.bahanbakuid');
    const totalElements = pembungkus.querySelectorAll('.total_checkout');

    // Membuat objek untuk mengelompokkan data berdasarkan bahan_baku ID
    const data = {};

    // Loop melalui setiap elemen bahanbakuid dan total_checkout
    bahanBakuIdElements.forEach((element, index) => {
      const bahanBakuId = element.value;
      const total = totalElements[index].value;

      // Jika bahan_baku ID belum ada dalam objek data, tambahkan array kosong untuk bahan_baku ID tersebut
      if (!data[bahanBakuId]) {
        data[bahanBakuId] = [];
      }

      // Tambahkan total ke dalam array yang sesuai dengan bahan_baku ID
      data[bahanBakuId].push(total);
    });

    // Memasukkan data ke dalam modal
    const modal = document.querySelector(modalId);
    const modalBody = modal.querySelector('.modal-body');
    // modalBody.innerHTML = '';

    for (const bahanBakuId in data) {
      const totalList = data[bahanBakuId];

      const bahanBakuIdInput = document.createElement('input');
      bahanBakuIdInput.type = 'hidden';
      bahanBakuIdInput.name = 'bahan_baku_id[]';
      bahanBakuIdInput.value = bahanBakuId;
      modalBody.appendChild(bahanBakuIdInput);

      const jumlahInput = document.createElement('input');
      jumlahInput.type = 'hidden';
      jumlahInput.name = 'jumlah[]';
      jumlahInput.value = totalList.join(', ');
      modalBody.appendChild(jumlahInput);
    }

    // Tampilkan modal
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
  });
});
</script>
@endpush