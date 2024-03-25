<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('/') }}" target="_blank" class="brand-link">
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
                @php $profilePhoto='assets/admin/img/avatar.png' @endphp
            @endif
        <div class="image">
          <img src="{{asset('/'.$profilePhoto)}}" class="img-circle elevation-2" alt="">
        </div>
        <div class="info">
        <a href="{{route('profile')}}" class="d-block">{{Auth::user()->name}}</a>
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
          {{-- @if(!Auth::user()->hasAnyRole(['Agent','Manager','Admin']))
          <li class="nav-item">
            <a href="{{ url("/selfReg") }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Apply</p>
            </a>
          </li>
          @endif --}}
          @if(Auth::user()->hasAnyRole(['Manager','Admin','SuperAdmin']))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="{{ route('product.products.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> Products</a>
              </li>
              <li class="nav-item"><a href="{{ route('product.productsCat') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> Category</a>
              </li>
              <li class="nav-item"><a href="{{ route('product.orderStatus.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> Order Status</a>
              </li>
            </ul>
          </li>
          @endif
          @if(Auth::user()->hasAnyRole(['Manager','Admin','SuperAdmin','Salesman']))
          <li class="nav-item">
            <a href="{{ route("order.index") }}" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Orders</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route("customers.index") }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Customers</p>
            </a>
          </li>
          @endif

          @if(Auth::user()->hasAnyRole(['Manager','Admin','SuperAdmin']))
          <li class="nav-header">Manager</li>
          @foreach($postType as $key=>$item)
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
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
          @endif

          @if(Auth::user()->hasAnyRole(['Admin','SuperAdmin']))
          <li class="nav-header">Admin</li>          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Setings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              {{-- config('app.admin_prefix','admin').'. --}}
              <li class="nav-item"><a href="{{ route('shippingRole.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> Shipping Role</a>
              </li>
              <li class="nav-item"><a href="{{ route('size.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> Size</a>
              </li>
              <li class="nav-item"><a href="{{ route('color.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> Color</a>
              </li>
              <li class="nav-item"><a href="{{ route('userRole') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> User Role</a>
              </li>
              <li class="nav-item"><a href="{{ route('settings') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> Settings</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route("menus.index") }}" class="nav-link">
              <i class="nav-icon fas fa-bars"></i>
              <p>Menus</p>
            </a>
          </li>
          @endif     

          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>{{ __('Logout') }}</p>
            </a>
          </li>
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>