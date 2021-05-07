@extends('layouts.admin')

@section('content')
    <div class="container __center">
        <div class="row">
            <div class="login-container hvr-underline-from-center col-lg-6 col-md-6" >
                <h1 class="text-center m-auto " style="border-bottom: 1px solid black"><i>Sign In</i></h1>
                <i id="loading-icon" class="fas fa-spinner faa-spin animated faa-fast"></i>
                <form class="padding-right" id="loginForm">
             <span id="Invalid_User" class="alert alert-danger" >
                Invalid Username Or password .</span>
                    <div class="row mb-2">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="identifier" class="form-control" id="inputEmail3" placeholder="Email Or Username Or Phone">
                            <i class="fas fa-user"></i>
                            <span id="identifier_error" class="error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" autocomplete="1">
                            <i class="fas fa-lock"></i>
                            <span id="password_error" class="error" ></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1" >
                                <label class="form-check-label" for="gridCheck1">
                                    Remember Me
                                </label>
                                <a href="#" class="link-danger" style="margin-left: 19%">forget your password <i class="fas fa-question-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary " id="admin_login">Login</button>
                </form>
            </div>
            <div class="col-lg-6 col-md-6 hvr-bubble-float-left plain-login d-none  d-sm-block">
                <p>
                   <i>Welcome to Tally Bills Company .
                    You can now log in to join the work. This is the employee portal.</i>
                </p>
                <p>
                    To return to the <u> home page</u> , you can click here .<br>
                    <a href="https://translate.google.com/?sl=ar&tl=en&text=%D9%84%D9%84%D8%B1%D8%AC%D9%88%D8%B9%20%D8%A7%D9%84%D9%89%20%D8%A7%D9%84%D8%B5%D9%81%D8%AD%D8%A9%20%D8%A7%D9%84%D8%B1%D8%A6%D9%8A%D8%B3%D9%8A%D8%A9%20%D9%8A%D9%85%D9%83%D9%86%D9%83%20%D8%A7%D9%86%20%D8%AA%D8%B6%D8%BA%D8%B7%20%D9%87%D9%86%D8%A7&op=translate" class="btn btn-primary btn-to-home">
                        Home</a>
                </p>
            </div>
        </div>
    </div>
        @endsection
@section('scripts')
    <script src="{{mix('js/LoginAdmin.js')}}"></script>
@endsection
