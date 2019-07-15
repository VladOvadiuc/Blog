<?php
include_once 'db.php';
include_once 'functions.php';
include_once 'images.php';
$db=new mysqli(DB_INFO, DB_USER, DB_PASS,DB_NAME);
if(!$db) {
	die('Connection failed: ' . $mysqli->error());
}
if($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['submit']=='Cancel'){
	header("Location: /hello/");
			exit;
}


if($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['submit']=='Save Entry'
&& !empty($_POST['page'])
&& !empty($_POST['title'])
&& !empty($_POST['entry']))
{
	if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='')
	{
		try
		{
			$img = new ImageHandler("/imagini/",array(400, 300));
			$img_path = $img->processUploadedImage($_FILES['image']);
		}
		catch(Exception $e)
		{
			$_SESSION['eroare']=TRUE;
			header('Location: /entry');
			exit;
		}
	}
	else
	{
		// Avoids a notice if no image was uploaded
		$img_path = NULL;
	}
	

	if(!empty($_POST['id'])){
		$sql1 = "SELECT url,image FROM entries WHERE id=? LIMIT 1";
		if($stmt1 = $db->prepare($sql1))
		{
			$stmt1->bind_param('i', $_POST['id']);
			$stmt1->execute();
			$stmt1->bind_result($url1,$img1);
			if( $stmt1->fetch()){
				$url=$url1;
				if($img_path == NULL){
					$img_path=$img1;
				}
			}
			$stmt1->close();
		}

		$sql = "UPDATE entries SET title=?,image=?, entry=? ,created=NULL WHERE id=? LIMIT 1";
		if($stmt = $db->prepare($sql))
		{
			$_SESSION['postat']=true;
			$stmt->bind_param('sssi', $_POST['title'],$img_path,$_POST['entry'],$_POST['id']);
			$stmt->execute();
		}
		header('Location: /../../hello/'.$_POST['page'].'/'.$url);
			exit;

	}
	else
	{
		$sql1="SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = \"internship\" AND TABLE_NAME = \"entries\"";
		if($stmt1 = $db->prepare($sql1))
		{
			$stmt1->execute();
			$stmt1->bind_result($id);
			if( $stmt1->fetch()){
				$id =  $id;}
			}
			$stmt1->close();

		$sql = "INSERT INTO entries (page,title,image, entry,url) VALUES (?,?, ?, ?,?)";
		if($stmt = $db->prepare($sql))
		{

			////////ia ultimul id introdus, fa url cu titlu+id, apoi peste tot trebuie modificate linkurile pentru a trimite cu adresa din db, nu aia din post sau get
			
    		$url=makeUrl($_POST['title'],$id);
			
			$_SESSION['postat']=true;
			$stmt->bind_param('sssss',$_POST['page'], $_POST['title'],$img_path,$_POST['entry'],$url);
			$stmt->execute();
			header('Location: /../../hello/'.$_POST['page'].'/'.$url);
			exit;
		}
	}

	$stmt->close();
	$db->close();
}
else{
	$page = isset($_GET['page']) ? htmlentities(strip_tags($_GET['page'])) : 'blog';
	if(isset($_GET['url']))
{
	$url = htmlentities(strip_tags($_GET['url']));
	if(url_exist($db,$url)){
		$legend = "Edit The Post";
		$e = retrieveEntries($db, $page, $url);

		$id = $e['id'];
		$title = $e['title'];
		$page1=$e['page'];
		$entry = $e['entry'];
	}
	else
	{
		?>
		<div class="alert alert-danger alert-dismissible wow fadeIn animated a2" role="alert">
		<strong>Warning!</strong> Something went wrong!
		</div>
		<?php
		$legend = "Just post something";
		$id = NULL;
		$title = NULL;
		$entry = NULL;
	}

	if($page == 'delete')
	{
		$confirm = confirmDelete($db, $url);
	}
	if($page == 'deletePhoto')
	{
		$confirm = confirmDeletePhoto($db, $url);
	}
}
else
{
	$legend = "Just post something";
	$id = NULL;
	$title = NULL;
	$entry = NULL;
}

}


$page = isset($_GET['page']) ? htmlentities(strip_tags($_GET['page'])) : 'blog';
if(isset($_POST['action']) && $_POST['action'] == 'delete')
{
	$url = htmlentities(strip_tags($_POST['url']));
	if($_POST['submit'] == 'Yes')
	{
		
		if(deleteEntry($db, $url))
		{
			header("Location: /hello/");
			exit;
		}
		else
		{
			exit("Error deleting the entry!");
		}
	}
	else
	{
	header("Location: /hello/$page/$url");
	exit; }
}
if(isset($_POST['action']) && $_POST['action'] == 'deletePhoto')
{
	$url = htmlentities(strip_tags($_POST['url']));
	if($_POST['submit'] == 'Yes')
	{
		
		if(deletePhoto($db, $url))
		{
			header("Location: /hello/$page/$url");
			exit;
		}
		else
		{
			exit("Error deleting the photo!");
		}
	}
	else
	{
	header("Location: /hello/$page/$url");
	exit; }
}

	
?>