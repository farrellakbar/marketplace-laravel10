@extends('layouts.backend')
@section('title','Permission')
@section('content')
    <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">Permission</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Management Permission</li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    {{-- <div class="widgetbar">
                        <button class="btn btn-primary-rgba"><i class="feather icon-plus me-2"></i>Actions</button>
                    </div> --}}
                </div>
            </div>
        </div>
    <!-- End Breadcrumbbar -->
    <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                    @foreach ($roles as $role)
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-normal mb-2">Total {{$role->users(['job_historys.is_active' => true])->count()}} users</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <h4 class="mb-1 text-primary">{{$role->name}}</h4>
                                        <i class="fa fa-globe fa-3x text-primary"></i>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{route( 'permission.edit' ,encrypt($role->id))}}" type='button'><i class="fas fa-pen"></i> &nbsp; Edit Role Permission</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                <!-- End col -->
            </div>
            {{-- <div class="row">
                <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Table Opds</h5>
                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalCenter" onclick="show_create('Create Permission')">Create</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="rellarphp-datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="col-8">Name</th>
                                                <th scope="col" class="col-2">Status</th>
                                                <th scope="col" class="col-2">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- End col -->
            </div> --}}
            <!-- End row -->
        </div>
    <!-- End Contentbar -->
@endsection
@section('vendorscripts')

@endsection
@section('bottomscript')
<script>
    $(document).ready(function () {
        datatable();
    });

</script>
@endsection

