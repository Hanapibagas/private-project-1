@extends('layouts.gudang-app')

@section('title')
Dashboard
@endsection

@section('content')
<div class="container-fluid">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon success">
                    <i class="lni lni-timer"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Transaksi Pending</h6>
                    <h3 class="text-bold mb-10">$74,567</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon primary">
                    <i class="lni lni-checkmark"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Transaksi Sukses</h6>
                    <h3 class="text-bold mb-10">$24,567</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection