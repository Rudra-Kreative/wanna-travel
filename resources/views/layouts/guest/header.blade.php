<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-5">
                <a href="{{ route('view',['page'=>'home']) }}" class="logo"> <img src="{{ asset('user/guest/images/logo-main.svg') }}" alt=""></a>

            </div>
            <div class="menu-sec col-lg-10 col-md-10 col-7">
                <div id="navigation">
                    <nav style="display: block;">
                        <ul>
                            <li class="current-menu-item"><a href="{{ route('view',['page'=>'home']) }}">Welcome to WANAH </a></li>
                            <li><a href="{{ route('view',['page'=>'is_wanna_for_me']) }}">Is WANAH For Me?
                                </a></li>
                            <li><a href="{{ route('view',['page'=>'faq']) }}">FAQ's </a></li>
                            <li><a href="javascript:void(0)">Hello Hoteliers</a></li>
                            <li><a href="javascript:void(0)">Login</a></li>
                        </ul>
                    </nav>
                </div>
                <a href="javascript:void(0)" class="register">List your Property</a>
            </div>
        </div>
    </div>
</header>