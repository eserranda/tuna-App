@extends('layouts.master')
@push('head_component')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title')
    <h4 class="mb-sm-0">Receiving</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Receving</a></li>
            <li class="breadcrumb-item active">data</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-5">
            <div class="d-flex flex-column h-100">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Buat Receving Baru</h4>
                            </div>
                            <div class="card-body">
                                <form action="javascript:void(0);">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="nama" class="form-label">Supplier</label>
                                            <select class="js-example-basic-single" name="nama">
                                                <option value="AL">Alabama</option>
                                                <option value="MA">Madrid</option>
                                                <option value="TO">Toronto</option>
                                                <option value="LO">Londan</option>
                                                <option value="WY">Wyoming</option>
                                            </select>
                                        </div>
                                        {{-- <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Supplier</label>
                                                <input type="text" class="form-control" placeholder="Nama Supplier"
                                                    id="nama">
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_plat" class="form-label">No. Plat Kendaraan</label>
                                                <input type="text" class="form-control" placeholder="No Plat Kendaraan"
                                                    id="no_plat" required>
                                                <div class="invalid-feedback">
                                                    dsfsd
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" placeholder="Tanggal"
                                                    id="tanggal">
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-2">
                                            <div class="text-start">
                                                <button type="submit" class="btn btn-primary">Buat Receiving</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Data Receiving</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped mt-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Internal Lot Code</th>
                                            <th>Status</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>TES</td>
                                            <td>TES12321321</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->





            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets') }}/js/pages/select2.init.js"></script>
@endpush
