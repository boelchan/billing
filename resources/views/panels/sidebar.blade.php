@php
$configData = Helper::applClasses();
@endphp
<div class="main-menu menu-fixed {{($configData['theme'] === 'dark') ? 'menu-dark' : 'menu-light'}} menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
        <a class="navbar-brand" href="{{url('/')}}">
          <span class="brand-logo">
            
          </span>
          <h2 class="brand-text">{{ env('APP_NAME') }}</h2>
        </a>
      </li>
      <li class="nav-item nav-toggle">
        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
          <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
          <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
        </a>
      </li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      {{-- Foreach menu item starts --}}
      @if(isset($menuData[0]))
        @php $menus = $menuData[0]->menu; @endphp
        @foreach($menus as $menu)
          @php $guard = true; @endphp
          @if(Auth::check() && (bool)array_intersect(["all", Auth::user()->roles->first()->name], $menu->guard))
            @php $guard = true; @endphp
          @endif
          @if(isset($menu->navheader))
            @if($guard)
            <li class="navigation-header">
              <span>{{ $menu->navheader }}</span>
              <i data-feather="more-horizontal"></i>
            </li>
            @endif
          @else
            {{-- Add Custom Class with nav-item --}}
            @php
            $custom_classes = "";
            if(isset($menu->classlist)) {
              $custom_classes = $menu->classlist;
            }
            @endphp
              @if($guard)
              {{-- <li class="nav-item {{ Route::currentRouteName() === $menu->slug ? 'active' : '' }} {{ $custom_classes }}"> --}}
                <li class="nav-item {{ Request::segment(1) == $menu->slug ? 'active' : '' }} {{ $custom_classes }}">
                  <a href="{{isset($menu->url)? url($menu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($menu->newTab) ? '_blank':'_self'}}">
                    <i data-feather="{{ $menu->icon }}"></i>
                    <span class="menu-title text-truncate">{{ ($menu->name) }}</span>
                    @if (isset($menu->badge))
                      <?php $badgeClasses = "badge badge-pill badge-light-primary ml-auto mr-1" ?>
                      <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }} ">{{$menu->badge}}</span>
                    @endif
                  </a>
                @if(isset($menu->submenu))
                  @include('panels/submenu', ['menu' => $menu->submenu])
                @endif
              </li>
            @endif
          @endif
        @endforeach
      @endif
      {{-- Foreach menu item ends --}}
    </ul>
  </div>
</div>
<!-- END: Main Menu-->
