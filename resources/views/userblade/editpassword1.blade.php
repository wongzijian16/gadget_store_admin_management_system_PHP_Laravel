<style>
    body {font-family: Arial, Helvetica, sans-serif;}
    * {box-sizing: border-box;}

    input[type=password], select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        margin-bottom: 16px;
        resize: vertical;
    }

    input[type=submit] {
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }
</style>
<body>
    <div class="container">
        <h1>Change Password</h1>
        <form action="/updatepassword" method="post">
            @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('fail'))
            <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif
            @csrf
            <label for="currentpassword">Current Password</label>
            <span class="text-danger">@error('currentpassword'){{$message}}@enderror</span>
            <input type="password" id="currentpassword" name="currentpassword">

            <label for="newpassword">New Password</label>
            <span class="text-danger">@error('newpassword'){{$message}}@enderror</span>
            <input type="password" id="newpassword" name="newpassword">
            
            <label for="confirmpassword">Confirm Password</label>
            <span class="text-danger">@error('confirmpassword'){{$message}}@enderror</span>
            <input type="password" id="confirmpassword" name="confirmpassword">

            <input type="submit" value="Submit">
        </form>
    </div>
</body>