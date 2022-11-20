@extends('layouts.master')

@section('title')
    <div class="page-heading">
        <h3>Events</h3>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card mb-3">
            {{-- <div class="card-header">
                <button type="button" class="btn btn-outline-primary block" onclick="create()">
                    Tambah Event
                </button>
            </div> --}}

            <div class="card-body">
                <!-- table head dark -->
                <div class="table-responsive">
                    <table class="table mb-0" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Event</th>
                                <th>Nama Pembuat</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    {{-- @include('components.modals.category.create')
    @include('components.modals.category.edit')
    @include('components.modals.category.import') --}}
@endsection


@push('script')
    @include($script)
@endpush
