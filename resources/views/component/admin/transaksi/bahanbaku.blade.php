@extends('layouts.admin-app')

@section('title')
Bahan Baku
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
        <div class="row mt-5">
            @forelse ($data as $list)
            <div class="col-6 col-sm-3 pb-4">
                <form action="{{ route('store.cart') }}" method="post">
                    @csrf
                    <input type="hidden" name="bahan_baku" value="{{ $list->id }}">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="image text-center">
                                <img src="{{ Storage::url($list->gambar) }}" style="width:70%">
                            </div>
                            <div class="d-flex flex-column">
                                <span>{{ $list->nama }}</span>
                                <span><strong>Rp. {{ number_format($list->harga) }}</strong></span>
                                <span>Stok : {{ $list->stok }}</span>
                                <span>{{ $list->users->name }}</span>
                                <span>
                                    <button type="submit" class="btn btn-success" style="width:100%">tambah <i
                                            class="fa fa-cart-plus fa-lg" aria-hidden="true"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @empty
            <div class="col-md-12">
                <h3 class="text-center text-danger">Bahan baku belum tersedia</h3>
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