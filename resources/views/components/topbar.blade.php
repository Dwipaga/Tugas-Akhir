<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-cubiconia" style="background-color:#0467be;">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" onclick="hideMenu()"></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user">
            <a class="nav-link dropdown-toggle p-1" data-toggle="dropdown" href="#" aria-expanded="false">
                <img src="{{Storage::url('user-photos/'. auth()->user()->photo) }}" class="rounded-circle" alt="User Image" width="30px"><span class="caret"></span>
            </a>
            <div class="dropdown-menu p-0 m-0" style="width:280px;">
                <div class="card card-widget widget-user m-0">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-default">
                        @if (Auth::user()->oss_id)
                        <h3 class="widget-user-username">{{ Auth::user()->oss_id }}</h3>
                        @else
                        <h3 class="widget-user-username">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h3>
                        @endif
                    </div>
                    <div class="widget-user-image">

                        <img class="img-circle elevation-2" src="{{ Storage::url('user-photos/'.auth()->user()->photo) }}" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="card card-widget widget-user-2" style="width:100%">
                                <div class="card-footer p-0">
                                    <ul class="nav flex-column">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="btn-group" style="width:100%">
                                <a href="{{ url('/') }}" class="btn btn-info">
                                    <i class="fas fa-home"></i>
                                    Home
                                </a>
                                <button type="button" onclick="document.getElementById('logout-form').submit();" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>