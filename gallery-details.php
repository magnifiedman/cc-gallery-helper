<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 

if(!isset($_COOKIE['photoLogged'])){ header("Location: admin.php?".rand(1,9999)); exit; }

$x=rand(1,9999);
$g = new Gallery();
$step=1; 

if(isset($_POST['editForm'])){
	if($g->updateGallery($_POST)){
		$step=2;
	}
}

$galleryHTML = $g->getGalleryDetails($_GET['id']);

// local header
	include(ROOT_PATH . 'inc/header-local.inc.php');

// cc header
	//include_once('/export/home/common/template/T25globalincludes'); // do not modify this line
	//include_once (CDB_REFACTOR_ROOT."feed2.tool"); // do not modify this line

	//set variables for og tags and other meta data
	/*$page_title = "Photo Gallery Helper";
	$page_description = "";
	$keywords = "";
	$url = "http://" . $_SERVER["HTTP_HOST"] .$PHP_SELF; // do not modify this line

	$useT27Header = true; //this is a global flag that controls the header file that will be included. Do not change or remove this variable.
	include('CCOMRheader.template'); // do not modify this line*/
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/jquery.fancybox.css?x=<?php echo $x; ?>">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css?x=<?php echo $x; ?>">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/font-awesome.min.css?x=<?php echo $x; ?>">


	<div class="pageContainer">
		<img src="img/header.jpg" class="header" />

			<?php if ($step==2){ echo '<p class="success">Gallery has been updated.</p>'; } ?>
			
			<p><a href="admin.php?<?php echo rand(1,9999); ?>">&laquo; back to overview page</a></p>

			<form action="" method="post" id="theForm">
				<input type="hidden" name="editForm" value="y" />
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
				<p><label>Gallery Subject / Artist:</label><input type="text" name="subject" class="required w-640" value="<?php echo $galleryHTML['subject']; ?>" /></p>
				<p><label>Description:</label><input type="text" name="description" class="required w-640" value="<?php echo $galleryHTML['description']; ?>" /></p>
				<p><label>Embed Code:</label><textarea name="embed" class="codeholder w-640 required"><?php echo htmlspecialchars($galleryHTML['embed']); ?></textarea></p>
				<p><input type="submit" value="Update Details" name="submit" /></p>
			</form>
			<?php echo $galleryHTML['embed']; ?>
	</div>

<!-- local footer -->
	<?php include(ROOT_PATH . 'inc/footer-cc.inc.php'); ?>

<!-- cc footer -->
	<!-- <script src="<?php echo BASE_URL; ?>js/jquery-1.10.1.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.validate.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.fancybox.pack.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script>
	$(document).ready(function() {
			$('.fancybox').fancybox();
			$("#theForm").validate();
	});
	</script> -->

	<?php //include('CCOMRfooter.template'); ?>
