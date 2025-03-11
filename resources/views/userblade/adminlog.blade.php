@extends('welcome')

@section('content')
<h2>Admin Logs</h2>
<br/>
<div class='container'> 
    <form method="POST" action="{{route('renderUserLogRecords')}}">
        {{ csrf_field() }}
        <div class="mb-2">
            <label for="user_type" class="form-label">User Type</label>
            <select class="form-select form-select-sm" name="userType" aria-label=".form-select-sm example">
                <option value="admin">admin</option>
            </select>
        </div>
        <div class="mb-2">
            <label for="user_type" class="form-label">Log Date</label>
            <input class="inputbox" name="logDate" type="date">
        </div>
        <button class="btn btn-dark form-control text-center" type="submit">View</button>

    </form>
</div>
@endsection