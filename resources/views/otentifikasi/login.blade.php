<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login - Inventory Digital Kementrian Pertahanan Republik Indonesia</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="{{ asset('assets/img/ccc.png') }}" alt="logo" width="100%" class="mb-3 mt-2">
            <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">Sistem Inventory</span></h4>
            {{-- <p class="text-muted">Sistem Informasi Management Audit Internal</p> --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
              {{-- @csrf --}}
              {{ csrf_field() }}
              <div class="form-group">
                <label for="email">Username</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" tabindex="1"required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                <div class="invalid-feedback">
                  Please fill in your username
                </div>
            </div>
              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                <div class="invalid-feedback">
                  please fill in your password
                </div>
              </div>
              @if (session('message'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                 <strong>{{ session('message') }}</strong> 
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
             @endif
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                  <label class="custom-control-label" for="remember-me">Remember Me</label>
                </div>
              </div>

              <div class="form-group text-right">
                {{-- <a href="auth-forgot-password.html" class="float-left mt-3">
                  Forgot Password?
                </a> --}}
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  Login
                </button>
              </div>
            </form>

            <div class="text-center mt-5 text-small">
              Copyright © Kementerian Pertahanan Republik Indonesia 2022
            </div>
          </div>
        </div>
         <div class="col-lg-8 col-12 order-lg-2 order-1 overlay-gradient-bottom" data-background="{{ asset('assets/img/3.png') }}" style="
  background-repeat: no-repeat;
  background-size: 110%;">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-2">
                {{-- <h1 class="mb-2 display-4 font-weight-bold">Kementrian Pertahanan Republik Indonesia</h1> --}}
              </div>
              <h2 class="font-weight-normal text-muted-transparent">Kementerian Pertahanan Republik Indonesia</h2>
              {{-- Photo by <a class="text-light bb" target="_blank" href="https://unsplash.com/photos/a8lTjWJJgLA">Justin Kauffman</a> on <a class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a> --}}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <!-- Page Specific JS File -->
</body>
</html>
