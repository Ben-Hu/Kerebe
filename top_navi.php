<?php
	// Function for user registration
	if (isset($_POST['register'])) {
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$first = $_POST['firstname'];
		$last = $_POST['lastname'];
		$result = querydb("INSERT INTO users VALUES('$user', '$pass', '$first', '$last')");
		if (!$result) { // If the username is already taken
			echo "<script> alert('Your username is already taken. Unsuccessful registration.') </script>";
		}
	}

	// Function for login
	if (isset($_POST['login'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		// Query the database to see if there is a combination that matches the
		// user input.
		$query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
		$result = querydb($query);
		$numrows = pg_num_rows($result);

		if ($numrows == 0) {
			echo "<script>alert('Incorrect username/password combination.')</script>";
		} else {
			// Start a new user session and set the username
			session_start();
			$_SESSION["username"] = $user;
			// Close the session temporarily after writing to it.
			session_write_close(); 
		}
	}

	// If the user clicks the "Logout" link, destroy the logged in user session
	if (isset($_GET['logout'])) {
		session_unset(); // Unset $_SESSION['username']
		session_destroy();
	}
?>

<!-- Top navigation bar when a user is logged in. -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
			<!-- Button to open and close sidebar. -->
			<a class="navbar-brand" href="#menu-toggle" id="menu-toggle">&#60;</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="index.php">Synergy Space</a></li>
				<?php
					// If the user is logged in, display user features on the top bar.
					if(isset($_SESSION['username'])) {
						$user = $_SESSION['username'];
						echo "
							<li><a href='profile.php?user=$user'>Profile</a></li>
							<li><a href='mailbox.php'>Messages</a></li>
							<li><a href='settings.php'>Settings</a></li> 
							<li><a href='index.php?logout'>Logout</a></li>
						";
					} else { // If the user is not logged in, only show the user button.
						echo "<li><a href='#' data-toggle='modal' data-target='#login'>Login/Register</a></li>";
					}
				?>
			</ul>
		</div>
	</div> <!-- /.container -->
</nav>
    
<!-- Login form -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!-- Close button -->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title">Login/Register</h4>
			</div>
			<div class="modal-body">
				<form method="post">
					<div>
						<input type="text" class="form-control" name="user" maxlength="25" placeholder="Username">
						<br />
						<input type="password" class="form-control" name="pass" maxlength="25" placeholder="Password">
						<br />
						<button class="btn btn-primary" name="login" value="login" type="submit">Login</button>
                    </div>
				</form>
			</div>
			
			<!-- Register button -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#register">Register</button>
			</div>
		</div>
	</div>
</div>

<!-- Registration form -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
				<h4 class="modal-title">Register</h4>
			</div>
			<div class="modal-body">
				<form method="post">
					<div>
						<input type="text" class="form-control" name="username" maxlength="25" placeholder="Username" required>
						<br />
						<input type="password" class="form-control" name="password" maxlength="25" placeholder="Password" required>
						<br />
						<input type="text" class="form-control" name="firstname" maxlength="20" placeholder="First name" required>
						<br />
						<input type="text" class="form-control" name="lastname" maxlength="20" placeholder="Last name" required>
						<br />
						<button class="btn btn-primary" name="register" value="register" type="submit">Register</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="wrapper">