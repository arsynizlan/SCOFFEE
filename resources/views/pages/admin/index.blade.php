@extends('layouts.master')

@section('title')
    <div class="page-heading">
        <h3>User</h3>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card mb-3">

            <div class="card-body">
                <!-- table head dark -->
                <div class="table-responsive">
                    <table class="table mb-0" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                {{-- <th>Status</th> --}}
                                <th width="20%">Image</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    {{-- @include('components.modals.event.editstatus') --}}
@endsection


@push('script')
    @include($script)
@endpush
