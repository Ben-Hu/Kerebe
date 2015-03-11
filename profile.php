<?php
	session_start();

	include "database.php";
	include "head.php";
	include "top_navi.php";
	
	include_once "profiledatabase.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <title><?php echo "$userInfo[0] - $userInfo[2] $userInfo[3]"; ?></title>

</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
			<!-- Friends list -->
			<?php
				while ($friend = pg_fetch_row($friends)) {
					echo "<li><a href='profile.php?user=$friend[0]'>$friend[0]</a></li>";
				}
			?>
		</ul>
	</div>
	
	<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<!-- Username -->
				<h1><?php echo "$curruser"; ?></h1>
				<hr>
				<!-- Full name -->
				<p><span class="glyphicon glyphicon-user"></span><?php echo " $userInfo[2] $userInfo[3]"; ?></p>
				<hr>
				<img class="img-responsive" src="http://placehold.it/900x300" alt="">
				<hr>
				<!-- Profile description -->
				<p class="lead"><?php echo "$userInfo[5]"; ?></p>
				<hr>
                <!-- Skills/Interests -->
				<div class="well">
					<p>Skills/interests will be inserted here.</p>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->
</body>
</html>