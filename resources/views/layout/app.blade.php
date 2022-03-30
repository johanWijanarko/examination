
@include('layout.header')
@include('layout.sidebar')
@include('sweetalert::alert')
@php
if(Request::segment(1) == 'dashboard'):
	$title = 'Homepage';
	$group = '';
else:
	$segment1 = Request::segment(1);
	$group    = SiteHelpers::get_title_page($segment1);
	$group    = '<div class="breadcrumb-item"><a href="#">'.$group.'</a></div>';
	$segment2 = Request::segment(1).'/'.Request::segment(2);
	$title    = SiteHelpers::get_title_page($segment2);
endif;
@endphp
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="{{ url('/dashboard/') }}">Dashboard</a></div>
			          <?=$group?>
              <div class="breadcrumb-item"><a href="#">{{ $title }}</a></div>
            </div>
          </div>
          @yield('content')
        </section>
      </div>
      {{-- @include('footer.js') --}}
      @include('layout.footer')
      @include('layout.js')
    </div>
  </div>

