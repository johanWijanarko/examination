@php
$role = SiteHelpers::getRoleName(Auth::user()->id)[0];
$username = Auth::user()->name;
$avatar = Auth::user()->user_foto;

if ($avatar) {
    $profile = asset('storage/upload/' . $avatar);
} else {
    $profile = asset('assets/img/avatar/avatar-1.png');
}
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="_token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <title>E-Inventaris</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    {{-- <title>QPASS</title> --}}
    <link rel="icon" href="{{ asset('assets/img/kemhan2.png') }}" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.tree.css') }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

<!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    @stack('page-styles')

</head>
@stack('before-body')

<body>

    {{-- overlay loading --}}
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    {{-- end overlay loading --}}

    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        {{-- <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div> --}}
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    @php
                        //  $pesan = DB::table('tbl_pesan')->whereNull('tgl_baca')
                        // ->join('users', 'id_user_to', '=', 'users.id')->where('id_user_to', Auth::user()->id)->select('tbl_pesan.*', 'users.name');
                        // $jumlah_pesan = $pesan->count() > 0 ? 'beep': '';
                        // print_r($jumlah_pesan);
                    @endphp
                    <?php /*
                                                  <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle {{ $jumlah_pesan }}"><i class="far fa-envelope"></i></a>
                                                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                                      <div class="dropdown-header">Messages
                                                        <div class="float-right">
                                                        </div>
                                                      </div>
                                                      <div class="dropdown-list-content dropdown-list-message">
                                                        @foreach ($pesan->get() as $item)
                                                        <a href="{{ url('help/balas_chat',$item->id_user_from) }}" class="dropdown-item dropdown-item-unread">
                                                          <div class="dropdown-item-avatar">
                                                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-3.png')}}" class="rounded-circle">
                                                            <div class="is-online"></div>
                                                          </div>
                                                          <div class="dropdown-item-desc">
                                                            <b>{{ $item->name }}</b>
                                                              <p>{{ $item->pesan }}</p>
                                                            <div class="time">{{ $item->tgl_kirim }}</div>
                                                          </div>
                                                          @endforeach
                                                        </a>
                                                      </div>
                                                    </div>
                                                  </li>
                                                  */
                    ?>
                    {{-- @php
          $notifikasi = DB::table('notifications')
          ->leftjoin('users', 'user_proyek', '=', 'user_to')->where('user_to', Auth::user()->user_proyek);
        //  $data_notifikasi = $notifikasi->where('read_at', null)->count() > 0 ? 'beep': '';
         $data_notifikasi = $notifikasi->where( function ( $query )
        {
        $query->where('read_at', '=', null )->orWhere('notifications.updated_at', '=', null );})->count() > 0 ? 'beep': '';

         $notifikasi_main = DB::table('notifications')
          ->leftjoin('users', 'user_proyek', '=', 'user_to')->where('user_to', Auth::user()->user_proyek);
      //  echo Auth::user()->user_proyek;
         @endphp --}}
                    {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle {{ $data_notifikasi }}"><i class="far fa-bell"></i></a> --}}
                    <?php /*
                                                  <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle "><i class="far fa-bell"></i></a>
                                                  <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                                    <div class="dropdown-header">Notif
                                                      <div class="float-right">
                                                      </div>
                                                    </div>
                                                    <div class="dropdown-list-content dropdown-list-message">
                                                      {{-- @foreach ($notifikasi_main->select('notifications.*','users.name')->where('read_at', '=', null )->orWhere('notifications.updated_at', '=', null )->limit(10)->orderByDesc('id')->get() as $notif)
                                                      @php
                                                          $link=$notif->link.'?pic_id='.$notif->pic_id.'&pic_auditee_id='.$notif->pic_auditee_id.'&id_trfinspect='.$notif->id_trfinspect;
                                                      @endphp --}}
                                                      {{-- <a href="#" data-id="{{ $notif->id }}" data-link="{{ $link }}" class="dropdown-item dropdown-item-unread notify"> --}}
                                                          <a href="#" data-id="" class="dropdown-item dropdown-item-unread notify">
                                                        <div class="dropdown-item-avatar">
                                                          <img alt="image" src="{{ asset('assets/img/avatar/avatar-3.png')}}" class="rounded-circle">
                                                          {{-- <div class="{{ $data_notifikasi }}"></div> --}}
                                                          <div class=""></div>
                                                        </div>
                                                        {{-- <div class="dropdown-item-desc">
                                                          <b>{{ $notif->name }}</b>
                                                            <p>{{ $notif->type }} : {{ $notif->data }}</p>
                                                          <div class="{{ $notif->created_at }}"></div>
                                                        </div> --}}
                                                        <div class="dropdown-item-desc">
                                                          <b></b>
                                                            <p> : </p>
                                                          <div class=""></div>
                                                        </div>
                                                        {{-- @endforeach --}}
                                                      </a>
                                                    </div>
                                                  </div>
                                                </li>
                                                */
                    ?>
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ $profile }}" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi... {{ strtoupper(Auth::user()->name) }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('ubah_password', Auth::user()->id) }}" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Ubah Password
                            </a>
                            {{-- <div class="dropdown-divider"></div> --}}
                            {{-- <a href="#" class="dropdown-item has-icon text-danger"> --}}
                            {{-- <i class="fas fa-sign-out-alt"></i> Logout --}}
                            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                                {{-- </a> --}}
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            @stack('page-body')
            @push('page-script')
                <script>
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $(function() {
                        $('.notify').on('click', function() {
                            var data_id = $(this).data('id');
                            var data_link = $(this).data('link')
                            // console.log(data_notif);
                            $.ajax({
                                type: "POST",
                                url: '{{ url('data/notif') }}',
                                // processData: false,
                                // contentType: false,
                                dataType: "JSON",
                                data: {
                                    id: data_id,
                                    link: data_link,
                                },
                                success: function(res) {
                                    // console.log(res);
                                    location.href = res;
                                    $("#id_foto").focus();
                                }
                            });
                        });
                    });
                </script>
            @endpush
