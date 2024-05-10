@extends('layouts.auth')
@section('content')

<form class="form-signin mt-5" id="signupForm" method="post">
    @csrf
    <h1 class="h3 mb-3 font-weight-normal"> Sign Up</h1>
    <label for="inputName" class="sr-only">Name</label>
    <input type="text" id="inputName" class="form-control " name="name" placeholder="Name">
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control " name="email" placeholder="Email address">
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password">

    <button class="btn btn-lg btn-primary btn-block">Sign Up</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2024</p>
</form>


<script>
    $('#signupForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var url = '{{url('register')}}';
        // using commom request method
        commonRequest(url,'POST',formData, function(response) {
            if (response.success) {
                window.location = '{{url('/')}}';
                successMessage(response.message);
            }
        });
    });
</script>

@endsection