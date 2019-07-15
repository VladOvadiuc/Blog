<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <?php include_once 'scripts.php'?>
</head>
<body>
	<?php include_once 'login.php'?>
	
	
<div class="wrapper">
	<div class="container">
		<div class="row">
			
			<div class="container-fluid" id="work-container">
	    		<div class="row ">
		    		<div class="col-lg-3 col-sm-12 wow fadeIn animated text-center">
							<i class="far fa-user"></i>		    		
					</div>
					<div class="col-lg-9 col-sm-12 text-lg-left text-center" >
					      <h2 class=" wow fadeIn animated a1">ACCOUNT LOGIN</h2>
					</div>
	    			
	    		</div>
	    		
				  
				<form class="container" action="index.php" method="post">
					<?php
					if(isset($_SESSION['logout'])){
						if($_SESSION['logout']==true){
							?>
								<div class="alert alert-warning alert-dismissible wow fadeIn animated a2" role="alert">
			  						<strong>Success!</strong> You logged out!
								</div>
						<?php }
						unset($_SESSION['logout']);
						}


					if(isset($_SESSION['login'])){
						if($_SESSION['login']==false){
							?>
								<div class="alert alert-danger alert-dismissible wow fadeIn animated a2" role="alert">
			  						<strong>Warning!</strong> Something went wrong!
								</div>
						<?php }}
					?>
					<div class="row">
						<div class="col-lg-3 col-sm-12 text-center">
							<label class="wow fadeIn animated a2"  id="parola" for="username">Username:</label>
						</div>
						<div class="col-lg-9 col-sm-12 text-center">
							
							<input class="wow fadeIn animated a2" id="parola" type="text" name="username" />
						</div>
						
					</div>

					<div class="row">
						<div class="col-lg-3 col-sm-12 text-center">
							<label class="wow fadeIn animated a4" id="parola" for="password">Password:</label>
						</div>
						<div class="col-lg-9 col-sm-12 text-center">
							<input class="wow fadeIn animated a4" id="parola" type="password" name="password" />
						</div>
						
					</div>
					<div class="row">
						<div class="col-sm-12 text-center" id="parola">
							<input class="wow fadeIn animated a6" type="submit" value="Login" />
						</div>
					</div>
				</form>
					      
			</div>
		</div>
	</div>
</div>

</body>
</html>
