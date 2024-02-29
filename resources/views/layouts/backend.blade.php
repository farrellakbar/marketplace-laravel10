<!DOCTYPE html>
<html lang="en">
<head>
    @include("partials.backend.titlemeta")
    @include("partials.backend.headcss")
</head>
<body class="horizontal-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="container-fluid">
        <!-- Start Rightbar -->
        <div class="rightbar">

            @include("partials.backend.topbar")

            @include("partials.backend.navigationbar")

            @yield("content")
            @include('partials.backend.modals')

            <!-- Start Footerbar -->
            <div class="footerbar">
                <footer class="footer">
                    <p class="mb-0">© {{now()->year}} Laravel 10 - All Rights Reserved.</p>
                </footer>
            </div>
            <!-- End Footerbar -->
        </div>
        <!-- End Rightbar -->
    </div>
    <!-- End Containerbar -->
    @include("partials.backend.scriptjs")
    @yield("bottomscript")
</body>
</html>
