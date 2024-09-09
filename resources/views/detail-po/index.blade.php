@extends('layouts.master')
@push('head_component')
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

    <!--- Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
{{-- @section('title')
    <h4 class="mb-sm-0">Data User Costumers</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">User Costumers</a></li>
            <li class="breadcrumb-item active">data</li>
        </ol>
    </div>
@endsection --}}

@section('content')
    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card" id="demo">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header border-bottom-dashed p-4">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    {{-- <img src="assets/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark"
                                        height="17">
                                    <img src="assets/images/logo-light.png" class="card-logo card-logo-light"
                                        alt="logo light" height="17"> --}}
                                    <h5 class="card-title mb-1">PT. Chen Woo Fishery</h5>
                                    <h6 class="text-muted text-uppercase fw-semibold mt-3">Address</h6>
                                    <p class="text-muted mb-1" id="address-details">Jl. Kima 4 Blok K9 / Kav B2, Kawasan
                                    </p>
                                    <p class="text-muted mb-0" id="zip-code"><span>Zip-code:</span> 90241</p>

                                </div>
                                {{-- <div class="flex-shrink-0 mt-sm-0 mt-3">
                                    <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                                    <p class="text-muted mb-1" id="address-details">Jl. Kima 4 Blok K9 / Kav B2, Kawasan
                                    </p>
                                    <p class="text-muted mb-0" id="zip-code"><span>Zip-code:</span> 90241</p>
                                </div> --}}
                            </div>
                        </div>
                        <!--end card-header-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Kode PO</p>
                                    <h5 class="fs-14 mb-0"><span id="invoice-no">{{ $kode_po }}</span></h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Date</p>
                                    <h5 class="fs-14 mb-0"><span id="invoice-date">
                                            {{ $tanggal ?? '' }}
                                        </span></h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Status</p>
                                    <span class="badge badge-soft-success fs-11" id="payment-status">On Progress</span>
                                </div>
                                <!--end col-->
                                {{-- <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Total Amount</p>
                                    <h5 class="fs-14 mb-0">$<span id="total-amount">755.96</span></h5>
                                </div> --}}
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->

                    @if ($packing)
                        <div class="col-lg-12">
                            <div class="card-body p-4 border-top border-top-dashed">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <h6 class="text-muted text-uppercase fw-semibold mb-3">Customers Details</h6>
                                        <p class="fw-medium mb-2" id="billing-name">{{ $packing->customer->nama }}</p>
                                        <p class="text-muted mb-1" id="billing-address-line-1">
                                            {{ $packing->customer->email }}
                                        </p>
                                        <p class="text-muted mb-1"><span>Phone: {{ $packing->customer->phone }}</span> </p>
                                        </p>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6">
                                        <h6 class="text-muted text-uppercase fw-semibold mb-3">Shipping Address</h6>
                                        <p class="fw-medium mb-2" id="shipping-name">{{ $packing->customer->nama }}</p>
                                        <p class="text-muted mb-1" id="shipping-address-line-1">
                                            {{ $packing->customer->alamat }}
                                        </p>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                    @endif


                    @if ($produk->isEmpty())
                        <h5 class="text-center">Tidak ada data</h5>
                    @else
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Ilc Code</th>
                                                <th scope="col">Berat</th>
                                                <th scope="col">Tanggal Packing</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products-list">
                                            @foreach ($produk as $d)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $d->produk->nama }}</td>
                                                    <td>{{ $d->ilc }} </td>
                                                    <td>{{ $d->berat }} Kg</td>
                                                    <td>{{ $d->tanggal }} </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table><!--end table-->
                                </div>
                                {{-- <div class="mt-4">
                            <div class="alert alert-info">
                                <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                    <span id="note">All accounts are to be paid within 7 days from receipt of
                                        invoice. To be paid by cheque or
                                        credit card or direct payment online. If account is not paid within 7
                                        days the credits details supplied as confirmation of work undertaken
                                        will be charged the agreed quoted fee noted above.
                                    </span>
                                </p>
                            </div>
                        </div> --}}
                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                    <a href="javascript:window.print()" class="btn btn-success"><i
                                            class="ri-printer-line align-bottom me-1"></i> Print</a>
                                    {{-- <a href="javascript:void(0);" class="btn btn-primary"><i
                                    class="ri-download-2-line align-bottom me-1"></i> Download</a> --}}
                                </div>
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                    @endif
                </div><!--end row-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
@endsection
