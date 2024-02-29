<!DOCTYPE html>
<html lang="en">
<head>
    @include("partials.frontend.titlemeta")
    @include("partials.frontend.headcss")
</head>
<body>
<div class="page-wraper">
	<div id="loading-area" class="preloader-wrapper-2">
		<div class="preloader-inner">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>

	<!-- Header -->
	<header class="site-header mo-left header style-1">
        @include("partials.frontend.topbar")
        @include("partials.frontend.navigationbar")
	</header>
	<!-- Header End -->

    @yield("content")

    @include('partials.frontend.footer')

	<button class="scroltop" type="button"><i class="fas fa-arrow-up"></i></button>
</div>
@include("partials.frontend.scriptjs")
@yield("bottomscript")
</body>
</html>
