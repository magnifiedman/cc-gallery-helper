<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 

if(!isset($_COOKIE['photoLogged'])){ header("Location: admin.php?".rand(1,9999)); exit; }

$x=rand(1,9999);
$g = new Gallery();
$step=1; 

if(isset($_POST['addForm'])){
	if($g->addGallery($_POST)){
		$step=2;
	}
}

// local header
	include(ROOT_PATH . 'inc/header-local.inc.php');*/

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

			
			<?php if ($step==1){ ?>
			<form action="" method="post" id="theForm">
				<input type="hidden" name="addForm" value="y" />
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
				<p><label>Gallery Subject / Artist:</label><input type="text" name="subject" class="required w-640" value="" /></p>
				<p><label>Description:</label><input type="text" name="description" class="required w-640" value="" /></p>
				<p><label>Embed Code:</label><textarea name="embed" class="codeholder w-640 required"></textarea></p>
				<p><input type="submit" value="Add Gallery" name="submit" /></p>
			</form>
			<?php } ?>

			<?php if ($step==2){
				echo '<p class="success">Gallery has been added. <a href="admin.php?'.rand(1,9999).'">&laquo; back to overview page</a></p>'; 
				echo '<h2>' . $_POST['subject'] . ': '. $_POST['description'] . '</h2>';
				echo stripslashes($_POST['embed']);
			} ?>
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
