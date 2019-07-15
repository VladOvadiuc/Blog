<div class="container-fluid" id="welcome-container">
	<div class="row">
		<div class=" col-md-2 col-sm-12 text-sm-left wow fadeIn animated a4 text-left">
	    	<i class="fas fa-bars " id="sidebarCollapse" data-toggle="tooltip" data-placement="top" title="Menu"></i>
		</div>
		
		<div class="col-md-8 col-sm-12 text-sm-center wow fadeIn animated a2" id="welcome">
			<h4>Welcome, <?php echo $_SESSION['username']; ?></h4>
		</div>
		<div class="col-md-2 col-sm-12 text-sm-right wow fadeIn animated a4 text-right">
			<a href="logout.php"> 
				<i class="fas fa-sign-out-alt " data-toggle="tooltip" data-placement="top" title="Logout"></i>
			</a>
		</div>
	</div>
</div>