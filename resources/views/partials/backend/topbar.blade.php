        <!-- Start Topbar Mobile -->
            <div class="topbar-mobile">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="mobile-logobar">
                            <a href="index.html" class="mobile-logo"><img src="{{ asset('/') }}assets/images/logo.png" class="img-fluid" alt="logo"></a>
                        </div>
                        <div class="mobile-togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="topbar-toggle-icon">
                                        <a class="topbar-toggle-hamburger" href="javascript:void();">
                                            <img src="{{ asset('/') }}assets/images/svg-icon/horizontal.svg" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                            <img src="{{ asset('/') }}assets/images/svg-icon/verticle.svg" class="img-fluid menu-hamburger-vertical" alt="verticle">
                                         </a>
                                     </div>
                                </li>
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-bs-toggle="collapse" data-bs-toggle="#navbar-menu" aria-expanded="true">
                                            <img src="{{ asset('/') }}assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                            <img src="{{ asset('/') }}assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                        </a>
                                     </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Topbar -->
            <div class="topbar">
                <!-- Start container-fluid -->
                <div class="container-fluid">
                    <!-- Start row -->
                    <div class="row align-items-center">
                        <!-- Start col -->
                        <div class="col-md-12 align-self-center">
                            <div class="togglebar">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <div class="logobar">
                                            <a href="index.html" class="logo logo-large"><img src="{{ asset('/') }}assets/images/logo.png" class="img-fluid" alt="logo"></a>
                                        </div>
                                    </li>
                                    {{-- <li class="list-inline-item">
                                        <div class="searchbar">
                                            <form>
                                                <div class="input-group">
                                                  <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                                  <div class="input-group-append">
                                                    <button class="btn" type="submit" id="button-addon2"><img src="{{ asset('/') }}assets/images/svg-icon/search.svg" class="img-fluid" alt="search"></button>
                                                  </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li> --}}
                                </ul>
                            </div>
                            <div class="infobar">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <div class="notifybar">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('/') }}assets/images/svg-icon/notifications.svg" class="img-fluid" alt="notifications">
                                                <span class="live-icon"></span></a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                                    <div class="notification-dropdown-title">
                                                        <h4>Notifications</h4>
                                                    </div>
                                                    <ul class="list-unstyled">
                                                        <li class="d-flex p-2 mt-1   dropdown-item">
                                                            <span class="action-icon badge badge-primary-inverse"><i class="feather icon-dollar-sign"></i></span>
                                                            <div class="media-body">
                                                                <h5 class="action-title">$135 received</h5>
                                                                <p><span class="timing">Today, 10:45 AM</span></p>
                                                            </div>
                                                        </li>
                                                        <li class="d-flex p-2 mt-1   dropdown-item">
                                                            <span class="action-icon badge badge-success-inverse"><i class="feather icon-file"></i></span>
                                                            <div class="media-body">
                                                                <h5 class="action-title">Project X prototype approved</h5>
                                                                <p><span class="timing">Yesterday, 01:40 PM</span></p>
                                                            </div>
                                                        </li>
                                                        <li class="d-flex p-2 mt-1   dropdown-item">
                                                            <span class="action-icon badge badge-danger-inverse"><i class="feather icon-eye"></i></span>
                                                            <div class="media-body">
                                                                <h5 class="action-title">John requested to view wireframe</h5>
                                                                <p><span class="timing">3 Sep 2019, 05:22 PM</span></p>
                                                            </div>
                                                        </li>
                                                        <li class="d-flex p-2 mt-1   dropdown-item">
                                                            <span class="action-icon badge badge-warning-inverse"><i class="feather icon-package"></i></span>
                                                            <div class="media-body">
                                                                <h5 class="action-title">Sports shoes are out of stock</h5>
                                                                <p><span class="timing">15 Sep 2019, 02:55 PM</span></p>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-inline-item">
                                        <div class="profilebar">
                                            <div class="dropdown">
                                              <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('/') }}assets/images/users/profile.svg" class="img-fluid" alt="profile"><span class="feather icon-chevron-down live-icon"></span></a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                                    <div class="dropdown-item">
                                                        <div class="profilename">
                                                          <h5>
                                                            {{Auth()->user() ? Auth()->user()->name : '-'}}
                                                          </h5>
                                                        </div>
                                                    </div>
                                                    <div class="userbox">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-flex p-2 mt-1   dropdown-item">
                                                                <a href="#" class="profile-icon"><img src="{{ asset('/') }}assets/images/svg-icon/user.svg" class="img-fluid" alt="user">My Profile</a>
                                                            </li>
                                                            <li class="d-flex p-2 mt-1   dropdown-item">
                                                                <form method="POST" action="{{route('logout')}}">
                                                                    @csrf
                                                                    <button class="btn profile-icon"><img src="{{ asset('/') }}assets/images/svg-icon/logout.svg" class="img-fluid" alt="logout">Logout</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-inline-item menubar-toggle">
                                        <div class="menubar">
                                            <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-bs-toggle="collapse" data-bs-toggle="#navbar-menu" aria-expanded="true">
                                                <img src="{{ asset('/') }}assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                                <img src="{{ asset('/') }}assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                            </a>
                                         </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End col -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- End container-fluid -->
            </div>
        <!-- End Topbar -->
