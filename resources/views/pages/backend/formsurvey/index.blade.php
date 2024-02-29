@extends('layouts.backend')
@section('title','Form Survey')
@section('content')
    <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">Form Survey</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Form Survey</li>
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
                    <div class="col-lg-12 mb-4">
                        <div class="d-flex justify-content-end align-items-center" id="buttonFormSurvey">
                            <button type="button" class="btn btn-sm btn-outline-info" id="editFormSurvey"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        </div>
                    </div>
                    <div id="contentFormSurvey">
                        @include('pages.backend.formsurvey.content.index')
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
        show_detail();
    });
    //OPEN CONTENT INDEX
        function show_detail(title, param){
            var act = "{{ route('formsurvey.modal.show'}}";
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
    //CLOSE CONTENT INDEX
    $('body').on('click','#editFormSurvey', function(){
        $('#contentFormSurvey').html(`
            @include('pages.backend.formsurvey.content.edit')
        `);
        $('#buttonFormSurvey').html(`
            <button type="button" class="btn btn-sm btn-outline-info mx-2" id="cancelFormSurvey"><i class="fa fa-times"></i> Cancel</button>
            <button type="button" class="btn btn-sm btn-success mx-2" id="updateFormSurvey"><i class="fa fa-pencil-square-o"></i> Update</button>
        `);

    });
    $('body').on('click','#cancelFormSurvey', function(){
        $('#contentFormSurvey').html(`
            @include('pages.backend.formsurvey.content.index')
        `);
        $('#buttonFormSurvey').html(`
            <button type="button" class="btn btn-sm btn-outline-info" id="editFormSurvey"><i class="fa fa-pencil-square-o"></i> Edit</button>
        `);

    });
</script>
@endsection

