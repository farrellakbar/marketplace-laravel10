	<!-- Main Header -->
		<div class="sticky-header main-bar-wraper navbar-expand-lg">
			<div class="main-bar clearfix">
				<div class="container clearfix">
					<!-- Website Logo -->
					<div class="logo-header logo-dark">
						<a href="index.html"><img src="{{ asset('/') }}frontend_assets/images/logo.png" alt="logo"></a>
					</div>

					<!-- Nav Toggle Button -->
					<button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>

					<!-- Main Nav -->
					<div class="header-nav navbar-collapse collapse justify-content-start" id="navbarNavDropdown">
						<div class="logo-header logo-dark">
							<a href="index.html"><img src="{{ asset('/') }}frontend_assets/images/logo.png" alt=""></a>
						</div>
						<div class="search-input">
							<div class="input-group">
								<input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Search Books Here">
								<button class="btn" type="button"><i class="flaticon-loupe"></i></button>
							</div>
						</div>
						<ul class="nav navbar-nav">
                            <li><a href="{{route('beranda')}}"><span>Beranda</span></a></li>
							<li><a href="{{route('order.index')}}"><span>Order</span></a></li>
					</div>
				</div>
			</div>
		</div>
	<!-- Main Header End -->
