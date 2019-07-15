<?php
session_start();
if(isset($_SESSION['username'])) {
?>

	<?php include_once 'scripts.php';
	
		if(isset($_SESSION['login'])){
					if($_SESSION['login']==true){
						?>
							<div class="alert alert-success alert-dismissible wow fadeIn animated a2" role="alert">
							<strong>Success!</strong> You have logged in!!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    		<span aria-hidden="true">&times;</span>
					  		</button>
						</div>
					<?php }
					unset($_SESSION['login']);
					}
		?>
		
	<div class="wrapper">
		<?php include_once 'menu.php';?>
		<div class="container">
			<?php include_once 'welcome-bar.php';
			include_once 'db.php';
			include_once 'functions.php';
			$db=new mysqli(DB_INFO, DB_USER, DB_PASS,DB_NAME);
			if(!$db) {
				die('Connection failed: ' . $mysqli->error());
			}
			//verificat daca id-ul exista in baza de date, problema la introdus manual url-ul
			if(isset($_GET['page'])){
				$page = htmlentities(strip_tags($_GET['page']));
				}
			else{
				$page = NULL;
			}
			$url = (isset($_GET['url'])) ? $_GET['url'] : NULL;
			if(!url_exist($db,$url)){
				?>
				<div class="spacing"></div>
				<div class="alert alert-danger alert-dismissible wow fadeIn animated a2" role="alert">
			  		<strong>Warning!</strong> Something went wrong!
				</div>
				<?php
			}
			else{
			
			$e = retrieveEntries($db,$page, $url);
			$fulldisp = array_pop($e);
			$e = sanitizeData($e);
			
			?>
			<div class="spacing"></div>
			
					<?php
					if($fulldisp==1)
					{
						$url = (isset($url)) ? $url : $e['url'];
						$admin = adminLinks($page, $url);
						if($e['image']!= NULL){
							$img = formatImage($e['image'], $e['title']);
						}
						else{
							$img = NULL;
						}
						
						?>
						<div class="container-fluid" id="welcome-container">
							<div class="row">
								<div class="col-sm-3 text-left wow fadeIn animated a4">
									<h4>Title:</h4>
									<?php
									$posts = retrieveEntries($db);
									$fulldisp = array_pop($posts);
									$posts = sanitizeData($posts);

									foreach($posts as $entry) {
										if($e['url']==$entry['url']){
										?>

										<p>
										<a href="/hello/<?php echo $entry['page']?>/<?php echo $entry['url']?>" style="color: black;">
										<mark><?php echo $entry['title'] ?></mark></a></p>
										<hr> 
									<?php }
									else{
										?>

										<p>
										<a href="/hello/<?php echo $entry['page']?>/<?php echo $entry['url']?>" style="color: black;">
										<?php echo $entry['title'] ?></a></p>
										<hr> 
									<?php

									} }
									?>
								</div>
								<div class=" col-sm-9 text-sm-left wow fadeIn animated a4 text-left" >
									<h2> <?php echo $e['title'] ?> </h2>
									<p> <?php echo $e['page'] ?> </p>
									<p> <?php echo $e['created'] ?> </p>
									<p> <?php echo $e['entry'] ?> </p>
									<p > <?php echo $img ?> </p>
								
								
							<div class="row" >
					         	<div class="col-md-4 wow fadeIn animated a2" id="rand-buton1">
					         		<a href="<?php echo $admin['edit']; ?>">
					         			<input type="submit" name="submit" value="Update" />
					         		</a>
					         		
					         	</div>
					         	
					         	<?php if($img!=NULL) {
					         		?>
					         	<div class="col-md-4 text-right wow fadeIn animated a2" id="rand-buton2">
					         		<a href="<?php echo $admin['deletePhoto']; ?>">
					         			<input type="submit" name="submit" value="Delete Photo" />
					         		</a>
					         	</div>
					         	<?php }if($page=="blog") {
					         		?>
					         	<div class="col-md-4 text-right wow fadeIn animated a2" id="rand-buton3">
					         		<a href="<?php echo $admin['delete']; ?>">
					         			<input type="submit" name="submit" value="Delete" />
					         		</a>
					         	</div>
					         <?php } ?>
				         	</div>
				         	
				         </div>
				     </div>
				         	<div class="spacing">
				         	</div>
		         	
		         </div>
						</div>
					<?php
				}
				else
				{
					?>
					<div class="container-fluid" id="welcome-container">
					
						<div class="row">
							<div class="col-sm-4  wow fadeIn animated a2">
								<h4>Title:</h4>
								<?php
									foreach($e as $entry) {
									?>
									<p>
									<a href="/hello/<?php echo $entry['page']?>/<?php echo $entry['url']?>" style="color: black;">
									<?php echo $entry['title']; ?></a></p>
									<hr> 
									<?php } ?>
								
							</div>
							<div class="col-sm-4  wow fadeIn animated a2">
								<h4>Page:</h4>
								<?php
									foreach($e as $entry) {
									?>

									<p>
									<a href="hello/<?php echo $entry['page']?>" style="color: black;">
									<?php echo $entry['page']?></a></p>
									
									<hr> 
									<?php } ?>
								
							</div>
							<div class="col-sm-4  wow fadeIn animated a2">
								<h4>Date:</h4>
								<?php
									foreach($e as $entry) {
									?>
									<p> <?php echo $entry['created']?></p>
									<hr> 
								<?php }?>
									
							</div>
						</div>
						
					</div>
				<?php }
				?> 
			</div>
	</div>
</div>

<?php
	
}
}

else{
	echo 'Something went wrong';
			
	}
?>