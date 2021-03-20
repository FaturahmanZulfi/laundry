<?php 
  require('laundry/koneksi.php');
  include('laundry/function.php');

  if (ISSET($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $tabel = 'user';
    $field = '*';
    $kondisi = "WHERE username='$username' AND password='$password'";

    $read = read($tabel,$field,$kondisi);
    $res = mysqli_fetch_array($read);
    if($res == null){
      $att = "user tidak terdaftar";
    }else{
      session_start();
      $role = $res['role'];
      $_SESSION['role'] = $res['role'];
      $_SESSION['nama'] = $res['nama'];
      $_SESSION['id'] = $res['id'];
      header("Location:laundry/$role");
    }
  }else{
    $att = "";
  }

 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laundry - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-8 col-md-5">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Laundry!</h1>
                    <p><?= $att ?></p>
                  </div>
                  <form method="POST" class="user">
                    <div class="form-group">
                      <input type="text" name="username" class="form-control form-control-user" id="exampleInputText" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <input type="submit" name="login" value="Login" class="btn btn-primary btn-user btn-block">
                    <hr>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
