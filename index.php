<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 

$x=rand(1,9999);
$g = new Gallery();


// determine page number
if(isset($_GET['page'])){ $page = intval($_GET['page']); }
else { $page = 1; }

$searchHTML = $g->getPageGalleries($page);
$totalGalleries = $g->getTotalGalleries();
$totalPages = ceil( $totalGalleries / RESULTS_PERPAGE ); 


if(isset($_POST['searchForm'])){
	$searchHTML = $g->getSearchResults($_POST['searchStr']);
}

if($searchHTML===false){ $searchHTML = '<h2>Sorry, there were no results found for "' . $_POST['searchStr'] . '"</h2><p><a href="index.php">View Recent Galleries</a> or use the box to search again.</p>'; }

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

		<!-- search form -->
		<form action="" method="post" id="theForm">
			<input type="hidden" name="searchForm" value="y" />
			<p><label>Enter artist name or keywords here:</label><input type="text" class="required" name="searchStr" placeholder="Search Terms" value="<?php echo @$_POST['searchStr']; ?>" />
				<br /><input type="submit" name="submit" value="Find Galleries" /></p>
		</form>

		<?php if(!isset($_POST['searchStr'])){ include(ROOT_PATH . 'inc/pagination.html.php'); } ?>
		<?php echo $searchHTML; ?>
		<?php if(!isset($_POST['searchStr'])){ include(ROOT_PATH . 'inc/pagination.html.php'); } ?>

	</div>

<!-- local footer -->
	<?php include(ROOT_PATH . 'inc/footer-local.inc.php'); ?>

<!-- cc footer -->
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
