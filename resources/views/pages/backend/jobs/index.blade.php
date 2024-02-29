@extends('layouts.backend')
@section('title','Job Users')
@section('content')
    <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">Job Users</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Management Job Users</li>
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
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Table Job Users</h5>
                                    {{-- <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalCenter" onclick="show_create('Create Job Users')">Create</button> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="rellarphp-datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="col-3">Name</th>
                                                <th scope="col" class="col-2">Role</th>
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
            </div>
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
    //OPEN DATATABLE
        function datatable() {
            var table = $("#rellarphp-datatable").DataTable({
                paging: true,
                destroy: true,
                info: true,
                searching: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: false,
                responsive: false,
                scrollX: true,
                ajax: {
                    url: "{{route('jobuser.datatable')}}",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'name',
                        className: 'text-start align-top'
                    },
                    {
                        data: 'role_name',
                        className: 'text-start align-top'
                    },
                    {
                        data: null,
                        className: 'text-start align-top',
                        render: function(data, type, row){
                            if(data.job_history_is_active === true)
                            {
                                return `
                                    <i class='fa fa-circle text-success'></i> Active
                                `;
                            }
                            else{
                                return `
                                    <i class='fa fa-circle text-danger'></i> Not Active
                                `;
                            }
                        }
                    },
                    {
                        data: null,
                        className: 'text-start align-top',
                        render: function(data, type, row){
                            return `
                                    <button type="button" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalLargeCenter" onclick="show_detail('Detail Jobs','${data.id}')">
                                        <i class='fa fa-eye'></i>
                                    </button>
                                    @can('can_edit', [request()])
                                        <button type="button" class="btn btn-sm btn-outline-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalCenter" onclick="show_edit('Edit Jobs','${data.id}')">
                                            <i class='fa fa-edit'></i>
                                        </button>
                                    @endcan
                            `;
                        }
                    },
                ]
            });
            return table;
        }
    //CLOSE DATATABLE
    //OPEN MODAL DETAIL
        function show_detail(title, param){
            $("#modalLargeCenterTitle").html(title)
            $("#modalLargeCenterContent").html(`<div class="d-flex justify-content-center">
                                            <div class="spinner-border text-primary m-1" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>`);
            var act = "{{ route('jobuser.modal.show', ['param' => ':param']) }}";
                act = act.replace(':param', param);
            $.ajax({
                url: act,
                success: function(data){
                    $("#modalLargeCenterContent").html(data);
                },
                error: function(xhr, status, error) {
                    $("#modalLargeCenterContent").html(`<div class="modal-body d-flex justify-content-center align-items-center">
                                                        <img src="{{ asset('/') }}assets/images/error/404.svg" width="80%"class="text-center">
                                                    </div>`
                                                );
                }
            });
        }
    //CLOSE MODAL DETAIL
    //OPEN MODAL EDIT
        function show_edit(title, param){
            $("#modalCenterTitle").html(title)
            $("#modalCenterContent").html(`<div class="d-flex justify-content-center">
                                            <div class="spinner-border text-primary m-1" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>`);
            var act = "{{ route('jobuser.modal.edit', ['param' => ':param']) }}";
                act = act.replace(':param', param);
            $.ajax({
                url: act,
                success: function(data){
                    $("#modalCenterContent").html(data);
                },
                error: function(xhr, status, error) {
                    $("#modalCenterContent").html(`<div class="modal-body d-flex justify-content-center align-items-center">
                                                        <img src="{{ asset('/') }}assets/images/error/404.svg" width="80%"class="text-center">
                                                    </div>`
                                                );
                }
            });
        }
    //CLOSE MODAL EDIT
</script>
@endsection

