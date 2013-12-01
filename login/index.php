<!DOCTYPE html>
<html>
<head>
  <!-- Page information -->
  <title>Zip-Manager | Login</title>
  <meta charset="UTF-8"/>
  <!-- Icon -->
  <link rel="shortcut icon" href="../assets/img/favicon.ico" />
  <!-- Stylesheets -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!--Header-->
    <div class="page-header">
      <h2>Zip Manager | Login</h2>
    </div>
    <ul class="breadcrumb">
      <li class="active">Home</li>
    </ul>
    <hr>
    <!--Content -->
    <form action="./VerifyLogin.php" method="post">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">

          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" placeholder="Username">

          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password">

          <br>
          <button class="btn btn-success" type="submit" name="submit"> Sign in </button>

        </div>
      </div>
    </form>
    <!-- Footer -->
    <hr>
    <footer>
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright &copy; Soartex 2013-2014</p>
        </div>
      </div>
    </footer>
</body>
<!-- Javascripts -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</html>