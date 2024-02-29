@extends('layouts.backend')
@section('title','Role')
@section('content')
    <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">Role</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Management Role</li>
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
                                    <h5 class="card-title">Table Roles</h5>
                                    @can('can_create', [request()])
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalCenter" onclick="show_create('Create Role')">Create</button>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="rellarphp-datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="col-8">Name</th>
                                                <th scope="col" class="col-2">Status</th>
                                                @if(auth()->user()->can('can_edit', [request()]) || auth()->user()->can('can_delete', [request()]))
                                                    <th scope="col" class="col-2">Action</th>
                                                @endcan
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
                    url: "{{route('role.datatable')}}",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'name',
                        className: 'text-start align-top'
                    },
                    {
                        data: null,
                        className: 'text-start align-top',
                        render: function(data, type, row){
                            if(data.is_active === true)
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
                    @if(auth()->user()->can('can_edit', [request()]) || auth()->user()->can('can_delete', [request()]))
                        {
                            data: null,
                            className: 'text-start align-top',
                            render: function(data, type, row){
                                return `
                                        @can('can_edit', [request()])
                                            <button type="button" class="btn btn-sm btn-outline-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalCenter" onclick="show_edit('Edit Role','${data.id}')">
                                                <i class='fa fa-edit'></i>
                                            </button>
                                        @endcan
                                        @can('can_delete', [request()])
                                            <button type='button' class='btn btn-sm btn-outline-danger waves-effect waves-light' title='Delete' onClick="data_delete('${data.id}','${data.name}')">
                                                <i class='fa fa-trash'></i>
                                            </button>
                                        @endcan
                                `;
                            }
                        },
                    @endcan
                ]
            });
            return table;
        }
    //CLOSE DATATABLE
    //OPEN MODAL CREATE
        function show_create(title){
            $("#modalCenterTitle").html(title)
            $("#modalCenterContent").html(`<div class="d-flex justify-content-center">
                                                    <div class="spinner-border" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>`);
            var act = "{{ route('role.modal.create')}}";
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
    //CLOSE MODAL CREATE
    //OPEN MODAL UPDATE
        function show_edit(title, param){
            $("#modalCenterTitle").html(title)
            $("#modalCenterContent").html(`<div class="d-flex justify-content-center">
                                            <div class="spinner-border text-primary m-1" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>`);
            var act = "{{ route('role.modal.edit', ['param' => ':param']) }}";
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
    //CLOSE MODAL UPDATE
    //OPEN PROSES DELETE
        function data_delete(id, name) {
            swal({
                title: 'Are you sure ?',
                text: `${name} data will be deleted!`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText:'Cancel',
                confirmButtonClass: 'btn btn-success',
            }).then(function(result) {
                if (result == true) {
                    var act = "{{ route('role.delete', [':param']) }}";
                        act = act.replace(':param', id);
                    $.ajax({
                        url: act,
                        data:   {
                            _token: '{{ csrf_token() }}',
                        },
                        type: 'delete',
                        success: function(data) {
                            swal({
                                type: 'success',
                                title: data.title,
                                text: data.message,
                                confirmButtonClass: 'btn btn-success',
                            }).then(function () {
                                datatable().ajax.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            var response = xhr.responseJSON;
                            swal({
                                type: 'error',
                                title: response.title,
                                text: response.message,
                                confirmButtonClass: 'btn btn-success',
                            });
                        }
                    });
                }
            });
            // swal({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     type: 'warning',
            //     showCancelButton: true,
            //     confirmButtonClass: 'btn btn-success',
            //     cancelButtonClass: 'btn btn-danger m-l-10',
            //     confirmButtonText: 'Yes, delete it!'
            // }).then(function () {
            //     swal(
            //         'Deleted!',
            //         'Your data has been deleted.',
            //         'success'
            //         )
            // })
        }
    //CLOSE PROSES DELETE
</script>
@endsection

