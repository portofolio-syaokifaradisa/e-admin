<div class="navbar-container container-fluid">
    <ul class="nav-left">
        <li>
            <a href="#!" onclick="javascript:toggleFullScreen()">
                <i class="feather icon-maximize full-screen"></i>
            </a>
        </li>
    </ul>
    <ul class="nav-right">
        <li class="user-profile header-notification">
            <div class="dropdown-primary dropdown">
                <div class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('icon/user.svg') }}" class="img-radius" width="25px">
                    <span>{{ Auth::user()->nama }}</span>
                    <i class="feather icon-chevron-down"></i>
                </div>
                <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <li>
                        <a href="{{ route('logout') }}">
                            <i class="feather icon-log-out"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>