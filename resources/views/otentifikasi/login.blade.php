<!doctype html>
<html lang="en">

<head>
    <title>Login SIADU</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('assets2/css/style.css') }}">
    <!-- <link rel="stylesheet" href="css/style.css"> -->

</head>

<body class="img js-fullheight" style="background-image: url({{ asset('assets/img/kemhan.jpg') }}); ">
  <!-- <img src="{{ asset('assets/img/inv2.png') }}" alt="logo" width="100%" class="mb-3 mt-2"> -->
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    {{-- <h2 class="heading-section">Login</h2> --}}
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                      <h2 class="heading-section text-center">SIADU</h2>
                        <h3 class="mb-4 text-center">Sistem Administrasi Ujian</h3>
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
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input id="name" type="text" placeholder="Username" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" tabindex="1" required autocomplete="name" autofocus> 
                            </div>
                            <div class="form-group">
                                <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
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
                                <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>
                            
                        </form>
                        {{-- <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p> --}}
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets2/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets2/js/popper.js') }}"></script>
    <script src="{{ asset('assets2/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets2/js/main.js') }}"></script>

    
    <!-- <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script> -->

</body>

</html>