<?php
include 'database.php';
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$id=$_SESSION['ic'];

$query=mysqli_query($link,"SELECT name,masuk FROM checkin where ic='$id' ORDER BY id DESC LIMIT 1")or die(mysqli_error());
$query1=mysqli_query($link,"SELECT keluar FROM checkout where ic='$id' ORDER BY id DESC LIMIT 1")or die(mysqli_error());
$query2=mysqli_query($link,"SELECT name FROM users where ic='$id'")or die(mysqli_error());
$row=mysqli_fetch_array($query);
$rows=mysqli_fetch_array($query1);
$row2=mysqli_fetch_array($query2);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PERPUSTAKAAN KOLEJ KOMUNITI SEGAMAT 2</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="home.php"></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                
            </form> 
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-sign-out fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Home
                            </a>
                            <a class="nav-link" href="profiles.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Profile
                            </a>
                            <a class="nav-link" href="history.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                                History
                            </a>
                        
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main align="center">
                    <div class="container-fluid px-4" align="center">
                        <h1 class="mt-4">
                      
                        </h1>
                        
                        <div class="row" align="center">
                            <div class="col-xl-3 col-md-6">
                            <form action="checkin.php" method="post">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Hi <?php echo $row2['name']?><br><br>
                                    <p><b>You have successfully: </b></p>
                                    <tr id="checkin">
                                      <th><b>Check In: </b></th>
                                      <td>
                                        <?php 
                                          if ($row == 0)
                                          {
                                            echo '--------';
                                          }
                                          else
                                          {
                                            echo $row['masuk'];
                                          }
                                        ?>
                                      </td>
                                    </tr>
                                    </div>
                                    <div class="form-group" align="center">
                                      <input type="submit" name="checkin" class="btn btn-dark" value="Check In"></div><br>
                                </div>
                                        </form>
                                </div>
                            <div class="col-xl-3 col-md-6">
                              <form action="checkin.php" method="post">
                                <div class="card bg-success text-white mb-4">
                                <div class="card-body">Thank you <?php echo $row2['name']?><br><br>
                                    <p><b>You have successfully: </b></p>
                                    <tr id="checkin">
                                      <th><b>Check Out: </b></th>
                                      <td>
                                        <?php 
                                          if ($rows == 0)
                                          {
                                            echo '--------';
                                          }
                                          else
                                          {
                                            echo $rows['keluar'];
                                          }
                                        ?>
                                      </td>
                                    </tr>
                                    </div>
                                    <div class="form-group" align="center">
                                      <input type="submit" name="checkout" class="btn btn-dark" value="Check Out"></div><br>
                                    </div>
                                      </form>
                            </div>
                            
                        </div>
                    </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>