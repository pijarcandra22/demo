<?php
// Initialize the session session_start();

// Check if the user is already logged in, if yes then direct him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    header("location:welcome.php");
    exit;
}

// Include config file
require_once "config.php"; 

// Define variables and ininiti alize with empty values 
$username = $password = ""; 
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted 
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    echo "hai";
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, `password` FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement  as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = trim($_POST["username"]);
            if(mysqli_stmt_execute($stmt)){
                // Store Result
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // BInd result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $SESSION["loggedin"] = true;
                            $SESSION["id"] = $id;
                            $SESSION["username"] = $username;
                            // Redirect user to welcome page
                            header("location:welcome.php");
                        }else {
                            // Username doesn't exist. display a generic error message
                            $login_err = "Invalid username of password.";
                        }
                    }else{
                        // Username doesn't exist. display a generic error message
                        $login_err = "Invalid username of password.";
                    }  
                }else{
                    echo "Oops! Something wwent wrong. Please try again later.";
                }
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        }
        // Close connection
        mysqli_close($link);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        body{font: 14px sans-serif;}
        .wrapper{width:360px; padding:20px}
    </style>
    <link href="style.css" rel="stylesheet">
</head>
<body class="background">
    <div class="position-relative" style="height:100vh; width:100%">
    <div class="position-absolute top-50 start-50 translate-middle wrapper centercontent">
<h2>Login</h2>
<p>Please fill in your credentials to login.</p>
<?php
if (!empty($login_err)){
    echo '<div class="alert-danger">' . $login_err. '</div>';
}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group mt-2">
        <label>Username</label>
        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid': ''; ?>" value="<?php echo $username; ?>">
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
    </div>
        <div class="form-group mt-2">
        <label>Password</label>
        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid': ''; ?>" value="<?php echo $username; ?>">
        <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
        <input type="submit" class="btn btn-primary mt-2" value="Login">
        <P>Don't have an account? <a href="register .php">Sign up now</a>.</P>
        </form>
        </div>
    </div>  
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>      
</body>
</html>