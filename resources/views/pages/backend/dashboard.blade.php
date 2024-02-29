@extends('layouts.backend')
@section('title','Dashboard')
@section('content')
    <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">Dashboard</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="text-center mt-3 mb-5">
                        <h4>Page Title</h4>
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
@section('scriptbawah')
<script>
    $(document).ready(function () {
    });
</script>
@endsection

