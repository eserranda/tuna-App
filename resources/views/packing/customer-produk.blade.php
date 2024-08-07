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
    <!--- Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Sweet Alert css-->
    <link href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('assets') }}/js/pages/sweetalerts.init.js"></script>

    <!--- Datatable -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    {{-- Moment.js untuk Memformat Tanggal di Frontend --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endpush
@section('title')
    <h4 class="mb-sm-0">Customer Produk</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Packing</a></li>
            <li class="breadcrumb-item active">data</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-8">
            <div class="d-flex flex-column h-100">
                <div class="row">

                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <div class="row align-items-start">
                                    <div class="col-sm-6 mb-2">
                                        Customer : <span class="fw-bold">{{ $data->customer->nama }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        Produk : <span class="fw-bold"> {{ $data->produk->nama }}</span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        Tanggal : <span class="fw-bold"> {{ $data->tanggal }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        Kode : <span class="fw-bold">{{ $data->kode }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-striped mt-0" id="dataTableProductLogs"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ILC</th>
                                            <th>Produk</th>
                                            <th>Berat(kg)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card mb-2">
                            {{-- <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Data Receiving</h4>
                            </div> --}}
                            <div class="card-body">
                                <form id="customerProdukForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="berat" class="form-label">Internal Lot Code</label>
                                            <input type="text" class="form-control bg-light"
                                                placeholder="Internal Lot Code" id="ilc" name="ilc" readonly>
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label for="no_ikan" class="form-label">Ekspor</label>
                                            <select class="form-select" id="ekspor" name="ekspor">
                                                <option selected disabled>Pilih Ekspor</option>
                                                <option value="USA">USA</option>
                                                <option value="EROPA">EROPA</option>
                                                <option value="JEPANG">JEPANG</option>
                                                <option value="LOCAL">LOCAL</option>
                                            </select>
                                            {{-- <input type="text" class="form-control" placeholder="Ekspor"
                                                    id="ekspor" name="ekspor"> --}}
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="text-start">
                                                <button type="submit" class="btn btn-primary">Buat Cutting</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Pilih Produk</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped mt-0 cuttingDatatable" id="cuttingDatatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ILC</th>
                                            <th>Ekspor</th>
                                            <th>Tanggal</th>
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
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        async function hapus(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '/cutting/' + id,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            console.log('Response:', response);
                            if (response.status) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                );
                                $('.cuttingDatatable').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data guru.',
                                    'error'
                                );
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data guru.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            const cuttingDataTable = $('.cuttingDatatable').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "search": "",
                    "searchPlaceholder": "Cari Data Cutting",
                },
                ajax: "{{ route('cutting.getAll') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',

                    },
                    {
                        data: 'ilc_cutting',
                        name: 'ilc_cutting',
                    },
                    {
                        data: 'ekspor',
                        name: 'ekspor',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return moment(data).format(
                                'DD-MM-YYYY'
                            );
                        }
                    },
                    {
                        data: 'checking',
                        name: 'checking',
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


            $(document).ready(function() {
                const customer_grup = "{{ $data->customer_grup }}";
                const datatable = $('.dataProduk').DataTable({
                    processing: true,
                    serverSide: true,
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '150px',
                    targets: 0,
                    language: {
                        "search": "",
                        "searchPlaceholder": "Cari Nama Produk",
                    },
                    ajax: "{{ url('/produk/productWithCustomerGroup') }}/" + customer_grup,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            orderable: false,

                        },
                        {
                            data: 'kode',
                            name: 'kode',
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


                const dataTableProductLogs = $('#dataTableProductLogs').DataTable({
                    processing: true,
                    serverSide: true,
                    language: {
                        "search": "",
                        "searchPlaceholder": "Cari Data Produk",
                    },
                    ajax: "{{ route('produk.get-all-product-log') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                        },
                        {
                            data: 'ilc',
                            name: 'ilc',
                            orderable: false,

                        },
                        {
                            data: 'id_produk',
                            name: 'id_produk',
                            orderable: false,

                        },
                        {
                            data: 'berat',
                            name: 'berat',
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
        });

        async function kodeILC(ilc) {
            document.getElementById('ilc').value = ilc;
        }

        document.getElementById('customerProdukForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            try {
                const response = await fetch('{{ route('cutting.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

                const data = await response.json();
                if (data.errors) {
                    Object.keys(data.errors).forEach(fieldName => {
                        const inputField = document.getElementById(fieldName);
                        if (inputField) {
                            inputField.classList.add('is-invalid');
                            if (inputField.nextElementSibling) {
                                inputField.nextElementSibling.textContent = data.errors[
                                    fieldName][0];
                            }
                        }
                    });

                    const validFields = document.querySelectorAll('.is-invalid');
                    validFields.forEach(validField => {
                        const fieldName = validField.id;
                        if (!data.errors[fieldName]) {
                            validField.classList.remove('is-invalid');
                            if (validField.nextElementSibling) {
                                validField.nextElementSibling.textContent = '';
                            }
                        }
                    });
                } else {
                    const invalidInputs = document.querySelectorAll('.is-invalid');
                    invalidInputs.forEach(invalidInput => {
                        invalidInput.value = '';
                        invalidInput.classList.remove('is-invalid');
                        const errorNextSibling = invalidInput.nextElementSibling;
                        if (errorNextSibling && errorNextSibling.classList.contains(
                                'invalid-feedback')) {
                            errorNextSibling.textContent = '';
                        }
                    });
                    form.reset();
                    $('.cuttingDatatable').DataTable().ajax.reload();
                }
            } catch (error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        });
    </script>
@endpush
