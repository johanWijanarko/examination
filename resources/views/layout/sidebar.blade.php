@php
    $role     = SiteHelpers::getRoleName(Auth::user()->id)[0];
    $username = Auth::user()->name;
    $avatar   = Auth::user()->user_foto;
    
    if($avatar){
        $profile = asset('storage/upload/'.$avatar);
    }else {
        $profile = asset('assets/img/avatar/avatar-1.png');
    }
@endphp
<div class="main-sidebar" style="background: #f7f7f7;">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#"><img src="{{ asset('assets/img/cccc.png') }}" class="img-responsive" width="100%" height="115px"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#"><img src="{{ asset('assets/img/ccccc.png') }}" class="img-responsive" width="40"></a>
        </div>

		<div class="sidebar-avatars mt-4">
			<img src="{{ $profile}}" class="img-responsive img-fluid"><br>
			{{-- <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="img-responsive img-fluid"><br> --}}
			<strong>{{ $username }}</strong><br>
			<span class="text-muted">[{{ $role }}]</span>
		</div>
        <ul class="sidebar-menu mt-2">
            <li class="menu-header">Homepage</li>
            <li class="@if (Request::segment(1) == 'dashboard') active @endif"><a href="{{ url('/dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a></li>

            <li class="menu-header">Main</li>
            @foreach (SiteHelpers::main_menu() as $mm)
                {{-- @if (isset($role[$mm->url])) --}}
                @can($mm->permission . '-list')
                    <li class="dropdown @if (Request::is($mm->url . '/*')) active @endif">
                        <a href="#" class="nav-link has-dropdown"><i
                                class="{{ $mm->icon }}"></i><span>{{ $mm->nama_menu }} </span></a>

                        <ul class="dropdown-menu">
                            @foreach (SiteHelpers::sub_menu() as $sm)
                                @if ($sm->master_menu == $mm->id)
                                    @can($sm->permission . '-list')
                                        <li class="active"><a href=" {{ url($sm->url) }}"
                                                class="nav-link @if (Request::segment(2) == $sm->permission) beep beep-sidebar @endif">{{ $sm->nama_menu }}</a></li>
                                        {{-- <li class="active"><a href=" {{ url($sm->url)}}" class="nav-link beep beep-sidebar">{{ $sm->nama_menu }}</a></li> --}}
                                    @endcan
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endcan
                {{-- @endif --}}
            @endforeach
            {{-- <li class="active"><a class="" href="blank.html"><i class="fas fa-money-check"></i><span>{{ $mm->nama_menu }}</span></a></li> --}}
        </ul>
    </aside>
</div>
