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
    <h4 class="mb-sm-0">Packing</h4>
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
                                <h4 class="card-title mb-0 flex-grow-1">Pilih Customer dan Product</h4>
                            </div>
                            <div class="card-body">
                                <form id="addForm">
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="error-messages" class="alert alert-danger d-none"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="id_customer" class="form-label">Pilih Customers</label>
                                                <select class="form-control" name="id_customer" id="id_customer">
                                                    <option value="" selected disabled>Pilih Customers</option>
                                                </select>
                                                <div class="invalid-feedback"> </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="id_produk" class="form-label">Pilih Product</label>
                                                <select class="form-control " name="id_produk" id="id_produk">
                                                    <option value="" selected disabled>Pilih Produk</option>
                                                </select>
                                                <div class="invalid-feedback"> </div>

                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" placeholder="Tanggal"
                                                    id="tanggal" name="tanggal">
                                                <div class="invalid-feedback"> </div>

                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="kode" class="form-label">Kode Packing</label>
                                                <input type="text" class="form-control" placeholder="kode" id="kode"
                                                    name="kode">
                                                <div class="invalid-feedback"> </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-2">
                                            <div class="text-start">
                                                <button type="submit" class="btn btn-primary">Buat Packing</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Data Packing Customers</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped mt-0 datatable" id="datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Customers</th>
                                            <th>Produk</th>
                                            <th>Tanggal</th>
                                            <th></th>
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
    <!--select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets') }}/js/pages/select2.init.js"></script>
    <script>
        async function printLabelPacking(id_customer, id_produk, kode) {
            try {
                const response = await fetch('/print/print-label-packing/' + id_customer + '/' + id_produk + '/' +
                    kode, {
                        method: 'GET',
                    });

                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }

                // const data = await response.json();

                console.log(data);
            } catch (error) {
                console.error('Fetch error: ', error);
            }
        }


        document.getElementById('addForm').addEventListener('submit', async (event) => {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch('/packing/store', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData,
                });

                const data = await response.json();
                console.log(data);
                if (!data.success) {
                    Object.keys(data.messages).forEach(fieldName => {
                        const inputField = document.getElementById(fieldName);
                        if (inputField && fieldName == 'id_customer' || inputField && fieldName ==
                            'id_produk') {
                            inputField.classList.add('is-invalid');
                        } else {
                            inputField.classList.add('is-invalid');
                            if (inputField.nextElementSibling) {
                                inputField.nextElementSibling.textContent = data.messages[
                                    fieldName][0];
                            }
                        }

                    });

                    // hapus error message jika form sudah di isi
                    const validFields = document.querySelectorAll('.is-invalid');
                    validFields.forEach(validField => {
                        const fieldName = validField.id;
                        if (!data.messages[fieldName]) {
                            if (fieldName === 'id_customer' || fieldName === 'id_produk') {
                                validField.classList.remove('is-invalid');
                            } else {
                                validField.classList.remove('is-invalid');
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
                    $('#datatable').DataTable().ajax.reload();
                    $('#addModal').modal('hide');
                }
            } catch (error) {
                console.error(error);
            }
        });

        // const customer_group
        document.addEventListener('DOMContentLoaded', async () => {
            const response = await fetch('{{ route('customer.get') }}');
            const suppliers = await response.json();

            const selectElement = document.getElementById('id_customer');
            suppliers.forEach(supplier => {
                const option = document.createElement('option');
                option.value = supplier.id;
                option.text = supplier.nama;

                option.setAttribute('data-customer-group', supplier.customer_group);

                selectElement.appendChild(option);
            });

            $('#id_customer').select2();

            $('#id_customer').on('change', function() {
                const selectedGroup = $('#id_customer option:selected').data('customer-group');
                // alert('Customer Group: ' + selectedGroup);
                fetchProducts(selectedGroup);

            });
        });

        async function fetchProducts(customerGroup) {
            try {
                // Gunakan customerGroup sebagai parameter dalam URL
                const response = await fetch('/produk/get/' + customerGroup);
                const products = await response.json();

                const selectElement = document.getElementById('id_produk');

                // Hapus opsi lama sebelum menambahkan opsi baru
                selectElement.innerHTML = '<option value="" selected disabled>Pilih Product</option>';

                // Tambahkan opsi produk ke elemen select
                products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.text = product.nama;
                    selectElement.appendChild(option);
                });

                $('#id_produk').select2();
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        }


        $(document).ready(function() {
            const datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "search": "",
                    "searchPlaceholder": "Cari Data",
                },
                ajax: "{{ route('get-all-packing') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,

                    },
                    {
                        data: 'id_customer',
                        name: 'id_customer',
                        // orderable: false,

                    },
                    {
                        data: 'id_produk',
                        name: 'id_produk',
                        orderable: false,

                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
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
                        url: '/packing/' + id,
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
                                $('.datatable').DataTable().ajax.reload();
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
    </script>
@endpush
