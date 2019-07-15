<!DOCTYPE html>
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type"
	content="text/html;charset=utf-8" />
</head>
<body>
	
<div class="wrapper">
		
	
	<?php include_once 'menu.php';?>

	<div class="container">
		<?php include_once 'welcome-bar.php';?>

		<div class="container-fluid" id="formular">
			<?php
			if($page == 'delete' || $page == 'deletePhoto')
			{
				echo $confirm;
			}
			


			else{
				if(isset($_SESSION['eroare'])&&$_SESSION['eroare']==TRUE){
				?>
				<div class="alert alert-danger alert-dismissible wow fadeIn animated a2" role="alert">
					  		<strong>Warning!</strong> Your file is not an image!
						</div>
				<?php
				$_SESSION['eroare']=FALSE;
			}
			?>
			
			<div class="row">
				<div class="col-sm-12 text-center wow fadeIn animated a2">
				<h2> <?php echo $legend ?></h2>
				</div>
			</div>
			<form id="contact-form" name="contact-form" method="post" action="entry.php"
				enctype="multipart/form-data">
		         <div class="row">
		             <div class="col-md-12 wow fadeIn animated a2">
		                 <div class="md-form mb-0">
		                     <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlentities($title) ?>" >
		                     <label for="title" >Title</label>
		                 </div>
		             </div>
		         </div>
		         <div class="row">
		             <div class="col-md-12 wow fadeIn animated a2">
		                 <div class="md-form mb-0">
		                    <input type="file" name="image" id="image"/><br>
							<label for="image">Image</label>
		                </div>
		             </div>
		         </div>
		         <div class="row">
		             <div class="col-md-12 wow fadeIn animated a2">

		                 <div class="md-form">
		                     <textarea type="text" id="entry" name="entry" rows="3" class="form-control md-textarea"  data-error="Please enter your post."><?php echo sanitizeData($entry) ?></textarea>
		                     <label for="entry">Your post</label>
		                 </div>

		             </div>
		         </div>
		         <input type="hidden" name="id" value="<?php echo $id ?>" />
		         <input type="hidden" name="page" value="<?php echo $page ?>" />
		         <div class="row">
		         	<div class="col-md-6 wow fadeIn animated a2">
		         		<input type="submit" name="submit" value="Save Entry" />
		         	</div>

		         	<div class="col-md-6 text-right wow fadeIn animated a2">
		         		<input type="submit" name="submit" value="Cancel" />
		         	</div>
		         	
		         </div>
			</form>
		<?php }  ?>
		</div>
				</div>
		</div>
	</div>
</div>
</div>
	</body>
	</html>