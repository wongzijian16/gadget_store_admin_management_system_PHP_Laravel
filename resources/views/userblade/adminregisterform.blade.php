<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Register Form</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                background-color: #e9aa0b;
                padding: 95px;
            }

            * {
                box-sizing: border-box;
            }


            .container {
                padding: 55px;
                background-color: white;
            }


            input[type=text], input[type=password] {
                width: 100%;
                padding: 15px;
                margin: 5px 0 22px 0;
                display: inline-block;
                border: none;
                background: #f1f1f1;
            }

            input[type=text]:focus, input[type=password]:focus {
                background-color: #ddd;
                outline: none;
            }


            hr {
                border: 1px solid #f1f1f1;
                margin-bottom: 25px;
            }


            .registerbtn {
                background-color: black;
                color: white;
                padding: 16px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
                opacity: 0.9;
            }

            .registerbtn:hover {
                opacity: 1;
            }


            a {
                color: dodgerblue;
            }


            .signin {
                background-color: #f1f1f1;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <form action="{{route('registernewAdmin')}}" method="post">
            @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('fail'))
            <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif
            @csrf
            <div class="container">
                <h1>Register Form</h1>
                <p>Fill in the information to register an account</p>
                <hr>

                <label for="id"><b>ID</b></label>
                <span class="text-danger">@error('id'){{$message}}@enderror</span>
                <input type="text" placeholder="Enter ID" name="id" id="id" value="{{old('id')}}">

                <label for="username"><b>Name</b></label>
                <span class="text-danger">@error('username'){{$message}}@enderror</span>
                <input type="text" placeholder="Enter Name" name="username" id="username" value="{{old('username')}}">

                <label for="email"><b>Email</b></label>
                <span class="text-danger">@error('email'){{$message}}@enderror</span>
                <input type="text" placeholder="Enter Email" name="email" id="email" value="{{old('email')}}">

                <label for="phone"><b>Phone</b></label>
                <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                <input type="text" placeholder="Enter Phone" name="phone" id="phone" value="{{old('phone')}}">

                <label for="address"><b>Address</b></label>
                <span class="text-danger">@error('address'){{$message}}@enderror</span>
                <input type="text" placeholder="Enter Address" name="address" id="address" value="{{old('address')}}">

                <label for="position"><b>Position</b></label>
                <span class="text-danger">@error('position'){{$message}}@enderror</span>
                <select name="position" id="position">
                    <option value="" disabled selected>Select Position</option>
                    <option value="admin" {{ old('position') == 'admin' ? 'selected' : '' }}>admin</option>
                    <option value="customer" {{ old('position') == 'customer' ? 'selected' : '' }}>customer</option>
                </select>

                <label for="password"><b>Password</b></label>
                <span class="text-danger">@error('password'){{$message}}@enderror</span>
                <input type="password" placeholder="Enter Password" name="password" id="password" value="{{old('password')}}">

                <label for="confirmpassword"><b>Confirm Password</b></label>
                <span class="text-danger">@error('confirmpassword'){{$message}}@enderror</span>
                <input type="password" placeholder="Confirm Password" name="confirmpassword" id="confirmpassword" value="{{old('confirmpassword')}}">
                <hr>


                <button type="submit" class="registerbtn">Register</button>
            </div>

            <div class="container signin">
                <p>Sign In Now? <a href="adminloginpage">Sign in</a>.</p>
            </div>
        </form>
    </body>
</html>