<?php
require_once "config.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username username
    if (empty(trim($_POST["username"]))){
        $username_err = "User name can only contain letters, numbers, and underscores.";
    }else{
    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statemnt as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = trim($_POST["username"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) ==1){
                    $username_err = "This username is already taken.";
                }else{
                    $username = trim($_POST["username"]);
                }
            }else{
                echo "Oops! Something went wrong. Pleatse try again later.";
            }
            // Close Statement
            mysqli_stmt_close($stmt);
        }
    }
// Validate password
if (empty(trim($_POST["password"]))){
    $password_err = "Please enter a passowrd.";
} elseif(strlen(trim($_POST["password"])) < 6){
    $password_err = "Password must have atleast 6 characters.";
} else{
    $password = trim ($_POST["password"]);
}
// Validate confirm password
if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = "Please confirm password.";
} else{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
    }
}
// Check input errors before inserting in database 
if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
    // Prepare an insert statemnet
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind Variables to the preared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
        // Set parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        // Attempt to execute the prepared statemnet
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: login.php");
        } else{
            echo "Oops! Something went wrong. Pleatse try again later.";
        }
        // Close statement
        mysqli_stmt_close ($stmt);
    }
}
// Close connection
mysqli_close($link);
;}
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
<div class="position-relative"  style="height:100vh; width:100%">
<div class="position-absolute top-50 start-50 translate-middle wrapper centercontent">
    <h2>Sign UP</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <div class="form-group mt-2">
            <label>Username</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is_invalid': ''; ?>" value="<?php echo $username; ?>">
        </div>
        <div class="form-group mt-2">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
            <div class="form-group mt-2">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
                <div class="form-group mt-2">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>      
</body>
</html>