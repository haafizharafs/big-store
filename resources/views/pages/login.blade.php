<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('images/big-warna.png') }}" />
    <title>Login - Big Store</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg {
            background-image: url('{{ asset('images/login-bg.jpg') }}');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="bg">
        <div class="container">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="{{asset ('images/big-warna-full.png')}}" style="max-width: 30%" alt="Logo Big Warna Full">
                    </div>
                    <div class="card-body text-center">
                        <h2><b>BIG STORE</b></h2>
                        <h4><b>Aplikasi Manajemen Inventaris PT. Borneo Inovasi Gemilang</b></h4>
                        <hr>
                        @if(session('error'))
                        <div class="text-center alert alert-danger">
                            {{session('error')}}
                        </div>
                        @endif
                        <form action="{{ route('actionlogin') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required="">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required="">
                            </div>
                            <button type="submit" class="btn btn-danger btn-block">Log In</button>
                            <hr>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
