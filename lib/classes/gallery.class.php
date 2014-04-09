<?php
/* Photo Gallery Helper Gallery Class
 * Original Creation Date 04.2014
 * Wherein we create all functions for this application
 */

class Gallery {
	
	
	### FRONTEND FUNCTIONS ##########

	function getAllGalleries($page=''){
		$r = mysql_query("
			SELECT *
			FROM " . GALLERIES_TABLE . "
			ORDER BY date_entered desc
			LIMIT 25");

		if(mysql_num_rows($r)>0){
			$html = '';
			$html .= '<h2>Latest Galleries</h2>';
			$html .= '<table class="gallery-search" cellspacing="0" cellpadding="0">'."\n";
			$html .= '<tr>'."\n";
			$html .= '<th>Date Entered</th><th>Subject</th><th>Description</th><th>Embed Code</th><th>Preview</th>'."\n";
			$html .= '</tr>'."\n";

			while ($gallery = mysql_fetch_assoc($r)){
				$html .= '<tr>'."\n";
				$html .= '<td>' . date("m-d-Y",strtotime($gallery['date_entered'])) . '</td><td>' . $gallery['subject'] . '</td><td>' . $gallery['description'] . '</td><td><i class="fa fa-align-left"></i> <a class="fancybox" href="#embed' . $gallery['id'] .'">Embed Code</a></td><td><i class="fa fa-picture-o"></i> <a class="fancybox" href="#preview' . $gallery['id'] .'">Preview Gallery</a></td>'."\n";
				$html .= '</tr>'."\n";
				$html .= '<div id="embed' . $gallery['id'] . '" style="width:640px;display: none;"><h2>GALLERY EMBED CODE:</h2><h3>' . $gallery['subject'] . ': ' . $gallery['description'] . '</h3><h3>&nbsp;</h3><h3>Select all and hit Ctrl-C (PC) or Command-C (Mac) to copy</h3><textarea class="codeholder">' . htmlspecialchars($gallery['embed']) . '</textarea></div>'."\n";
				$html .= '<div id="preview' . $gallery['id'] . '" style="width:640px;display:none;"><h2>GALLERY PREVIEW:</h2><h3>' . $gallery['subject'] . ': ' . $gallery['description'] . '</h3>' . $gallery['embed'] . '</div>'."\n";
			}

			$html .= '</table>'."\n";

			return $html;

		}

		else {
			return '<h2>No current galleries in the system.</h2>';
		}
	}

	function getSearchResults($searchStr,$page=''){
		$s = trim($searchStr);
		$s = explode(' ',$s);

		$searchResults1 = array();
		$searchResults2 = array();
		$searchSQL='';

		foreach ($s as $searchTerm){
			$searchSQL .= "'%" . $searchTerm . "%' and subject like ";
		}
		$searchSQL = substr($searchSQL ,0,-18);

		// subject
		$r1 = mysql_query("
			SELECT *
			FROM " . GALLERIES_TABLE . "
			WHERE subject like " . $searchSQL . "
			ORDER BY date_entered DESC
			");
		if(mysql_num_rows($r1) > 0){
			while($galleries1 = mysql_fetch_assoc($r1)){
				if(!in_array($galleries1,$searchResults1)){
					array_push($searchResults1,$galleries1);
				}
			}
		}

		// description
		$r2 = mysql_query("
			SELECT *
			FROM " . GALLERIES_TABLE . "
			WHERE description like '%" . $searchTerm . "%'
			ORDER BY date_entered DESC
			");
		if(mysql_num_rows($r2) > 0){
			while($galleries2 = mysql_fetch_assoc($r2)){
				if(!in_array($galleries2,$searchResults1)){
					array_push($searchResults2,$galleries2);
				}
			}
		}
		

		$searchResults = array_merge($searchResults1,$searchResults2);

		//print_r($searchResults);

		if(!empty($searchResults)){
			$html = '';
			$html .= '<h2>Showing results for "' . $_POST['searchStr'] . '"</h2>';
			$html .= '<table class="gallery-search" cellspacing="0" cellpadding="0">'."\n";
			$html .= '<tr>'."\n";
			$html .= '<th>Date Entered</th><th>Subject</th><th>Description</th><th>Embed Code</th><th>Preview</th>'."\n";
			$html .= '</tr>'."\n";

			foreach ($searchResults as $gallery){
				$html .= '<tr>'."\n";
				$html .= '<td>' . date("m-d-Y",strtotime($gallery['date_entered'])) . '</td><td>' . $gallery['subject'] . '</td><td>' . $gallery['description'] . '</td><td><i class="fa fa-align-left"></i> <a class="fancybox" href="#embed' . $gallery['id'] .'">Embed Code</a></td><td><i class="fa fa-picture-o"></i> <a class="fancybox" href="#preview' . $gallery['id'] .'">Preview Gallery</a></td>'."\n";
				$html .= '</tr>'."\n";
				$html .= '<div id="embed' . $gallery['id'] . '" style="width:640px;display: none;"><h2>GALLERY EMBED CODE:</h2><h3>' . $gallery['subject'] . ': ' . $gallery['description'] . '</h3><h3>&nbsp;</h3><h3>Select all and hit Ctrl-C (PC) or Command-C (Mac) to copy</h3><textarea class="codeholder">' . htmlspecialchars($gallery['embed']) . '</textarea></div>'."\n";
				$html .= '<div id="preview' . $gallery['id'] . '" style="width:640px;display:none;"><h2>GALLERY PREVIEW:</h2><h3>' . $gallery['subject'] . ': ' . $gallery['description'] . '</h3>' . $gallery['embed'] . '</div>'."\n";
			}

			$html .= '</table>'."\n";

			return $html;

		}

		else {
			return false;
		}
	}

	function getGalleryEmbedForm($galleryID){
		$r = mysql_query("
			SELECT embed
			FROM " . GALLERIES_TABLE . "
			WHERE id = '" . $galleryID ."'"
			);
		return htmlspecialchars(mysql_result($r,0,'embed'));
	}

	function getGalleryEmbedHTML($galleryID){
		$r = mysql_query("
			SELECT embed
			FROM " . GALLERIES_TABLE . "
			WHERE id = '" . $galleryID ."'"
			);
		return mysql_result($r,0,'embed');
	}


	### ADMIN FUNCTIONS ##########
	function doLogin($vars){
		$q = sprintf("
			SELECT *
			FROM " . ADMIN_USERS_TABLE ."
			WHERE email='%s' and pword='%s' LIMIT 1",
			mysql_real_escape_string($vars['email']),
			mysql_real_escape_string($vars['pword']));
		$r = mysql_query($q);
		
		if(mysql_num_rows($r)>0){ return true; }
		else { return false; }
	}


	function getAdminListing($page=''){
		$r = mysql_query("
			SELECT *
			FROM " . GALLERIES_TABLE . "
			ORDER BY date_entered desc
			LIMIT " . RESULTS_PERPAGE);


		if(mysql_num_rows($r)>0){
			$html = '';
			$html .= '<h2>Recent Photo Galleries: Admin</h2>';
			$html .= '<a class="button" href="add-gallery.php"><i class="fa fa-plus-square m"></i> Add Gallery</a>';
			$html .= '<table class="gallery-search" cellspacing="0" cellpadding="0">'."\n";
			$html .= '<tr>'."\n";
			$html .= '<th>Date Entered</th><th>Subject</th><th>Description</th><th>Preview</th><th>Edit</th><th>Delete</th>'."\n";
			$html .= '</tr>'."\n";

			while ($gallery = mysql_fetch_assoc($r)){
				$html .= '<tr>'."\n";
				$html .= '<td>' . date("m-d-Y",strtotime($gallery['date_entered'])) . '</td><td>' . $gallery['subject'] . '</td><td>' . $gallery['description'] . '</td><td><i class="fa fa-picture-o"></i> <a class="fancybox" href="#preview' . $gallery['id'] .'">Preview Gallery</a></td><td><i class="fa fa-pencil-square-o"></i> <a href="gallery-details.php?id=' . $gallery['id'] . '"">Edit Details</a></td><td><i class="fa fa-trash-o"></i> <a class="fancybox" href="#delete' . $gallery['id'] . '">Delete Gallery</a></td>'."\n";
				$html .= '</tr>'."\n"; 
				$html .= '<div id="embed' . $gallery['id'] . '" style="width:640px;display: none;"><h2>GALLERY EMBED CODE:</h2><h3>' . $gallery['subject'] . ': ' . $gallery['description'] . '</h3><h3>&nbsp;</h3><h3>Select all and hit Ctrl-C (PC) or Command-C (Mac) to copy</h3><textarea class="codeholder">' . htmlspecialchars($gallery['embed']) . '</textarea></div>'."\n";
				$html .= '<div id="preview' . $gallery['id'] . '" style="width:640px;display:none;"><h2>GALLERY PREVIEW:</h2><h3>' . $gallery['subject'] . ': ' . $gallery['description'] . '</h3>' . $gallery['embed'] . '</div>'."\n";
				$html .= '<div id="delete' . $gallery['id'] . '" style="width:640px;display:none;"><h2>Are you sure you want to delete:</h2><h3>' . $gallery['subject'] . ': ' . $gallery['description'] . '?</h3><form action="" method="post"><input type="hidden" name="deleteForm" value="y" /><input type="hidden" name="id" value="' . $gallery['id'] . '" /><br /><input type="submit" class="button" name="submit" value="Yes, Delete It!" /></form></div>'."\n";
			}

			$html .= '</table>'."\n";

			return $html;

		}

		else {
			$html .= '<h2>Recent Photo Galleries: Admin</h2>';
			$html .= '<a class="button" href="add-gallery.php"><i class="fa fa-plus-square m"></i> Add Gallery</a>';
			$html .= '<p>There are currently no galleries. You can add one above.</p>';
			return $html;
		}

	}

	function getGalleryDetails($galleryID){
		$r = mysql_query("
			SELECT *
			FROM " . GALLERIES_TABLE . "
			WHERE id='" . $galleryID ."'
			");
		if(mysql_num_rows($r)>0){
			return mysql_fetch_assoc($r);
		}
		else {
			header("Location: admin.php");
			exit;
		}

	}

	function addGallery($vars){
		$r = mysql_query("
			INSERT into " . GALLERIES_TABLE . "
			(id, date_entered, subject, description, embed)
			VALUES
			('',NOW(),'" . $vars['subject'] . "', '" . $vars['description'] . "', '" . $vars['embed'] . "')
			");
		return true;
	}

	function updateGallery($vars){
		$r = mysql_query("
			UPDATE " . GALLERIES_TABLE . "
			SET subject = '" . $vars['subject'] . "',
			description = '" . $vars['description'] . "',
			embed = '" . $vars['embed'] . "'
			WHERE id='" . $vars['id'] ."'
			");
		return true;
	}


	function deleteGallery($galleryID){
		$r = mysql_query("
			DELETE
			FROM " . GALLERIES_TABLE . "
			WHERE id='" . $galleryID ."'
			");
		return true;
	}
}



