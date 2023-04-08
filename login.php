<?php
//connexion avec le serveur (APACHE)
  $username = "root";
  $password = "";
  $hostname = "localhost";
  // activer le rapport d'erreur
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  
// connection string with database
$dbhandle = mysqli_connect($hostname, $username, $password);
// connect with table
$selected = mysqli_select_db($dbhandle, "isikef");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si le email d'utilisateur et le password sont définis
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Escape special characters in username and password to prevent SQL injection attacks
        $username = mysqli_real_escape_string($dbhandle, $_POST['email']);
        $password = mysqli_real_escape_string($dbhandle, $_POST['password']);

        // Query the database to check if the user exists
        $sql = "SELECT * FROM user WHERE email='$username' AND password='$password'";
        $result = mysqli_query($dbhandle, $sql);

        // If the query returns one row, then the user exists and we can start a session
        if (mysqli_num_rows($result) == 1) {
            session_start();
            $_SESSION['email'] = $username;
            $_SESSION['password'] = $password; 
            header('Location: espace_etudiant.php');
            exit;
        } else {
            // If the query returns zero rows, then the user doesn't exist or the password is wrong
            echo "Invalid username or password.";
        }
    }
}

$dbhandle->close();

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
		<div class="login-form">
			<div class="sign-in-htm">
				<div class="group">
                <form name="connexion"  method="post" onsubmit="return test()">
					<label for="user" class="label">Email    </label>
					<input id="user" type="email" class="input"  name="email" placeholder="SVP entrez votre email ! !">
				</div>
				<div class="group">
					<label for="password" class="label">Password</label>
					<input id="password" type="password" class="input" data-type="password"  name="password" placeholder="SVP entrez votre mot de passe ! !">
				</div>
                 </form>
				<div class="group">
					<input id="check" type="checkbox" class="check" checked>
					<label for="check"><span class="icon"></span> Keep me Signed in</label>
				</div>
				<div class="group">
					<input type="submit" class="button" value="Sign In">
				</div>
				<div class="hr"></div>
				<div class="foot-lnk">
					<a href="#forgot">Forgot Password?</a>
				</div>
			</div>
			<div class="sign-up-htm">
				<div class="group">
					<label for="user" class="label">Username</label>
					<input id="user" type="text" class="input">
				</div>
				<div class="group">
					<label for="pass" class="label">Password</label>
					<input id="pass" type="password" class="input" data-type="password">
				</div>
				<div class="group">
					<label for="pass" class="label">Repeat Password</label>
					<input id="pass" type="password" class="input" data-type="password">
				</div>
				<div class="group">
					<label for="pass" class="label">Email Address</label>
					<input id="pass" type="text" class="input">
				</div>
				<div class="group">
					<input type="submit" class="button" value="Sign Up">
				</div>
				<div class="hr"></div>
				<div class="foot-lnk">
					<label for="tab-1">Already Member?</a>
				</div>
			</div>
		</div>
	</div>
</div>
    <script>
        function test() {
            var login = connexion.email.value;
            var pwd = connexion.password.value;
            var a = "@";
            

            if (login.length === 0 || pwd.length === 0) {
                alert("Vérifier votre login et votre de mot de passe");
                return false;
            }
            else {
                if (pwd.length < 8 || pwd.length > 8) {
                    alert("Votre mot de passe doit avoir une longueur égale à 8 caractères");
                    return false;
                }

                if (login.substring(login.indexOf(a)) != '@isikef.u-jendouba.tn') {
                    alert("Votre de mot de passe doit avoir une adresse universitaire");
                    return false;
                } 
            }
        }
    </script>

</body>
</html>
