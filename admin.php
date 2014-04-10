<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 

$x=rand(1,9999);
$g = new Gallery();

$step=1;
$deleteMessage='';

// determine page number and totals for pagination
if(isset($_GET['page'])){ $page = intval($_GET['page']); }
else { $page = 1; }
$totalGalleries = $g->getTotalGalleries();
$totalPages = ceil( $totalGalleries / RESULTS_PERPAGE ); 


// logging in
if(isset($_POST['loginForm'])){
	if($g->doLogin($_POST)){
		$step=2;
		setcookie('photoLogged','y');
	}
	else {
		$error = '<p class="error">Incorrect email/password. Please try again.</p>';
	}
}


// deleting gallery
if(isset($_POST['deleteForm'])){
	if($g->deleteGallery($_POST['id'])){
		$deleteMessage = '<p class="success">Gallery successfully deleted.</p>'; 
	}
}


// bypass login form if cookie set
if(isset($_COOKIE['photoLogged']) && $_COOKIE['photoLogged']=='y'){ $step=2; }


// get galleries
if($step==2){ $adminHTML = $g->getAdminListing($page); }


// local header - comment out to go live on cc server
	include(ROOT_PATH . 'inc/header-local.inc.php');


// cc header - remove comment tags to go live on cc servers
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

		<?php if($step==1){ ?>

		<!-- search form -->
		<form action="" method="post" id="theForm">
			<?php if(isset($error)){ echo $error; } ?>
			<input type="hidden" name="loginForm" value="y" />
			<p><label>Your Email Address:</label><input type="email" class="required" name="email" placeholder="Your Email" value="<?php echo @$_POST['email']; ?>" /></p>
			<p><label>Password:</label><input type="password" class="required" name="pword" value="<?php echo @$_POST['pword']; ?>" /></p>
			<p><input type="submit" name="submit" value="Log In" /></p>
		</form>

		<?php } ?>

		<?php if($step==2){ ?>

			<div class="logoutbox clearfix"><a href="logout.php">Sign Out</a></div>
			<div class="clearfix">&nbsp;</div>

			<?php
			echo $deleteMessage; ?>
			<?php include(ROOT_PATH . 'inc/pagination.html.php'); ?>
			<?php echo $adminHTML; ?>
			<?php include(ROOT_PATH . 'inc/pagination.html.php'); ?>

		<?php } ?>

	</div>

<!-- local footer - comment out to go live on cc servers -->

	<?php include(ROOT_PATH . 'inc/footer-local.inc.php'); ?>


<!-- cc footer - remove comment tags to go live on cc servers -->

	<!-- <script src="<?php echo BASE_URL; ?>js/jquery-1.10.1.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.validate.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.fancybox.pack.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script>
		$(document).ready(function() {
			$('.fancybox').fancybox();
			$('#previewpop').fancybox();
			$("#theForm").validate();

			$("a.preview").click(function(event){
				var gid = $(this).attr('id');
				$.ajax({
					type: "get",
					url: "lib/ajax.php",
					data: "id="+gid,
					dataType: 'json',
					success: function (data) {
						$('#preview').html(data['embed']);
						$('#previewpop').trigger('click'); 
					}
				});
			});
		});
	</script> -->

	<?php //include('CCOMRfooter.template'); ?>
