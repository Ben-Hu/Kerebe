<?php
	session_start();
	include_once "top_navi.php";
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
	
	<!-- Custom CSS -->
    <link href="css/round-about.css" rel="stylesheet">
    
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
            <li>
                <a href="#">UNDECIDED?</a>
            </li>
 
        </ul>
    </div>
	
 <!-- Page Content -->
    <div class="container">

        <!-- Threads -->
        <div class="row">
            <div class="col-lg-12">
	    <h2 class="page-header">Mailbox</h2>
            </div>
	    

	    <?php
		$user = $_SESSION['username'];
		$conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
		$dbconn = pg_connect($conn);
		$query = "SELECT friends.username, friends.friend, users.firstname, users.lastname, users.profile FROM friends, users WHERE friends.username='$user' AND users.username=friends.friend";
		$result= pg_query($dbconn, $query);
		
		while ($row =  pg_fetch_row($result)) {
		    echo "<div class='col-lg-4 col-sm-6 text-center'>
			<a href='messages.php'>
			<img class='img-circle img-responsive img-center' src='http://placehold.it/200x200' alt=''></a>
			<h3><a href='profile.php'>$row[1]</a>
			   <small>
			    $row[2] $row[3]
			   </small>
			</h3>
		      <p>$row[4]</p>
		      </div> ";	  
		}
		
		pg_close($dbconn);
	    ?>	   
	    
    
            <div class="col-lg-4 col-sm-6 text-center">
                <a href="messages.php"><img class="img-circle img-responsive img-center" src="http://placehold.it/200x200" alt=""></a>
                <h3><a href="profile.php">John Smith</a>
                    <small>Something</small>
                </h3>
                <p>Not Genned - Hard coded</p>
            </div>
	    
	    
	    
        </div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

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
    
</body>
</html>

