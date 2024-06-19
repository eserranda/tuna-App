@extends('layouts.master')
@section('title')
    <h4 class="mb-sm-0">Supplier</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Supplier</a></li>
            <li class="breadcrumb-item active">data</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-5">
            <div class="d-flex flex-column h-100">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Data Supplier</h4>
                        <div class="flex-shrink-0">
                            <a href={{ route('supplier.add') }} class="btn btn-info ">Tambah Supplier</a>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <table class="table table-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">#VZ2110</a></th>
                                    <td>Bobby Davis</td>
                                    <td>October 15, 2021</td>
                                    <td>$2,300</td>
                                    <td><a href="javascript:void(0);" class="link-success">View More <i
                                                class="ri-arrow-right-line align-middle"></i></a></td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">#VZ2109</a></th>
                                    <td>Christopher Neal</td>
                                    <td>October 7, 2021</td>
                                    <td>$5,500</td>
                                    <td><a href="javascript:void(0);" class="link-success">View More <i
                                                class="ri-arrow-right-line align-middle"></i></a></td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">#VZ2108</a></th>
                                    <td>Monkey Karry</td>
                                    <td>October 5, 2021</td>
                                    <td>$2,420</td>
                                    <td><a href="javascript:void(0);" class="link-success">View More <i
                                                class="ri-arrow-right-line align-middle"></i></a></td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">#VZ2107</a></th>
                                    <td>James White</td>
                                    <td>October 2, 2021</td>
                                    <td>$7,452</td>
                                    <td><a href="javascript:void(0);" class="link-success">View More <i
                                                class="ri-arrow-right-line align-middle"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
