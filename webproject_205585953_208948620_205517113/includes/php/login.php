<!DOCTYPE html>

<?php
    // Include DB config file
    require_once "db_credentials.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);   
        
        if (empty($email) || empty($password)) {
            $err = "עלייך להכניס אימייל וסיסמא.";
        }
        else {
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = $connection->query($query);
    
            if ($result->num_rows > 0)
            {
                //if email exist, verify password
                $row = $result->fetch_assoc();
                $encrypted_password = $row["password"];
    
                if (password_verify($password, $encrypted_password))
                {
                    $userId = $row["id"];
                    $name = $row["name"];
                    $last_name = $row["last_name"];
                    
                    // Password is correct, so start a new session
                    session_start();
    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["user_id"] = $userId;
                    $_SESSION["name"] = $name;
                    $_SESSION["last_name"] = $last_name;
                    
                    echo "<script>
                                sessionStorage.setItem('user-id', '$userId');
                                sessionStorage.setItem('name', '$name');
                                sessionStorage.setItem('last_name', '$last_name');
                                window.location.href='/index.html';
                             </script>";
                }
                else
                {
                    // Display an error message if password is not valid
                    $err = "שם המשתמש או הסיסמא אינם נכונים";
                }
    
            }
            else
            {
                // Display an error message if email doesn't exist
                $err = "שם המשתמש או הסיסמא אינם נכונים";
            }
        }
    }
?>

<html dir="rtl" lang="he-IL">
    <head>
        <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>Login</title>
    	<link rel="stylesheet" type="text/css" href="../../css/signInNew.css">
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   




</head>

<body >
  
 
  
        <div class="form-container sign-in-container">
 
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1>Sign In</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="social"><i class="fa fa-google"></i></a>
                    <a href="#" class="social"><i class="fa fa-instagram"></i></a>
                </div>
                <span>or use your account</span>
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <a href="#">Forgot Your Password</a>
            
                <button>Sign In</button>
                <span class="help-block" style="color: red; font-weight: 700; font-size:18px;"><?php echo $err; ?></span>
            </form>
        </div>
    </body>
</html>