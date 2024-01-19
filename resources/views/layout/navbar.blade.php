<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar d-flex">
    <div class="col-md-6">
        <ul class="navbar-nav navbar-left">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1" style="margin-top: -40px;">
                    <div class="d-sm-none d-lg-inline-block ml-1 user-login">
                        <span class="name">{{ auth()->user()->name }} </span><br>
                        <span class="role">{{ session('roles_name') }}</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="dropdown-item has-icon text-danger d-flex align-items-center">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <img src="{{ asset('img/logo.png') }}" width="175" alt="WVI">
    </div>
</nav>
