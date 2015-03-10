<?php
	session_start(); // Start the user session
	include "database.php"; 
	include "head.php"; // Stylesheets and scripts
	include "top_navi.php"; // Top navigation bar
	include_once "main_sidebar.php"; // Main side bar when logged in or not
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
	<title>SynergySpace</title>

</head>

<body>
	<!-- Page content (listings) -->
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="row carousel-holder">
					<div class="col-md-12">
					
						<!-- The carousel for three recently added listings (images scroll). -->
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
								<li data-target="#carousel-example-generic" data-slide-to="1"></li>
								<li data-target="#carousel-example-generic" data-slide-to="2"></li>
							</ol>
							
							<!-- Images to scroll through for the three recently addded listings. -->
							<div class="carousel-inner">
								<div class="item active">
									<a href="listing.php">
										<img class="slide-image" src="http://placehold.it/800x300" alt="">
									</a>
                                				</div>
								<div class="item">
									<a href="listing.php">
										<img class="slide-image" src="http://placehold.it/800x300" alt="">
									</a>
                                				</div>
								<div class="item">
									<a href="listing.php">
										<img class="slide-image" src="http://placehold.it/800x300" alt="">
									</a>
                                				</div>
							</div>
							
							<!-- Arrows to click for scrolling through the three recently added listings. -->
							<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</a>
                            				<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                				<span class="glyphicon glyphicon-chevron-right"></span>
                            				</a>
						</div>
					</div>
				</div>
				
				<!-- The six smaller thumbnails for the most popular listings. -->
				<div class="row">
					<?php
						$query = "SELECT * from listings ORDER BY rating DESC LIMIT 6";
						$result = querydb($query);
						// Get each row from the result and show the top six highest rated listings
						while ($row = pg_fetch_row($result)) {
						echo 
						"
						<div class='col-sm-4 col-lg-4 col-md-4'>
							<div class='thumbnail'>
								<a href='listing.php?id=$row[0]'>
									<img src='http://placehold.it/320x150'>
								</a>
								<div class='caption'>
								
									<!-- Rating -->
									<h4 class='pull-right'>$row[3]</h4>
									<!-- Address -->
									<h4><a href='listing.php?id=$row[0]'>$row[1]</a></h4>
									<!-- City -->
									<p>$row[2]</p>
								</div>
							
								<div class='ratings'>
									<p class='pull-right'></p>
									<p><span></span></p>
								</div>
							</div>
						</div>
						";
						}
					?>

                </div> <!-- /.row -->
			</div> <!-- /.col-md-9 -->
        </div> <!-- /.row -->
	</div> <!-- /.container -->
	
</body>
</html>