<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="./index.html">
                        <img src="../src/assets/img/logo.svg" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="./index.html" class="nav-link"> Nes </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu active">

            </li>

            @can('add categories')


                <li class="menu mt-3">
                    <a href="./categories" aria-expanded="false" class="dropdown-toggle">
                        <div class="d-flex flex-row gap-3">
                            <i class="fa fa-list-alt d-flex align-items-center fa-lg" aria-hidden="true"></i>


                            <span class="fs-5"> Categorías</span>
                        </div>
                    </a>
                </li>
            @endcan

            <li class="menu">
                <a href="./products" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-solid fa-truck  d-flex align-items-center fa-lg"></i>

                        <span class="fs-5">Productos</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="./servicios" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-brands fa-usps   d-flex align-items-center fa-lg"></i>

                        <span class="fs-5">Servicios</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="./rentacarros" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-solid fa-sign-hanging"   d-flex align-items-center fa-lg"></i>

                        <span class="fs-5">Maquinaria</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="./terracerias" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-brands fa-bandcamp"  d-flex align-items-center fa-lg"></i>

                        <span class="fs-5">Terracería</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="./sales" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-solid fa-cart-shopping  d-flex align-items-center fa-lg"></i>
                        <span class="fs-5">Ventas</span>
                    </div>
                </a>
            </li>
            @role('super-admin')

                <li class="menu">
                    <a href="{{ route('roles') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="d-flex flex-row gap-3">
                            <i class="fa-brands fa-github   d-flex align-items-center fa-lg"></i>

                            <span class="fs-5">Roles</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="./permissions" aria-expanded="false" class="dropdown-toggle">
                        <div class="d-flex flex-row gap-3">
                            <i class="fa-solid fa-key  d-flex align-items-center fa-lg"></i>

                            <span class="fs-5">Permisos</span>
                        </div>
                    </a>
                </li>

                <li class="menu">
                    <a href="./assign" aria-expanded="false" class="dropdown-toggle">
                        <div class="d-flex flex-row gap-3">
                            <i class="fa-solid fa-toggle-on d-flex align-items-center fa-lg"></i>

                            <span class="fs-5">Asignar</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="./users" aria-expanded="false" class="dropdown-toggle">
                        <div class="d-flex flex-row gap-3">
                            <i class="fa-solid fa-users d-flex align-items-center fa-lg"></i>

                            <span class="fs-5">Usuarios</span>
                        </div>
                    </a>
                </li>

            @endcan
            <li class="menu">
                <a href="./coins" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-solid fa-coins  d-flex align-items-center fa-lg"></i>

                        <span class="fs-5">Dinero</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="./cash-counts" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-solid fa-cash-register  d-flex align-items-center fa-lg"></i>

                        <span class="fs-5">Caja</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="./reports" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-solid fa-bullseye d-flex align-items-center fa-lg"></i>

                        <span class="fs-5">Reportes</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="./facturaciones" aria-expanded="false" class="dropdown-toggle">
                    <div class="d-flex flex-row gap-3">
                        <i class="fa-regular fa-newspaper"></i>

                        <span class="fs-5">Facturaciones</span>
                    </div>
                </a>
            </li>


        </ul>

    </nav>

</div>
