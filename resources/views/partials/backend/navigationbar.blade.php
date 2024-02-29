<!-- Start Navigationbar -->
    <div class="navigationbar">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start Horizontal Nav -->
            <nav class="horizontal-nav mobile-navbar fixed-navbar">
                <div class="collapse navbar-collapse" id="navbar-menu">
                  <ul class="horizontal-menu">
                    <li class="scroll"><a href="{{route('dashboard')}}"><img src="{{ asset('/') }}assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>Dashboard</span></a></li>
                    @foreach (user_menus() as $menu)
                        @if (count($menu->subMenus) > 0)
                            <li class="dropdown">
                                <a href="{{Route::has($menu->route) ? route($menu->route) : '#'}}" ><img src="{{ asset('/') }}assets/images/svg-icon/advanced.svg" class="img-fluid" alt="advanced"><span>{{$menu->name}}</span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($menu->subMenus as $subMenu)
                                            <li><a href="{{Route::has($subMenu->route) ? route($subMenu->route) : '#'}}">{{$subMenu->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="scroll"><a href="{{Route::has($menu->route) ? route($menu->route) : '#'}}"><i class='{{$menu->icon}}'></i><span>{{$menu->name}}</span></a></li>
                        @endif
                    @endforeach
                    {{-- <li class="dropdown">
                        <a href="javaScript:void();" class="dropdown-toggle" data-bs-toggle="dropdown"><img src="{{ asset('/') }}assets/images/svg-icon/advanced.svg" class="img-fluid" alt="advanced"><span>Management</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('user.index')}}">Users</a></li>
                            <li><a href="{{route('role.index')}}">Roles</a></li>
                            <li><a href="{{route('opd.index')}}">Opds</a></li>
                            <li><a href="{{route('job.index')}}">Job Users</a></li>
                            <li><a href="{{route('menu.index')}}">Menus</a></li>
                            <li><a href="{{route('permission.index')}}">Permissions</a></li>
                        </ul>
                    </li> --}}
                  </ul>
                </div>
            </nav>
            <!-- End Horizontal Nav -->
        </div>
        <!-- End container-fluid -->
    </div>
<!-- End Navigationbar -->
