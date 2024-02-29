@extends('layouts.backend')
@section('title','Permission')
@section('content')
    <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">Role Permission</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('permission.index')}}">Management Permissiom</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Role {{$role->name}}</li>
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
                <form class="form row" id="form_edit">
                    @csrf
                    @can('can_edit', [request(),'/permission-edit'])
                        <div class="d-flex mt-3 mb-3 justify-content-end">
                            <button class="btn btn-sm btn-success" type="submit" id='btnSave'>Save Changes</button>
                        </div>
                    @endcan
                    @foreach ($menus as $menu)
                        <div class="col-md-4 col-lg-3 col-12 mb-2">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="font-weight-bolder m-0">{{ $menu->name }}</h4>
                                    @if(isset($menu->menu) && $menu->menu->key_name != 'management' || (!isset($menu->menu) && $menu->key_name != 'management'))
                                        <button class="btn btn-outline-info menu-all-check" data-bs-toggle="tooltip" title="Tick All" type="button" data-check='false' id="{{$menu->key_name}}" ><i class="fa fa-check-square-o"></i></button>
                                    @endif
                                </div>
                                <div class="card-body">
                                    @forelse ($menu->roles(['permissions.roles_id' => $role->id])->first() ? ($menu->roles(['permissions.roles_id' => $role->id])->first()->pivot->toArray()) : [] as $key => $value)
                                        @if (preg_match('/^can_/', $key))
                                            <div class="form-group">
                                                <input type="checkbox" class="{{$menu->key_name}} form-check-input me-1" name="permissions[]" data-permission='{{$key}}' id="{{ $key }}" value="{{ $menu->id.'///'.$key }}" {{$value ? 'checked' : ''}} {{isset($menu->menu) ? ($menu->menu->key_name == 'management' ? 'disabled' : '') : ''}}>
                                                <label for="{{ $key }}">{{ ucwords(str_replace('can_', 'can ', $key)) }}</label>
                                            </div>
                                        @endif
                                    @empty
                                        @foreach ($columnPermissions as $key )
                                            @if(preg_match('/^can_/', $key))
                                                <div class="form-group">
                                                    <input type="checkbox" class="{{$menu->key_name}} form-check-input me-1" name="permissions[]" data-permission='{{$key}}' id="{{ $key }}" value="{{ $menu->id.'///'.$key }}" {{isset($menu->menu) ? ($menu->menu->key_name == 'management' ? 'disabled' : '') : ''}}>
                                                    <label for="{{ $key }}">{{ ucwords(str_replace('can_', 'can ', $key)) }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>
                <!-- End col -->
            </div>
        </div>
    <!-- End Contentbar -->
@endsection
@section('vendorscripts')

@endsection
@section('bottomscript')
<script>
    $(document).ready(function () {
    });
    //OPEN ALL CHECK ROLE PERMISSIONS
        $(".menu-all-check").click(function(event) {
            if (event.currentTarget.dataset.check == 'true') {
                $(`.${event.currentTarget.id}`).prop("checked", false);
                event.currentTarget.dataset.check = false;
            } else {
                $(`.${event.currentTarget.id}`).prop("checked", true);
                event.currentTarget.dataset.check = true;
            }
        });
    //CLOSE ALL CHECK ROLE PERMISSIONS
    //OPEN PROSES UPDATE
        $('#form_edit').on('submit', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            data = new FormData($('#form_edit')[0]);
                        data.append('_method','PUT');
            var act = "{{ route('permission.update', [':param']) }}".replace(':param', '{{ encrypt($role->id) }}');
            $('#btnSave').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: act,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    $("#form_edit")[0].reset();
                    $("#modalCenter").modal('hide');
                    swal({
                        title: data.title,
                        text: data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-success',
                    }).then(function () {
                        location.reload();
                    })
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;

                    swal({
                        title: response.title,
                        text: response.message,
                        type: 'error',
                        confirmButtonClass: 'btn btn-success',
                    })
                }
            });
        });
    //CLOSE PROSES UPDATE
</script>
@endsection

