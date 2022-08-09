<?php
  include 'database.php';
  session_start();
 $id=$_SESSION['id'];
 $query=mysqli_query($link,"SELECT * FROM users where id='$id'")or die(mysqli_error());
 $row=mysqli_fetch_array($query);
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
        <script>
function populate(s1,s2,s3){
	var s1 = document.getElementById(s1);
	var s2 = document.getElementById(s2);
    var s3 = document.getElementById(s3);
    //var status = document.getElementById("slct1");
	s2.innerHTML = "";
    s3.innerHTML = "";
	if(s1.value == "Staff"){
		var optionArray = ["Not Applicable|Not Applicable"];
        var optionsArray = ["Not Applicable|Not Applicable"];
        //document.getElementById("m_no").style.visibility="hidden";
	} else if(s1.value == "Student"){
		var optionArray = ["|Course","SKE|Sijil Teknologi Elektrik (SKE)","STM|Sijil Teknologi Maklumat (STM)","STS|Sijil Teknologi Senibina (STS)","DTS|Diploma Teknologi Solar Fotovoltan (DTS)"];
        var optionsArray = ["|Semester","1|1", "2|2", "3|3", "4|4", "5|5", "6|6"];
        //document.getElementById("m_no").style.visibility="visible";
	}
	for(var option in optionArray){
		var pair = optionArray[option].split("|");
		var newOption = document.createElement("option");
		newOption.value = pair[0];
		newOption.innerHTML = pair[1];
		s2.options.add(newOption);
	}
    for(var option in optionsArray){
		var pair = optionsArray[option].split("|");
		var newOption = document.createElement("option");
		newOption.value = pair[0];
		newOption.innerHTML = pair[1];
		s3.options.add(newOption);
	}
}
</script>
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
            <div id="layoutSidenav_content" align="center">
                <main align="center">
                    <div class="container-fluid px-4" align="center"><br>
                        <div class="row" align="center">
                            <div class="col-xl-5 col-md-10" align="center">
                            <form action="profile_update.php" method="post">
                                <div class="card bg-light text-black mb-4" align="center">
                                <table align="center">
                                    <br>
                                    <tr style="text-align: left">
                                        <th>Name:</th>
                                        <td>
                                            <input type = "text" id = "name" name = "name" class="col-md-10" value="<?php echo $row['name']; ?>"> 
                                        </td>
                                    </tr>

                                    <tr style="text-align: left">
                                        <th>IC Number:</th>
                                        <td>
                                            <input type="text" name="ic" placeholder="eg: 990104-07-5555" class="col-md-10" value="<?php echo $row['ic']; ?>">
                                        </td>
                                    </tr>

                                    <tr style="text-align: left">
                                        <th>Category:</th>
                                        <td>
                                            <select id="slct1" name="slct1" onchange="populate(this.id, 'slct2', 'slct3')" class="col-md-10">
                                                <option value=""><?php echo $row['category']; ?></option>
                                                <option value="Staff">Staff</option>
                                                <option value="Student">Student</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr style="text-align: left">
                                        <th>Course:</th>
                                        <td>
                                            <select id="slct2" name="slct2" class="col-md-10">
                                                <option value="" type="course"><?php echo $row['course']; ?></option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr style="text-align: left">
                                        <th>Semester:</th>
                                        <td>
                                            <select id="slct3" name="slct3" class="col-md-10">
                                                <option value=""><?php echo $row['semester']; ?></option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>

                                <br>
                                <div class="form-group">
                                    <input type="submit" name="edit" class="btn btn-primary" value="Update">
                                </div><br>
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