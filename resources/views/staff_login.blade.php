<!DOCTYPE html>
<html lang="en">
<head>
	<title>Global Shoppers - Staff Login</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base_url" content="{{url('/')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/css/main.css')}}">
</head>
<body style="background-color: #666666;">

	<div class="limiter">

		<div class="container-login100">
			<div class="wrap-login100">

				<form class="login100-form validate-form" id="login-staff" autocomplete="off" method="POST">
                    <div id="message">
                        @if ($errors->first('error') )
                        <div class="alert alert-danger">
                                {{ $errors->first('error') }}
                        </div>

                    @endif
                    </div>
                    {{ csrf_field() }}
					<span class="login100-form-title p-b-43">
						Staff Login
					</span>


					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username">
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="#" class="txt1">
								Forgot Password?
							</a>
						</div>
					</div>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn" id="submit">
							Login
						</button>
					</div>

				</form>

				<div class="login100-more" style="background-image: url({{asset('assets/login/images/women-1209678_1280.jpg')}});">
				</div>
			</div>
		</div>
	</div>

    <script src="{{url('assets/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('assets/login/vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{url('assets/login/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{url('assets/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{url('assets/login/vendor/select2/select2.min.js')}}"></script>
    <script src="{{url('assets/login/js/main.js')}}"></script>
    <script src="{{url('assets/general_assets/utility.js')}}"></script>
    <script src="{{url('assets/administrator/js/staff/login.js')}}"></script>

</body>
</html>
