 <!-- Sidebar -->
 <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ !empty(Auth::guard('administrator')->user()->image_path)?asset(Auth::guard('administrator')->user()->image_path): 'https://picsum.photos/200/300' }}" class="img-circle elevation-2"
                style="height: 50px;width: 50px" alt="User Image">
        </div>
        <div class="info">
            <a href="{{ route('administrator.dashboard') }}"
                class="d-block">{{ Auth::guard('administrator')->user()->name }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item ">
                <a href="{{ route('administrator.dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard

                    </p>
                </a>
            </li>
            <li class="nav-item ">
                <a href="#" class="nav-link ">
                    <i class="fas fa-hotel"></i>
                    <p>
                        Hotels
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('administrator.hotel.type.home') }}" class="nav-link">
                            <i class="fas fa-building"></i>
                            <p>Type</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('administrator.hotel.property.home') }}" class="nav-link">
                            <i class="fas fa-door-closed"></i>
                            <p>Property Type</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('administrator.hotel.home') }}" class="nav-link">
                            <i class="fas fa-door-closed"></i>
                            <p>List</p>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="nav-item ">
                <a href="#" class="nav-link ">
                    <i class="fas fa-edit"></i>
                    <p>
                        CMS
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('administrator.pages.home',['slug'=>'home']) }}" class="nav-link">
                            <i class="fas fa-angle-double-right"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('administrator.pages.home',['slug'=>'faq']) }}" class="nav-link">
                            <i class="fas fa-angle-double-right"></i>
                            <p>FAQ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('administrator.pages.home',['slug'=>'is_wanna_for_me']) }}" class="nav-link">
                            <i class="fas fa-angle-double-right"></i>
                            <p>Is Wanna For Me?</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('administrator.pages.home',['slug'=>'contact']) }}" class="nav-link">
                            <i class="fas fa-angle-double-right"></i>
                            <p>Contact Us</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('administrator.pages.home',['slug'=>'plan']) }}" class="nav-link">
                            <i class="fas fa-angle-double-right"></i>
                            <p>Pricing Plans</p>
                        </a>
                    </li>
                    
                </ul>
            </li>
           
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
