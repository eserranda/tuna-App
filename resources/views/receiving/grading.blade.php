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
@endpush

@section('title')
    <h4 class="mb-sm-0">Receiving</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Receving</a></li>
            <li class="breadcrumb-item active">Grading</li>
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
                                <h4 class="card-title mb-0 flex-grow-1">Data Receiving</h4>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-sm-6 mb-1">
                                        ILC : <span class="fw-bold">{{ $data->ilc }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        Tanggal : <span class="fw-bold"> {{ $data->tanggal }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        {{-- Supplier : <span class="fw-bold">{{ $data->supplier->nama_supplier }}</span> --}}
                                        Supplier : <span class="fw-bold">{{ $data->supplier->nama_supplier ?? '-' }}</span>

                                    </div>
                                    <div class="col-sm-6">
                                        No Plat : <span class="fw-bold">{{ $data->no_plat }}</span>
                                    </div>
                                </div>
                                <hr>
                                <form id="rawMaterialLotsForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="berat" class="form-label">Berat</label>
                                            <input type="number" class="form-control" placeholder="Berat" id="berat"
                                                name="berat" step="0.01">
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_ikan" class="form-label">Nomor Ikan</label>
                                                <input type="number" class="form-control" placeholder="Nomor Ikan"
                                                    id="no_ikan" name="no_ikan">
                                                <div class="invalid-feedback"></div>
                                                <span>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="auto_number_receiving">
                                                        <label class="form-check-label" for="auto_number_switch">Auto
                                                            Number</label>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="grade" class="form-label">Grade</label>
                                                <input type="text" class="form-control" placeholder="Grade"
                                                    id="grade" name="grade">
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="col-12">
                                            <div class="mb-3">
                                                <label for="grade" class="form-label">Grade</label>
                                            </div>
                                        </div> --}}

                                        {{-- <h5>Grade</h5>
                                        <p class="form-label">Grade</p>
                                        <div class="col-12 mb-3">
                                            <div class="hstack gap-4">
                                                <button type="button" class="btn btn-soft-danger custom-toggle"
                                                    data-bs-toggle="button">
                                                    <span class="icon-on">C</span>
                                                    <span class="icon-off">C</span>
                                                </button>

                                                <button type="button" class="btn btn-soft-danger custom-toggle"
                                                    data-bs-toggle="button">
                                                    <span class="icon-on">C</span>
                                                    <span class="icon-off">C</span>
                                                </button>
                                            </div>
                                        </div> --}}

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
                                <h4 class="card-title mb-0 flex-grow-1">Produk Receiving</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped mt-0 datatable" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Ikan</th>
                                            <th>Grade</th>
                                            <th>Berat</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
    <script>
        $(document).ready(function() {
            const ilc = "{{ $data->ilc }}";
            const myDataTable = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "search": "",
                    "searchPlaceholder": "Cari Nomor Ikan",
                },

                ajax: "{{ url('/raw-material-lots/findOne') }}/" + ilc,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',

                    },
                    {
                        data: 'no_ikan',
                        name: 'no_ikan',
                    },
                    {
                        data: 'grade',
                        name: 'grade',
                    },
                    {
                        data: 'berat',
                        name: 'berat',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                dom: 'Bftp',
                // dom: 'Bftip',
            });
        });
        var ilc = "{{ $data->ilc }}";
        document.addEventListener('DOMContentLoaded', function() {
            const autoNumberStatus = localStorage.getItem('auto_number') || 'on';
            const autoNumberSwitch = document.getElementById('auto_number_receiving');

            if (autoNumberStatus === 'on') {
                autoNumberSwitch.checked = true;
                nextNumber(ilc).then(() => {
                    document.getElementById('no_ikan').readOnly = true;
                });
            } else {
                autoNumberSwitch.checked = false;
                document.getElementById('no_ikan').readOnly = false;
            }

            autoNumberSwitch.addEventListener('change', function(event) {
                const isChecked = event.target.checked;
                localStorage.setItem('auto_number', isChecked ? 'on' : 'off');

                if (isChecked) {
                    nextNumber(ilc).then(() => {
                        document.getElementById('no_ikan').readOnly = true;
                    });
                } else {
                    document.getElementById('no_ikan').readOnly = false;
                    document.getElementById('no_ikan').value = '';
                }
            });


            document.getElementById('rawMaterialLotsForm').addEventListener('submit', async (event) => {
                event.preventDefault();

                const ilc = "{{ $data->ilc }}";
                const form = event.target;
                const formData = new FormData(form);
                formData.append('ilc', ilc); // menambahkan ilc ke formData

                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                try {
                    const response = await fetch('{{ route('raw_material_lots.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: formData,
                    })

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
                        // form.reset();
                        $('.datatable').DataTable().ajax.reload();
                        const autoNumberStatus = localStorage.getItem('auto_number');
                        if (autoNumberStatus === 'on') {
                            nextNumber(ilc);
                        } else {
                            autoNumberSwitch.checked = false;
                            document.getElementById('no_ikan').readOnly = false;
                        }
                    }
                } catch (error) {
                    console.error('There has been a problem with your fetch operation:', error);
                }
            });
        });

        function nextNumber(ilc) {
            return fetch("/raw-material-lots/nextNumber/" + ilc)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('no_ikan').value = data.next_no_ikan;
                })
                .catch(error => {
                    console.error('Error fetching next no_ikan:', error);
                });
        }

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
                        url: '/raw-material-lots/' + id,
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
    </script>
@endpush
