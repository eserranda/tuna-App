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
                                            <th>Berat</th>
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
                                <form id="customerPackingProductForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="ilc" class="form-label">Internal Lot Code</label>
                                            <input type="text" class="form-control bg-light"
                                                placeholder="Internal Lot Code" id="ilc" name="ilc" readonly>
                                            <div class="invalid-feedback"> </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label for="berat" class="form-label">Berat (Kg)</label>
                                            <input type="text" class="form-control bg-light" placeholder="Berat"
                                                id="berat" name="berat" readonly>
                                            <div class="invalid-feedback"> </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="text-start">
                                                <button type="submit" class="btn btn-primary">Packing</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Produk yang telah di packing untuk Customers
                                    <span class="fw-bold">
                                        {{ $data->customer->nama }}
                                    </span>
                                </h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped mt-0 " id="costumerProdukDatatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ILC</th>
                                            <th>Berat</th>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('keydown', function(event) {
                // Cek apakah tombol yang ditekan adalah "Enter"
                if (event.key === 'Enter') {
                    // Ambil value dari input yang di-scan
                    let scanValue = event.target.value;

                    // Pisahkan kode ILC dan berat
                    const [ilcCode, berat] = scanValue.split('-');

                    // Validasi format data
                    if (ilcCode && berat) {
                        // Masukkan nilai ILC ke dalam input 'ilc'
                        document.getElementById('ilc').value = ilcCode;

                        // Masukkan nilai berat ke dalam input 'berat'
                        document.getElementById('berat').value = parseFloat(berat).toFixed(2);

                        // Kosongkan input scanner setelah proses
                        event.target.value = '';

                        // Cegah aksi default (misalnya, pengiriman form atau perpindahan focus)
                        event.preventDefault();
                    }
                }
            });
        });

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
                        url: '/customer-product/' + id,
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
                                $('#costumerProdukDatatable').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            });
        }


        $(document).ready(function() {
            const id_produk = "{{ $data->id_produk }}";
            const dataTableProductLogs = $('#dataTableProductLogs').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "search": "",
                    "searchPlaceholder": "Cari Data Produk",
                },
                ajax: "{{ url('/produk/getAllDataProductLog') }}/" + id_produk,
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

            const cuttingDataTable = $('#costumerProdukDatatable').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "search": "",
                    "searchPlaceholder": "Cari Data Cutting",
                },
                ajax: "/customer-product/getAllDatatable/{{ $data->id_customer }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',

                    },
                    {
                        data: 'ilc',
                        name: 'ilc',
                    },
                    {
                        data: 'berat',
                        name: 'berat',
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
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

        });

        async function kodeILC(ilc, berat) {
            document.getElementById('ilc').value = ilc;
            document.getElementById('berat').value = berat;
        }

        document.getElementById('customerPackingProductForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            ilc = document.getElementById('ilc').value;
            berat = document.getElementById('berat').value;
            id_customer = {{ $data->id_customer }};
            id_produk = {{ $data->id_produk }}

            const form = event.target;
            const formData = new FormData(form);

            formData.append('ilc', ilc); // menambahkan ilc ke formData
            formData.append('berat', berat); // menambahkan berat ke formData
            formData.append('id_customer', id_customer); // menambahkan id_customer ke formData
            formData.append('id_produk', id_produk); // menambahkan id_produk ke formData

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            try {
                const response = await fetch('/customer-product/store', {
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
                    $('#costumerProdukDatatable').DataTable().ajax.reload();
                }
            } catch (error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        });
    </script>
@endpush
