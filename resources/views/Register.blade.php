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
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}" />


</head>

<body>
  @if(Session::has('error'))
  <p class="alert alert-danger">{{ Session::get('error') }}</p>
  @endif



  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Register</h5>
            @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif
            <form class="form-signin" role="form" method="Post" action="/registerAction" id="form" enctype="multipart/form-data">
              @csrf

              <input type="hidden" name="form_submit" value=1 />

              <div class="form-label-group">
                <input type="text" id="inputName" name="name" class="form-control" value="{{old('name')}}" placeholder="Fullname" autofocus>
                @if ($errors->has('name'))
                <p style="color:red">{{ $errors->first('name') }}</p>
                @endif
                <label for="inputName">Fullname</label>
              </div>

              <div class="form-label-group">
                <input type="email" id="inputEmail" name="email" class="form-control" value="{{old('email')}}" placeholder="Email address" autofocus>
                @if ($errors->has('email'))
                <p style="color:red">{{ $errors->first('email') }}</p>
                @endif
                <label for="inputEmail">Email address</label>
              </div>

              <div class="form-label-group">
                <input type="password" name='password' id="inputPassword" class="form-control" placeholder="Password" autofocus>
                @if ($errors->has('password'))
                <p style="color:red">{{ $errors->first('password') }}</p>
                @endif
                <label for="inputPassword">Password</label>
              </div>

              <div class="form-label-group">
                <input type="password" name='password_confirmation' id="confirm_password" class="form-control"  placeholder="Confirm Password" autofocus>
                @if ($errors->has('password_confirmation'))
                <p style="color:red">{{ $errors->first('password_confirmation') }}</p>
                @endif
                <label for="confirm_password">Confirm Password</label>
              </div>

              <div class="form-label-group">
                <div class='custom-control custom-radio mb-3'>
                  <label for='gender'>Gender</label>
                  <br>
                  <label class='radio-inline'>
                    <input type="radio" id="male" name="gender" value="male"> Male
                  </label>
                  <label class='radio-inline'>
                    <input type="radio" id="female" name="gender" value="female"> Female
                  </label>
                  <label class='radio-inline'>
                    <input type="radio" id="other" name="gender" value="other"> Other
                  </label>
                  @if ($errors->has('gender'))
                  <p style="color:red">{{ $errors->first('gender') }}</p>
                  @endif
                </div>
              </div>
              <button id='signin' class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
              <span class="login">Already have an account? <a class='loginRef' href="./login">Login</a></span>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>










</body>

</html>