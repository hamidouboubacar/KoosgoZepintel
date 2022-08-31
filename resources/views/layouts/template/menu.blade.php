<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                        View all
                        <i class="fe-arrow-right"></i>
                    </a>

                </div>
            </li>
            
            <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                    <i class="fe-maximize noti-icon"></i>
                </a>
            </li>
            
            <li class="dropdown d-none d-lg-inline-block topbar-dropdown">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-grid noti-icon"></i>
                </a>
                <div class="dropdown-menu dropdown-lg dropdown-menu-right" style="">

                    <div class="p-lg-1">
                        <div class="row no-gutters">
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{ route('client.index') }}">
                                    <img src="../assets/images/accueil/clients_propects.jpeg" alt="Clients | Prospects">
                                    <span>Clients | Prospects</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{ route('contrats.index') }}">
                                    <img src="../assets/images/accueil/contrats.jpeg" alt="Contrats">
                                    <span>Contrats</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{ route('packages.index') }}">
                                    <img src="../assets/images/accueil/packages.jpeg" alt="Packages">
                                    <span>Packages</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{ route('factures.index') }}">
                                    <img src="../assets/images/accueil/ventes.jpeg" alt="Ventes">
                                    <span>Ventes</span>
                                </a>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{ route('commercials.index') }}">
                                    <img src="../assets/images/accueil/force_vente.jpeg" alt="Force de vente">
                                    <span>Force de vente</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="../assets/images/accueil/statistiques.jpeg" alt="Statistiques">
                                    <span>Statistiques</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{ route('role.index') }}">
                                    <img src="../assets/images/accueil/parametres.jpeg" alt="Paramètres">
                                    <span>Paramètres</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="../assets/images/accueil/assistance.jpeg" alt="Assistances">
                                    <span>Assistances</span>
                                </a>
                            </div>
                
                        </div>
                    </div>

                </div>
            </li>
            
            <li id="notification-content" class="dropdown notification-list topbar-dropdown">
            </li>

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    {{-- <img src="../assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle"> --}}
                    <span class="pro-user-name ml-1">
                        {{Auth::user()->name ?? ''}} <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Bienvenue !</h6>
                    </div>


                    <a href="#" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>Profil</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                    <a href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Deconnecter</span>
                    </a>

                </div>
            </li>

            <!-- <li class="dropdown notification-list">
                <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                    <i class="fe-settings noti-icon"></i>
                </a>
            </li> -->

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="index.html" class="logo logo-light text-center">
                <span class="logo-sm">
                    {{-- <img src="../assets/images/NETFORCE.jpeg" alt="" height="65"> --}}
                </span>
                <span class="logo-lg">
                    {{-- <span class="logo-lg-text-light" style="color: #2fb673;">NETFORCE</span> --}}
                </span>
            </a>

            <a href="index.html" class="logo logo-light text-center">
                <span class="logo-sm">
                    <img src="../assets/images/NETFORCE LOGO-CMJN.PNG" alt="" height="65">
                </span>
                <span class="logo-lg">
                    <span class="logo-lg-text-light" style="color: #2fb673;">NETFORCE</span>
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
