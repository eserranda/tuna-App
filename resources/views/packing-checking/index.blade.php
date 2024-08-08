@extends('layouts.master')
@push('head_component')
    <style>
        .dataTables_filter {
            width: 100%;
            text-align: left;
            /* Memulai dari kiri */
            display: flex;
            justify-content: flex-start;
            /* Memulai dari kiri */
        }

        .dataTables_filter label {
            width: 100%;
            display: flex;
            justify-content: flex-start;
            /* Memulai dari kiri */
        }

        .dataTables_filter input {
            width: auto;
            flex: 1;
            /* Menyesuaikan lebar input dengan kontainer */
        }
    </style>
    <!-- Sweet Alert css-->
    <link href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('assets') }}/js/pages/sweetalerts.init.js"></script>

    <!--- Datatable -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
@endpush

@section('title')
    <h4 class="mb-sm-0">Retouching Checking</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Checking</a></li>
            <li class="breadcrumb-item active">data</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-8">
            <div class="d-flex flex-column h-100">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Checking Data</h4>
                        {{-- <div class="flex-shrink-0">
                            <a href={{ route('supplier.add') }} class="btn btn-info ">Tambah Supplier</a>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <table class="table datatable table-bordered dt-responsive nowrap w-100" id="datatable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ILC</th>
                                    <th>Lab. Check</th>
                                    <th>Penampakan</th>
                                    <th>Bau</th>
                                    <th>Es</th>
                                    <th>Suhu</th>
                                    <th>Parasite</th>
                                    <th>Label</th>
                                    <th>Persen</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('packing-checking.edit')
@endsection
@push('scripts')
    <script>
        function update(id, ilc) {
            $('#updateModal').modal('show');
            $('#updateModal').find('#id').val(id);
            $('#updateModal').find('#ilc').val(ilc);
        }

        $(document).ready(function() {
            const datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "search": "",
                    "searchPlaceholder": "Cari Data",
                },
                ajax: "{{ route('packing-checking.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,

                    },
                    {
                        data: 'ilc',
                        name: 'ilc',

                    },
                    {
                        data: 'uji_lab',
                        name: 'uji_lab',
                        orderable: false,

                    },
                    {
                        data: 'penampakan',
                        name: 'penampakan',
                        orderable: false,

                    },
                    {
                        data: 'bau',
                        name: 'bau',
                        orderable: false,

                    },
                    {
                        data: 'es',
                        name: 'es',
                        orderable: false,
                    },
                    {
                        data: 'suhu',
                        name: 'suhu',
                        orderable: false,
                    },
                    {
                        data: 'parasite',
                        name: 'parasite',
                        orderable: false,
                    },
                    {
                        data: 'label',
                        name: 'label',
                        orderable: false,
                    },
                    {
                        data: 'hasil',
                        name: 'hasil',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ],
                dom: 'Bftp',
            });
        });
    </script>
@endpush
