@extends('layouts.gudang-app')

@section('title')
Dashboard
@endsection

@section('content')
<section class="section">
    <div class="container-fluid">
        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-8">
                <div class="card-style calendar-card mb-30">
                    <div id="calendar-mini"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection