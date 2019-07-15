<?php
session_start();
if(isset($_SESSION['username'])) {
	
	include_once 'scripts.php';
	include_once 'post.php';
	include_once 'entry_form.php';

}
else{
	include_once 'scripts.php';
	?>
	<div class="alert alert-danger alert-dismissible wow fadeIn animated a2" role="alert">
		<strong>Warning!</strong> Something went wrong!
	</div>
	<?php
			
}
?>