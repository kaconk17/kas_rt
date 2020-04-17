<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('assets/ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/LTE/css/AdminLTE.min.css')}}">
 

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{url('/home')}}"><b>KAS</b>RT</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    <p class="login-box-msg">Please Login</p>
    @if(Session::has('alert-danger'))
    <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            
        </div>
      @endif
      <div id="error"></div>
    <form action="{{url('/postlogin')}}" id="login-form" method="post">
      @csrf
      <div class="form-group has-feedback">
        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="{{ old('password') }}" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" id="btn-login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   
   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{asset('assets/jquery/js/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!}
    </script>
<script type="text/javascript">
  $(document).ready(function(){
       
       $("#login-form").submit(function(event) {
           event.preventDefault();
           var data = $(this).serialize();
           var btn = $("#btn-login");
               btn.html('Sign In');
               btn.attr('disabled', true);
           $.ajax({
               url: APP_URL+'/postlogin',
               type: 'POST',
               dataType: 'json',
               data: data,
           })
           .done(function(resp) {
               if (resp.success) {
                 localStorage.setItem('user_token',resp.token);
                 localStorage.setItem('user_name',resp.user.nama);
                localStorage.setItem('user_id_user',resp.user.id);
                 
             window.location.href = "{{ route('home')}}";
               }
               else
               $("#error").html("<div class='alert alert-danger'><div>Login Gagal</div></div>");
           })
           .fail(function() {
               $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
            //toastr['warning']('Tidak dapat terhubung ke server !!!');
           })
           .always(function() {
               btn.html('Sign In');
               btn.attr('disabled', false);
           });
           
           return false;
           });
       });
</script>

</body>
</html>
