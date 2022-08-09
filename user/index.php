<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}
 
// Include config file
require_once "database.php";
 
// Define variables and initialize with empty values
$ic = $password = "";
$ic_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["ic"]))){
        $ic_err = "Please enter IC number.";
    } else{
        $ic = trim($_POST["ic"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($ic_err) && empty($ic_err)){
        // Prepare a select statement
        $sql = "SELECT id, ic, password FROM users WHERE ic = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_ic);
            
            // Set parameters
            $param_ic = $ic;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $ic, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["ic"] = $ic;                            
                            
                            // Redirect user to welcome page
                            header("location: home.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid IC number or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid IC number or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
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
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
    <style>
        body{
        background-image: url('assets/img/846241.jpg');
        opacity: 0.9;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .title{
        margin-top: 60px;
        text-align: center;
        color: #000080;
        font-size: 20px;
    }

    .sub{
        font-size: 25px;
    }

    .container{
        width: 600px;
        height: 500px;
        margin: 60px auto;
        background: rgb(173, 216, 230);
        opacity: 0.95;
        border-radius: 15px;
        text-align: center;
    }

    .container img{
        width: 180px;
        height: 120px;
        margin-top: 5px;
        margin-bottom: 30px;
    }

    .cust{
        position: absolute;
        background: #fff;
        margin-right: 18px;
        margin-top: 1px;
        width: 44px;
        height: 36px;
        padding-top: 8px;
    }

    th{
        text-align: left;
        padding: 10px 80px;
        font-size: 18px;
    }

    td{
        text-align: left;
        padding: 0px 30px;
        font-size: 20px;
    }

    input[type="text"]{
      width: 180px;
      height: 25px;
    }

    input[type="password"]{
      width: 180px;
      height: 25px;
    }
    </style>
</head>

<body>
<!-- Header -->
<header class="title">
        <h1>PERPUSTAKAAN KOLEJ KOMUNITI SEGAMAT 2</h1>
    </header>

    <div class="container">
        <img src="assets/img/kks.png" alt="Avatar">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p><br>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <div class="form-group">
                <tr>
                <th><b>IC Number:</b></th>
                <td>
                    <input type="text" name="ic" placeholder="eg: 990104-07-5555" class="form-control <?php echo (!empty($ic_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ic; ?>">
                    <span style="font-size:12px"  class="invalid-feedback"><b><?php echo $ic_err; ?></b></span>
                </td>
                </tr>
            </div>    
            <div class="form-group">
                <tr>
                <th><b>Password:</b></th>
                <td>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span style="font-size:12px" class="invalid-feedback"><b><?php echo $password_err; ?></b></span>
                </td>
                </tr>
            </div>
    </table>
    <br><br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>