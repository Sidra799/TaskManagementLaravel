<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
  <script src="/js/login.js"></script>
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif
            @if(session()->has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif

            <h5 class="card-title text-center">Sign In</h5>
            <form class="form-signin" role="form" id="frmLogin" action="/loginAction" enctype="multipart/form-data" method="post">
              @csrf
              <div class="form-label-group">
                <input type="email" id="inputEmail" name="email" class="form-control" value="{{old('email')}}" placeholder="Email address" autofocus>
                @if ($errors->has('email'))
                <p style="color:red">{{ $errors->first('email') }}</p>
                @endif
                <label for="inputEmail">Email address</label>
              </div>


              <div class="form-label-group">
                <input type="password" name='password' id="inputPassword" class="form-control" placeholder="Password">
                @if ($errors->has('password'))
                <p style="color:red">{{ $errors->first('password') }}</p>
                @endif
                <label for="inputPassword">Password</label>
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember password</label>
                <label style="margin-left: 60px;"><a href="forgetPassword" style="color: black;">Forget Password?</a></label>


              </div>
              <button id='signin' class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
              <span class="register">Don't have an account? <a id='register' href="./register">Register</a></span>


            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>