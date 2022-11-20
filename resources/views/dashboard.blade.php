@extends('layouts.master')

@section('title')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
@endsection

@section('content')
    <div class="alert alert-info mt-3">
        <h4 class="alert-heading">{{ ucwords(Auth::user()->name) }}</h4>
        <p>
            <span class="text-secondary text-white">Sebagai : {{ Auth::user()->getRoleNames()[0] }}</span>
        </p>
    </div>
@endsection

@push('script')
@endpush
