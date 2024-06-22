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
    {{-- Moment.js untuk Memformat Tanggal di Frontend --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endpush
@section('title')
    <h4 class="mb-sm-0">Cutting</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Cutting</a></li>
            <li class="breadcrumb-item active">data</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-5">
            <div class="d-flex flex-column h-100">
                <div class="row mb-0">
                    <div class="col-md-6">
                        <div class="card mb-1">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Data Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-sm-6 mb-3">
                                        ILC : <span class="fw-bold">{{ $data->ilc }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        Ekspor : <span class="fw-bold"> {{ $data->ekspor }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        ILC Cutting : <span class="fw-bold"> {{ $data->ilc_cutting }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        Tanggal : <span class="fw-bold">{{ $tanggal }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Buat Produk Cutting Baru</h4>
                            </div>
                            <div class="card-body">
                                <form id="refinedMaterialLotsForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="berat" class="form-label">Berat</label>
                                            <input type="number" class="form-control" placeholder="Berat" id="berat"
                                                name="berat" step="0.01">
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            {{-- <div class="mb-3">
                                                <label for="auto_number" class="form-label">Auto Number</label>
                                                <div>
                                                    <input type="radio" id="auto_on" name="auto_number" value="on"
                                                        checked>
                                                    <label for="auto_on">On</label>
                                                    <input type="radio" id="auto_off" name="auto_number" value="off">
                                                    <label for="auto_off">Off</label>
                                                </div>
                                            </div> --}}
                                            <div class="mb-3">
                                                <label for="no_ikan" class="form-label">Nomor Ikan</label>
                                                <input type="number" class="form-control" placeholder="No Ikan"
                                                    id="no_ikan" name="no_ikan">
                                                <div class="invalid-feedback"></div>
                                                {{-- <span>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="auto_number_switch">
                                                        <label class="form-check-label" for="auto_number_switch">Auto
                                                            Number</label>
                                                    </div>
                                                </span> --}}
                                            </div>
                                        </div>

                                        {{-- <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_ikan" class="form-label">Nomor Ikan</label>
                                                <input type="text" class="form-control bg-light" id="no_ikan"
                                                    name="no_ikan" readonly>
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_loin" class="form-label">Nomor Loin</label>
                                                <input type="number" class="form-control" placeholder="No Loin"
                                                    id="no_loin" name="no_loin">
                                                {{-- <select class="form-select mb-3" id="no_loin" name="no_loin">
                                                    <option selected disabled>Pilih Nomor Loin</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                </select> --}}
                                                <div class="invalid-feedback">
                                                </div>
                                                <span>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="auto_number_switch">
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

                                        <div class="col-lg-12 mt-2">
                                            <div class="text-start">
                                                <button type="submit" class="btn btn-primary">Buat Cutting</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-0">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Data Cutting</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped mt-0 datatable" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Berat</th>
                                            <th>No Ikan</th>
                                            <th>No Loin</th>
                                            <th>Grade</th>
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
        $(document).ready(function() {
            const ilc_cutting = "{{ $data->ilc_cutting }}";
            const datatable = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "search": "",
                    "searchPlaceholder": "Cari Data Cutting",
                },
                ajax: "{{ url('refined-material-lots/getAll') }}/" + ilc_cutting,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',

                    },
                    {
                        data: 'berat',
                        name: 'berat',
                    },
                    {
                        data: 'no_ikan',
                        name: 'no_ikan',
                    },
                    {
                        data: 'no_loin',
                        name: 'no_loin',
                    },
                    {
                        data: 'grade',
                        name: 'grade',
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
        const ilc_cutting = "{{ $data->ilc_cutting }}";

        document.addEventListener('DOMContentLoaded', function() {
            const autoNumberStatus = localStorage.getItem('auto_number') || 'on';
            const autoNumberSwitch = document.getElementById('auto_number_switch');

            if (autoNumberStatus === 'on') {
                autoNumberSwitch.checked = true;
                nextNumber(ilc_cutting).then(() => {
                    document.getElementById('no_loin').readOnly = true;
                });
            } else {
                autoNumberSwitch.checked = false;
                document.getElementById('no_loin').readOnly = false;
            }

            autoNumberSwitch.addEventListener('change', function(event) {
                const isChecked = event.target.checked;
                localStorage.setItem('auto_number', isChecked ? 'on' : 'off');

                if (isChecked) {
                    nextNumber(ilc_cutting).then(() => {
                        document.getElementById('no_loin').readOnly = true;
                    });
                } else {
                    document.getElementById('no_loin').readOnly = false;
                    document.getElementById('no_loin').value = '';
                }
            });

            document.getElementById('refinedMaterialLotsForm').addEventListener('submit', async (event) => {
                event.preventDefault();

                const ilc_cutting = "{{ $data->ilc_cutting }}";
                const form = event.target;
                const formData = new FormData(form);
                formData.append('ilc_cutting', ilc_cutting); // menambahkan ilc ke formData

                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                try {
                    const response = await fetch('{{ route('refined_material_lots.store') }}', {
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
                        $('.datatable').DataTable().ajax.reload();
                        const autoNumberStatus = localStorage.getItem('auto_number');
                        if (autoNumberStatus === 'on') {
                            nextNumber(ilc_cutting);
                        } else {
                            document.getElementById('auto_off').checked = true;
                            document.getElementById('no_loin').readOnly = false;
                        }
                    }
                } catch (error) {
                    console.error('There has been a problem with your fetch operation:', error);
                }
            });
        });

        async function kodeILC(ilc) {
            document.getElementById('ilc').value = ilc;
        }

        function nextNumber(ilc_cutting) {
            return fetch("/refined-material-lots/nextNumber/" + ilc_cutting)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('no_loin').value = data.next_no_loin;
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
                        url: '/refined-material-lots/' + id,
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
                                const autoNumberStatus = localStorage.getItem('auto_number');
                                if (autoNumberStatus === 'on') {
                                    nextNumber(ilc_cutting);
                                } else {
                                    document.getElementById('auto_off').checked = true;
                                    document.getElementById('no_loin').readOnly = false;
                                }
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
