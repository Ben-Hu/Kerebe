<?php
	session_start();
	if (isset($_SESSION['username'])) {
		include_once "top_navi.php";
		$curruser = $_GET['username'];
	} else {
		include_once "top_navi.php";
	}
	
	if (isset($_POST['save'])) {
		$conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
		$dbconn = pg_connect($conn);
		$oldpw = $_POST['oldpw'];
		$newpw = $_POST['newpw'];
		$pdesc = $_POST['profiledesc'];
		$user = $_SESSION['username'];
		
		$getpw = pg_query($dbconn, "SELECT * FROM users WHERE username='$user' AND password='$oldpw'");
		$rows = pg_num_rows($getpw);
		
		if ($rows == 0) {
		    pg_close($dbconn);
		    echo "<script type='text/javascript'>alert('Incorrect old password. '$oldpw'')</script>";
		    
		} else {
		    $result = pg_query($dbconn, "UPDATE users SET password = '$newpw' where username = '$user'");
		    $result2 = pg_query($dbconn, "UPDATE users SET profile = '$pdesc' where username = '$user'");
		    pg_close($dbconn);

		    echo "<script type='text/javascript'>alert('Successful password change.')</script>";
		    	    
		    // Set session variables to input in the profile page
		    $_SESSION["username"] = "$user";
		    header("Location: http://ec2-52-10-253-249.us-west-2.compute.amazonaws.com/profile.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>SynergySpace</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.min.js"></script>
    <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="http://m-e-conroy.github.io/angular-dialog-service/javascripts/dialogs.min.js" type="text/javascript"></script>

    <style>
        body {
            padding-top: 51px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
		<li><FONT COLOR="FFFFFF">INTERESTS(?)</FONT></li>
		<?php
		$curruser = $_SESSION['username'];
		$conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
		$dbconn = pg_connect($conn);
		$query = "SELECT interest FROM interests WHERE username='$curruser'";
		$result = pg_query($dbconn, $query);

		while ($row = pg_fetch_row($result)) {
			echo "<li>
                	<div id='interests'>
               		 <form method='post'>
                	    <div>
                       		 <input type='text' class='form-control' name='someinterest' value='$row[0]'>
                           </div>
                </form>
                </div> 
		</li>";
	
		}
		
		pg_close($dbconn);
		?>
			
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->


	
    <!-- Page Content -->
    <div class="container">
	 <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
		<?php $curruser = $_SESSION['username'];
		echo "<a href='profile.php? username=$curruser'></a>"; ?>Settings</h2>
            </div>
		
	<!-- user info setting form -->
              	<div id="listing-form">
                <form method="post">
                    <div>
			
                        <input type="text" class="form-control" name="oldpw" placeholder="Old Password">
                        <br />

                        <input type="text" class="form-control" name="newpw" placeholder="New Password">
                        <br />

			<input type="text" class="form-control" name="profiledesc" value="<?php $user = $_SESSION['username'];
					$conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
					$dbconn = pg_connect($conn);
					$query = "SELECT profile FROM users WHERE username='$user'";
					$getdesc = pg_query($dbconn, $query);
					$result = pg_fetch_result($getdesc, 0, 0);
					if (!$result) {
						echo"No Result";
					}
					echo "$result"; ?> ">
                        <br />

			<input type="text" class="form-control" name="newLName" value="<?php $user = $_SESSION['username'];
					$conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
					$dbconn = pg_connect($conn);
					$query = "SELECT firstname FROM users WHERE username='$user'";
					$getfname = pg_query($dbconn, $query);
					$result = pg_fetch_result($getfname, 0, 0);
					if (!$result) {
						echo"No Result";
					}
					echo "$result"; ?> ">
                        <br />

			<input type="text" class="form-control" name="newFName" value= "<?php $user = $_SESSION['username'];
					$conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
					$dbconn = pg_connect($conn);
					$query = "SELECT lastname FROM users WHERE username='$user'";
					$getlname = pg_query($dbconn, $query);
					$result = pg_fetch_result($getlname, 0, 0);
					if (!$result) {
						echo"No Result";
					}
					echo "$result"; ?> ">
                        <br />			

                        <button class="btn btn-primary" name="save" value="save" type="submit">Save</button>

                    </div>
                </form>
                </div>
        <!-- /.row -->

    <div class="container">
	 <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
		<?php $curruser = $_SESSION['username'];
		echo "<a href='profile.php? username=$curruser'></a>"; ?>Interests</h2>
            </div>
		
	<!-- user info setting form -->
              	<div id="listing-form">
                <form method="post">
                    <div>
			<?php
				$curruser = $_SESSION['username'];
				$conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
				$dbconn = pg_connect($conn);
				$query = "SELECT interest FROM interests WHERE username='$curruser'";
				$result = pg_query($dbconn, $query);

				while ($row = pg_fetch_row($result)) {
					echo "<input type='text' class='form-control' name='someinterest' value='$row[0]'>
					</br>";
	
				}
		
				pg_close($dbconn);
			?>

			<div class="input_fields_wrap">
   			<button class="add_field_button">Add Interest</button>
    			</br>
			</br>
			</div>
			</br>
			</br>		

			<button class="btn btn-primary" name="update" value="Update" type="submit">Update Interests</button>
	           </div>
                </form>
                </div>


        <hr>

     <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>
	</div>

    </div>
    <!-- /.container -->
	
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    
    <!-- Toggle the visibility of an object given its id. -->
    <script>
        function toggleVisibility(id) {
            var object = document.getElementById(id);
            if (object.style.visibility == "hidden") {
                object.style.visibility = "visible";
            }
            else {
                object.style.visibility = "hidden";
            }
        }
    </script>
 
    <!-- Add Interest Input -->
    <script>
	$(document).ready(function() {
    	var max_fields      = 10; //maximum input boxes allowed
    	var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    	var add_button      = $(".add_field_button"); //Add button ID
    
    	var x = 1; //initlal text box count
    	$(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(this).parent('div').remove();
            $(wrapper).append('<div><input type="text" class="form-control" name="mytext[]"/><a href="#" class="remove_field">Remove</a></br></br></div>'); //add input box
        }

    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
   
</body>
</html>
