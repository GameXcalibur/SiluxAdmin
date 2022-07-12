<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>siluxAdmin : Log In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <style>
        body,
        html {
            height: 100vh;
            background-image: linear-gradient(#000000, #13479d);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        .bold {
            font-weight: bold;
        }

        label {
            position: relative;
            bottom: -5px;
            left: 4px;
            font-size: .8em;
            font-weight: bold;
            color: #068300;
        }

        .btn {
            background: #068300 !important;
            outline: none !important;
            border: none !important;
        }

        .btn:active,
        .btn:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .form-control:focus {
            box-shadow: none !important;
            border: 1px solid #068300 !important;
        }

    </style>


    <div class="container">

        <div class="row">
            <div class="col-md-6 mt-4 offset-md-3">
                <div class="row justify-content-center">
                    <img src="{{ asset('images') }}/logo.png" width="80%"></img>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="{{ route('login.2') }}">
                        @csrf

                        <div class="form-group">
                                <label>Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                                <label>Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>




                        <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Log In</button>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-primary btn-block" type="button">Don't Have An Account?</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-primary btn-block" type="button">Forgot Password?</button>
                                    </div>

                                </div>

                            </div>
                    </form>

                    </div>
                </div>

            </div>
        </div>

    </div>


    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
