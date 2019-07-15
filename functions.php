<?php
function retrieveEntries($db,$page=NULL, $url=NULL)
{
	$e = NULL;
	if(isset($url))
	{
		$sql = "SELECT id,page,title,image, entry,created FROM entries WHERE url=? LIMIT 1";
		if($stmt = $db->prepare($sql))
		{
			$stmt->bind_param('s', $url);
			$stmt->execute();
			$stmt->bind_result($id, $page, $title,$image, $entry, $created);
			if( $stmt->fetch()){
				$e = array(
					'id' => $id,
					'title' => $title,
					'image' =>$image,
					'page' => $page,
					'entry' => $entry,
					'url' => $url,
					'created'=>$created);
			}
			$fulldisp = 1;
		}
					
	}
	else
	{
		if(isset($page)){
			$sql = "SELECT id,page,url, title,image,created FROM entries WHERE page=? ORDER BY created DESC";
			if($stmt = $db->prepare($sql))
			{
				$stmt->bind_param('s', $page);
				$stmt->execute();
				$stmt->bind_result($id, $page,$url, $title,$image, $created);

				while( $stmt->fetch()){
					$e[] = array(
						'id' => $id,
						'page' => $page,
						'title' => $title,
						'image' =>$image,
						'url' => $url,
						'created' =>$created);
				}
				$fulldisp = 0;
			}
		}
		else{
			$sql = "SELECT id,page,url, title,image,created FROM entries ORDER BY created DESC";
			if($stmt = $db->prepare($sql))
			{
				$stmt->execute();
				$stmt->bind_result($id, $page,$url, $title,$image, $created);

				while( $stmt->fetch()){
					$e[] = array(
						'id' => $id,
						'page' => $page,
						'title' => $title,
						'image' =>$image,
						'url' => $url,
						'created' =>$created);
				}
				$fulldisp = 0;
			}
		}
		
		$fulldisp = 0;
		if(!is_array($e))
		{
			$page=$_GET['page'];
			$fulldisp = 1;
			$e = array(
			'title' => 'No Entries Yet',
			'image' => NULL,
			'page' => 'Inexistent',
			'entry' => '<a href="/entry.php?page=about" style="color:blue">Post an entry!</a>',
			'created'=>'Never created');

			}
	}
	
	array_push($e, $fulldisp);
	return $e;
}

function url_exist($db,$url){
	if(isset($url))
	{
		$sql = "SELECT title FROM entries WHERE url=? LIMIT 1";
		if($stmt = $db->prepare($sql))
		{
			$stmt->bind_param('s', $_GET['url']);
			$stmt->execute();
			$stmt->bind_result($title);
			if( $stmt->fetch()){
				$e = true;
			}
			else{
				$e=false;
			}
			
		}
	}
	else{
		$e=true;
	}
		return $e;
	}



function sanitizeData($data)
{
	if(!is_array($data))
	{
		return strip_tags($data, "<a>");
	}
	else
	{
		return array_map('sanitizeData', $data);
	}
}

function makeUrl($title,$id)
{
	$title.=$id;
	$patterns = array(
		'/\s+/',
		'/(?!-)\W+/'
	);
	$replacements = array('-', '');
	return preg_replace($patterns, $replacements, strtolower($title));
}

function adminLinks($page, $url)
{
	$editURL = "/entry/$page/$url";
	$deleteURL = "/entry/delete/$url";
	$deletePhoto = "/entry/deletePhoto/$url";
	
	$admin['edit'] = "$editURL";
	$admin['delete'] = "$deleteURL";
	$admin['deletePhoto'] = "$deletePhoto";

	return $admin;
}
function confirmDelete($db, $url)
{
$e = retrieveEntries($db, '', $url);
return <<<FORM
	<form action="/entry.php" method="post">
	<legend>Are You Sure?</legend>
	<p>Are you sure you want to delete the entry "$e[title]"?</p>
	<input type="submit" name="submit" value="Yes" />
	<input type="submit" name="submit" value="No" />
	<input type="hidden" name="action" value="delete" />
	<input type="hidden" name="url" value="$url" />
	</form>
FORM;
}

function deleteEntry($db, $url)
{

	$sql = "DELETE FROM entries WHERE url=? LIMIT 1";
	if($stmt = $db->prepare($sql))
		{
			$stmt->bind_param('s', $url);
			$stmt->execute();
			return true;
		}


return false;
}

function confirmDeletePhoto($db, $url)
{
	$e = retrieveEntries($db, '', $url);
	return <<<FORM
		<form action="/entry.php" method="post">
		<legend>Are You Sure?</legend>
		<p>Are you sure you want to delete the photo of "$e[title]"?</p>
		<input type="submit" name="submit" value="Yes" />
		<input type="submit" name="submit" value="No" />
		<input type="hidden" name="action" value="deletePhoto" />
		<input type="hidden" name="url" value="$url" />
		</form>
	FORM;
}
function deletePhoto($db, $url)
{
	$sql = "UPDATE entries SET image=NULL WHERE url=? LIMIT 1";
	if($stmt = $db->prepare($sql))
		{
			$stmt->bind_param('s', $url);
			$stmt->execute();
			return true;
		}


return false;
}

function formatImage($img=NULL, $alt=NULL)
{
	if(isset($img))
	{
		return '<img src="'.$img.'" alt="'.$alt.'" />';
	}
	else
	{
		return NULL;
	}
}

?>