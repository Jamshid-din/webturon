<div class="sidebar animated" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="http://web.turonbank.uz/" class="simple-text logo-normal">
      {{ __('Web Turon') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>

      <!-- USER Management -->
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management' || $activePage == 'role') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#userSidebarTab" aria-expanded="{{ ($show == 'user') ? 'true':'false'}}">
        <i class="fa fa-users" aria-hidden="true"></i>
          <p>{{ __('User Control') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($show == 'user') ? 'show':''}}" id="userSidebarTab">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            @if(Auth::user()->roles->role_code == "super_admin" || Auth::user()->roles->role_code == "it_admin")
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'role' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user-roles.index') }}">
                <span class="sidebar-mini"> UR </span>
                <span class="sidebar-normal"> {{ __('User Roles') }} </span>
              </a>
            </li>
            @endif
          </ul>
        </div>
      </li>
      @if(Auth::user()->roles->role_code != "it_admin")
      <!-- Document Management -->
      <li class="nav-item {{ ($activePage == 'archive' || $activePage == 'personal') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#idDocs" aria-expanded="{{ ($show == 'document') ? 'true':'false'}}">
        <i class="fa fa-archive" aria-hidden="true"></i>
          <p>{{ __('Documents') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($show == 'document') ? 'show':'' }}" id="idDocs">
          <ul class="nav">
            @if(Auth::user()->roles->role_code == "super_admin" || Auth::user()->roles->role_code == "metodologiya")
              <li class="nav-item{{ $activePage == 'archive' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('admin-docs-archive') }}">
                  <span class="sidebar-mini"> D </span>
                  <span class="sidebar-normal">{{ __('Archive') }} </span>
                </a>
              </li>
            @endif
            @if(Auth::user()->roles->role_code == "super_admin" || Auth::user()->roles->role_code == "hr")
              <li class="nav-item{{ $activePage == 'personal' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('admin-docs-personal') }}">
                  <span class="sidebar-mini"> D </span>
                  <span class="sidebar-normal"> {{ __('Personal') }} </span>
                </a>
              </li>
            @endif  
          </ul>
        </div>
      </li>
      @endif
      <!-- Menu Management -->
      <li class="nav-item {{ ($activePage == 'archive-menu' || $activePage == 'personal-menu' || $activePage == 'soft-menu' || $activePage == 'dep-menu') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#idMenu" aria-expanded="{{ ($show == 'menu') ? 'true':'false'}}">
          <i class="material-icons">menu_open</i>
          <p>{{ __('Menus') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($show == 'menu') ? 'show':''}}" id="idMenu">
          <ul class="nav">
            @if(Auth::user()->roles->role_code == "super_admin" || Auth::user()->roles->role_code == "metodologiya")
            <li class="nav-item{{ $activePage == 'archive-menu' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin-menu-archive') }}">
                <span class="sidebar-mini"> M </span>
                <span class="sidebar-normal">{{ __('Archive Menu') }} </span>
              </a>
            </li>
            @endif
            @if(Auth::user()->roles->role_code == "super_admin" || Auth::user()->roles->role_code == "hr")
            <li class="nav-item{{ $activePage == 'personal-menu' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin-menu-personal') }}">
                <span class="sidebar-mini"> M </span>
                <span class="sidebar-normal"> {{ __('Personal Menu') }} </span>
              </a>
            </li>
            @endif
            @if(Auth::user()->roles->role_code == "super_admin" || Auth::user()->roles->role_code == "it_admin")
            <li class="nav-item{{ $activePage == 'soft-menu' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin-menu-soft') }}">
                <span class="sidebar-mini"> M </span>
                <span class="sidebar-normal"> {{ __('Software Menu') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'dep-menu' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin-menu-dep') }}">
                <span class="sidebar-mini"> M </span>
                <span class="sidebar-normal"> {{ __('Department Menu') }} </span>
              </a>
            </li>
            @endif
          </ul>
        </div>
      </li>

      @if(Auth::user()->roles->role_code == "super_admin" || Auth::user()->roles->role_code == "it_admin")
      <!-- Ip phone Management -->
      <li class="nav-item{{ $activePage == 'ip-phone' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin-ip') }}">
          <i class="fa fa-phone"></i>
            <p>{{ __('Ip Phone') }}</p>
        </a>
      </li>

      <!-- Soft Management -->
      <li class="nav-item{{ $activePage == 'software' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin-soft.index') }}">
          <i class="fa fa-windows"></i>
            <p>{{ __('Software') }}</p>
        </a>
      </li>
      @endif

      <!-- Soft Management -->
      <li class="nav-item{{ $activePage == 'news' ? ' active' : '' }}">
        <a class="nav-link" href="{{ url('/news') }}">
        <i class="material-icons">post_add</i>
            <p>{{ __('News') }}</p>
        </a>
      </li>

      <!-- 
        <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('table') }}">
            <i class="material-icons">content_paste</i>
              <p>{{ __('Table List') }}</p>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('typography') }}">
            <i class="material-icons">library_books</i>
              <p>{{ __('Typography') }}</p>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('icons') }}">
            <i class="material-icons">bubble_chart</i>
            <p>{{ __('Icons') }}</p>
          </a>
        </li>
        
        <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('notifications') }}">
            <i class="material-icons">notifications</i>
            <p>{{ __('Notifications') }}</p>
          </a>
        </li> 
      -->
     
    </ul>
  </div>
</div>
