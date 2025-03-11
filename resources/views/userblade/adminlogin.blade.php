<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Login Form</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <style media="screen">
            *,
            *:before,
            *:after{
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }
            body{
                background-color: orange;
            }
            .background{
                width: 500px;
                height: 500px;
                position: absolute;
                transform: translate(-50%,-50%);
                left: 50%;
                top: 50%;
            }
            .background .shape{
                height: 200px;
                width: 200px;
                position: absolute;
                border-radius: 50%;
            }
            .shape:first-child{
                background: linear-gradient(
                    #ff413c,#fff
                    );
                left: -80px;
                top: -80px;
            }

            form{
                height: 500px;
                width: 900px;
                background-color: rgba(255,255,255,0.13);
                position: absolute;
                transform: translate(-50%,-50%);
                top: 50%;
                left: 50%;
                border-radius: 10px;
                backdrop-filter: blur(10px);
                border: 2px solid rgba(255,255,255,0.1);
                box-shadow: 0 0 40px rgba(8,7,16,0.6);
                padding: 50px 35px;
            }
            form *{
                font-family: 'Poppins',sans-serif;
                color: #ffffff;
                letter-spacing: 0.5px;
                outline: none;
                border: none;
            }
            form h3{
                font-size: 32px;
                font-weight: 500;
                line-height: 42px;
                text-align: center;
            }

            label{
                display: block;
                margin-top: 30px;
                font-size: 16px;
                font-weight: 500;
            }
            input{
                display: block;
                height: 50px;
                width: 100%;
                background-color: rgba(255,255,255,0.07);
                border-radius: 3px;
                padding: 0 10px;
                margin-top: 8px;
                font-size: 14px;
                font-weight: 300;
            }
            ::placeholder{
                color: #e5e5e5;
            }
            button{
                margin-top: 50px;
                width: 100%;
                background-color: #ffffff;
                color: #080710;
                padding: 15px 0;
                font-size: 18px;
                font-weight: 600;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="background">
            <div class="shape"></div>
        </div>
        <form action="{{route('adminloginfunction')}}" method="post">
            @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('fail'))
            <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif
            @csrf
            <h3>Admin Login</h3>

            <label for="email">Email</label>
            <span class="text-danger">@error('email'){{$message}}@enderror</span>
            <input type="text" placeholder="Email" name="email" id="email" value="{{old('email')}}">

            <label for="password">Password</label>
            <span class="text-danger">@error('password'){{$message}}@enderror</span>
            <input type="password" placeholder="Password" name="password" id="password">


            <button>Log In</button>
            <p class="mb-5 pb-lg-2" style="color: #ffffff">Register an account?<a href="adminregisterpage" style="color: #ffffff">Register</a></p>
            
            <div class="text-center">
                <a href="/auth/github/redirect" class="btn btn-dark btn-lg">
                    <i class="fab fa-github"></i> Login with GitHub
                </a>
            </div>
        </form>

    </body>
</html>
