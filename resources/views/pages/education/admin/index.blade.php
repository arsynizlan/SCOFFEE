@extends('layouts.master')

@section('title')
    <div class="page-heading">
        <h3>Education</h3>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card mb-3">
            <div class="card-header">
                <button type="button" class="btn btn-outline-primary block" onclick="create()">
                    Create Edukasi
                </button>
            </div>
            <div class="card-body">
                <!-- table head dark -->
                <div class="table-responsive">
                    <table class="table mb-0" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Created At</th>
                                <th>Title</th>
                                <th>Category</th>
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
    @include('components.modals.event.admin.education.addEducation')
    @include('components.modals.event.admin.education.editEducation')

@endsection


@push('script')
    @include($script)
@endpush
