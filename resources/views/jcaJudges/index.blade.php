<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <div class="costumCnt">
        <div class="d-flex-block  d-md-flex w-75">
            <div class="w-100 w-md-50">
                <img src="/Image/missq.jpg" width="100%" height="100%" alt="MissQ image">
            </div>
            <div class="w-100 w-md-50">
                <div class="card h-100">
                    <div class="card-body cardCont">
                        <div class="welcome">
                            <h1 >Welcome</h1>
                        <label >to miss Q</label>
                        </div>
                        <form action="{{ route('judges.login', ['event' => $event]) }}" method="POST" id="loginForm">
                            @csrf
                            @method('POST')
                            @if (session('error'))
                            <div class="alert alert-danger">{{session('error') }}</div>
                        @endif
                            <div class="{{session('error') ? 'mt-3':'mt-5'}} mb-4">
                                <div class="labelCont">
                                    <label for="accessCode" class="form-label" id="accesCodeLabel">Access Code</label>
                                </div>
                                <input type="text" class="form-control" id="accessCode" name="accessCode" value="{{ $accessCode }}" required>
                            </div>
                            <input type="hidden" name="category" value="{{ $category }}" required>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark" id="loginBtn">
                                    <li class="fa fa-unlock"></li>
                                    <span id="login">Register</span>
                                </button>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-eZvLbTMpPwV5By6K/iU6T6sGpH5Xfqt7WGPLbNnj6Hcg1JZ/6KLrGveJZY3fm3nF" crossorigin="anonymous">
    </script>
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
        background-size: cover;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }
    .welcome{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .welcome label{
        margin-top: -10px;
    }
   .labelCont{
   width: 100%;
   display: flex;
   justify-content: center;
   }
   #accessCode{
    text-align: center;
   }
</style>