<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src=""
           alt=""
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @if(Auth::user()->photo)
                @php $profilePhoto=Auth::user()->photo @endphp
            @else
                @php $profilePhoto='/assets/admin/img/avatar.png' @endphp
            @endif
        <div class="image">
          <img src="{{ asset($profilePhoto) }}" class="img-circle elevation-2" alt="">
        </div>
        <div class="info">
        <a href="{{route('profile')}}" class="d-block">{{Auth::user()->name}}</a>
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route("dashboard") }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>          
          <li class="nav-item has-treeview {{ (request()->routeIs('student.*','exStudent.*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->routeIs('student.*','exStudent.*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-restroom"></i>
              <p>Student <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview">
              {{-- <li class="nav-item has-treeview {{ (request()->routeIs('student.setup.*')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (request()->routeIs('student.setup.*')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tools"></i>
                  <p>
                    Setting
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route("student.setup.academicYear.index") }}" class="nav-link {{ (request()->routeIs('student.setup.academicYear.*')) ? ' active' : '' }}">
                    <i class="far fa-circle nav-icon"></i> <p>{{__('Academic Year') }}</p></a>
                  </li>                  
                </ul>
              </li> --}}
              <li class="nav-item"><a href="{{ route("student.index") }}" class="nav-link {{ (request()->routeIs('student.*')) ? ' active' : '' }}">
                <i class="far fa-user nav-icon"></i> <p>{{__('Student List') }}</p></a>
              </li>
              <li class="nav-item"><a href="{{ route("exStudent.index") }}" class="nav-link {{ (request()->routeIs('exStudent.*')) ? ' active' : '' }}">
                <i class="far fa-user nav-icon"></i> <p>{{__('Ex-Student List') }}</p></a>
              </li>
              
            </ul>
          </li>
{{--           
          <li class="nav-item has-treeview {{ (request()->routeIs('contact.*','smsTemplate.*','sms.*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->routeIs('contact.*','smsTemplate.*','sms.*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-envelope"></i>
              <p>SMS & Notification <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="{{ route("smsTemplate.index") }}" class="nav-link {{ (request()->routeIs('smsTemplate.*')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> <p>SMS Template</p></a>
              </li>
              <li class="nav-item"><a href="{{ route("contact.index") }}" class="nav-link {{ (request()->routeIs('contact.*')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> <p>Phone Book</p></a>
              </li>
              <li class="nav-item"><a href="{{ route("sms.send") }}" class="nav-link {{ (request()->routeIs('sms.send')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> <p>SMS Send</p></a>
              </li>
              <li class="nav-item"><a href="{{ route("sms.report") }}" class="nav-link {{ (request()->routeIs('sms.report')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> <p>Report</p></a>
              </li>
            </ul>
          </li> --}}
          
          <li class="nav-item has-treeview {{ (request()->routeIs('posts*','menu*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-list-alt"></i>
              <p>
                Web Site
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" {{ (request()->routeIs('posts*','menu*')) ? 'style="display: block;"' : '' }}>
              <li class="nav-item"><a href="{{ route('menus.index') }}" class="nav-link {{ (request()->routeIs('menu*')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> Menus</a>
              </li>
              @foreach($postType as $key=>$item)
              <li class="nav-item has-treeview {{ (request()->get('type') == $item['postType']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (request()->get('type') == $item['postType']) ? 'active' : '' }}">
                  <i class="nav-icon fas {{$item['icon']}}"></i>
                  <p>
                    {{$item['title']}}
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('posts.index') }}?type={{$item['postType']}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i> All {{$item['title']}}</a>
                  </li>
                  <li class="nav-item"><a href="{{ route('posts.create') }}?type={{$item['postType']}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i> New {{$item['title']}}</a>
                  </li>
                  @if($item['taxonomy']==true)
                  <li class="nav-item"><a href="{{ route('taxonomy.index') }}?type={{$item['postType']}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i> Category</a>
                  </li>
                  @endif
                </ul>
              </li>
              @endforeach
            </ul>
          </li>
          <li class="nav-header">Super Admin</li>
          @role('superadmin','admin')
          <li class="nav-item has-treeview {{ (request()->routeIs('users.*','branch.*','location.*','roles.*','permissions.*','language.*','settings')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->routeIs('users.*','branch.*','location.*','roles.*','permissions.*','language.*','settings')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Setings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link {{ (request()->routeIs('users.*')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> Users</a>
              </li>
              <li class="nav-item"><a href="{{ route('location.index') }}" class="nav-link {{ (request()->routeIs('location.*')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> Location</a>
              </li>
              @role('superadmin')
              <li class="nav-item"><a href="{{ route('roles.index') }}" class="nav-link {{ (request()->routeIs('roles.*')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> Role</a>
              </li>
              <li class="nav-item"><a href="{{ route('permissions.index') }}" class="nav-link {{ (request()->routeIs('permissions.*')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> <p>Permission</p></a>
              </li>
              <li class="nav-item"><a href="{{ route('language.index') }}" class="nav-link {{ (request()->routeIs('language.*')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> Language</a>
              </li>
              @endrole
              <li class="nav-item"><a href="{{ route('settings') }}" class="nav-link {{ (request()->routeIs('settings')) ? ' active' : '' }}">
                <i class="far fa-circle nav-icon"></i> Settings</a>
              </li>
            </ul>
          </li>
          @endrole


          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>{{ __('Logout') }}</p>
            </a>
          </li>
          <li class="nav-header"></li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
