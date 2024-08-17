<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .login-box {
            display: flex;
            width: 50%;
        }

        .login-box img {
            width: 50%;
            height: auto;
        }

        .login-card-body {
            padding: 20px;
        }

        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <div class="costumCnt">
    <div class="d-flex-block  d-md-flex w-75">
        <div class="w-100 w-md-50">
            <img src="/Image/missq.jpg" width="100%" height="100%" alt="MissQ image">
        </div>
        <div class="w-100 w-md-50">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Sign in to manage event</h5>
                    <form method="POST" action="{{ url('/login') }}" id="loginForm">
                        @csrf
                        @method('post')
                        @if (session('error'))
                            <div class="alert alert-danger">{{session('error') }}</div>
                        @endif

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="username" name="username" required
                                    placeholder="Username">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required
                                    placeholder="Password">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block w-100" id="loginBtn">
                            <li class="fa fa-unlock"></li>
                            <span id="login">Login</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                document.getElementById('loginBtn').disabled = true;
                document.getElementById('login').textContent = "Logging in....";
            });
        });
    </script>
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<style>
    body{
        padding: 0;
        margin: 0;
    }
    .costumCnt{
        width: 100%;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: url('/Image/bgd.jpg');
        background-size: cover;
    }
</style>

