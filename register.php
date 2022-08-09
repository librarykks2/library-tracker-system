<?php
// Include config file
require_once "database.php";
 
// Define variables and initialize with empty values

$name = $ic = $category = $course = $semester = $password = $confirm_password = "";
$name_err = $ic_err = $category_err = $course_err = $semester_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty($_POST["name"])){
        $name_err = "Please enter your name.";
    }elseif(!preg_match ("/^[a-zA-z]*$/", $name) ) { 
        $name_err = "Only alphabets and whitespace are allowed.";
    }else{
        $name = ($_POST["name"]);
    }

    //validate IC
    if(empty($_POST["ic"])){
        $ic_err = "Please enter your IC number.";
    } elseif(!preg_match('/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/', ($_POST["ic"]))){
        $ic_err = "Plese enter the correct format";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE ic = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_ic);
            
            // Set parameters
            $param_ic = ($_POST["ic"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $ic_err = "This IC number is already exist.";
                } else{
                    $ic = ($_POST["ic"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    //validate category
    if(isset($_REQUEST['slct1']) == '0') { 
        $category_err = "Please select the category";
    }else{
        $category = ($_POST["slct1"]);
    } 

    //validate course
    if(isset($_REQUEST['slct2']) == '0') { 
        $course_err = "Please select the course";
    }else{
        $course = ($_POST["slct2"]);
    } 

    //validate sem
    if(isset($_REQUEST['slct3']) == '0') { 
        $semester_err = "Please select the semester";
    }else{
        $semester = ($_POST["slct3"]);
    } 
      
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($ic_err) && empty($category_err) && empty($course_err) && empty($semester_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (name, ic, category, course, semester, password) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_ic, $param_category, $param_course, $param_semester, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_ic = $ic;
            $param_category = $category;
            $param_course = $course;
            $param_semester = $semester;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
           // document.getElementById("m_no").style.visibility="hidden";
	    } else if(s1.value == "Student"){
		    var optionArray = ["|Course","SKE|Sijil Teknologi Elektrik (SKE)","STM|Sijil Teknologi Maklumat (STM)","STS|Sijil Teknologi Maklumat (STM)","DTS|Diploma Teknologi Solar Fotovoltan (DTS)"];
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
<style>
    body{
        background-image: url('assets/img/846241.jpg');
        opacity: 0.9;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .title{
        margin-top: 40px;
        text-align: center;
        color: #000080;
        font-size: 20px;
    }

    .sub{
        font-size: 25px;
    }

    .container{
        width: 650px;
        height: 700px;
        margin: 40px auto;
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
        font-size: 15spx;
    }

    input[type="text"]{
      width: 200px;
      height: 25px;
    }

    input[type="password"]{
      width: 200px;
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

        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <div class="form-group">
                <tr>
                <th><b>Name:</b></th>
                <td>
                    <input type="text" name="name" placeholder="Please insert your name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                    <span style="font-size:12px" class="invalid-feedback"><b><?php echo $name_err; ?></b></span>
                </td>
                </tr>
            </div>  
            <div class="form-group">
                <tr>
                <th><b>IC Number:</b></th>
                <td>
                    <input type="text" name="ic" placeholder="eg: 990104-07-5555" class="form-control <?php echo (!empty($ic_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ic; ?>">
                    <span style="font-size:12px" class="invalid-feedback"><b><?php echo $ic_err; ?></b></span>
                </td>
                </tr>
            </div>
            <div class="form-group">
                <tr>
                <th><b>Category:</b></th>
                <td>
                    <select id="slct1" name="slct1" onchange="populate(this.id, 'slct2', 'slct3')" class="col-md-10">
                        <option value="">Category</option>
                        <option value="Staff">Staff</option>
                        <option value="Student">Student</option>
                    </select>
                </td>
                </tr>
            </div>
            <div class="form-group">
                <tr>
                <th><b>Course:</b></th>
                <td>
                    <select id="slct2" name="slct2" class="col-md-10">
                        <option value="" type="course">Course</option>
                    </select>
                </td>
                </tr>
            </div>
            <div class="form-group">
                <tr>
                <th><b>Semester:</b></th>
                <td>
                    <select id="slct3" name="slct3" class="col-md-10">
                        <option value="">Semester</option>
                    </select>
                </td>
                </tr>
            </div>
            <div class="form-group">
                <tr>
                <th><b>Password:</b></th>
                <td>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span style="font-size:12px" class="invalid-feedback"><b><?php echo $password_err; ?></b></span>
                </td>
                </tr>
            </div>
            <div class="form-group">
                <tr>
                <th><b>Confirm Password:</b></th>
                <td>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span style="font-size:12px" class="invalid-feedback"><b><?php echo $confirm_password_err; ?></b></span>
                </td>
                </tr>
            </div>
            </table>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
</form>
    </div>    
</body>
</html>