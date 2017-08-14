<?php

global $wpdb; 

require_once('gbooksimport.php');
$import = new Gbooksimport();

$adminpage = trim($_GET['page']);
$note = '';

// pagination 
$itemsperpage = 36;

if(isset($_GET['gsearch']) && !empty($_GET['gsearch'])) { 

	if(isset($_GET['paged']) && is_numeric($_GET['paged'])) { 
		$starton = ($_GET['paged'] - 1) * $itemsperpage;
	} else {
		$starton = 0;
	}
	
	$itemsnumcheck = $import->searchBooks($_GET['gsearch'], array('maxResults' => $itemsperpage, 'startIndex' => $starton));
	
	// This number is not accurate across all pages. Google API doesn't return the same number for different 'startIndex' parameters. This is why some pages will display no results. But better something than nothing :/
	$totalitems = $itemsnumcheck['totalItems'];
	
} else {
	$totalitems = 0;
}

if(isset($_GET['paged']) && is_numeric($_GET['paged'])) { 
	$start = ($_GET['paged'] - 1) * $itemsperpage;
} else {
	$start = 0;
}

if(isset($_GET['p']) && is_numeric($_GET['p'])) { 
	$pages = $_GET['p'];
} else { 
	if($totalitems > $itemsperpage) { 
		$pages = ceil($totalitems/$itemsperpage);
	} else {
		$pages = 1; 
	}
}

if(isset($_POST['gbooks']) && !empty($_POST['gbooks'])) { 
	
	$ids = array();
	foreach($_POST['gbooks'] as $key => $val) { 
		$ids[] = $key;
	}
	$import->importBooks($ids);
	$note = $import->inserted.' items imported'; 
}

if(isset($_GET['gsearch']) && !empty($_GET['gsearch'])) { 
	
	$startindex = isset($_GET['s']) ? $_GET['s'] : 0;
	
	$searchresults = $import->searchBooks($_GET['gsearch'], array('maxResults' => $itemsperpage, 'startIndex' => $start));
	$allbooks = $searchresults['items'];
	
} else {
	$allbooks = array();
}

if(isset($_POST['gbi_apikey'])) { 
	$key = trim($_POST['gbi_apikey']);
	update_option('gbi_apikey', $key);
	$note = 'Changes Saved';
}

if(isset($_POST['mapfield'])) { 
	
	$clean = array();
	$clean['post_title'] = $_POST['post_title'];
	$clean['post_content'] = $_POST['post_content'];
	$clean['post_excerpt'] = $_POST['post_excerpt'];
	$clean['comment_status'] = $_POST['comment_status'];
	$clean['post_types'] = $_POST['post_types'];
	$clean['post_status'] = $_POST['post_status'];
	$clean['category'] = $_POST['category'];
	$clean['featured'] = isset($_POST['featuredimage']) ? '1' : '0';
	
	$customfields = array();
	if(isset($_POST['customfields']) && is_array($_POST['customfields'])) { 
		$loopnum = count($_POST['customfields']) / 2;
		for($x = 0; $x < $loopnum; $x++) { 
			$offset = $x * 2;
			$newpair = array_slice($_POST['customfields'], $offset, 2);
			
			if($newpair[0] == 'defaultgbkey') { 
				$newpair[0] = 'defaultgbkey_'.$x;
			}
			$customfields[$newpair[0]] = $newpair[1];
		}
	}

	$clean['customfields'] = $customfields;
	update_option('gbi_fields', $clean);
	$note = 'Changes Saved';
}

// google books API provided fields 
$book_fields = array('id','title','subtitle','authors','publisher','publishedDate','description','pageCount','categories','averageRating','smallThumbnail','mediumImage','largeImage','thumbnail','language','previewLink','infoLink','saleability','isEbook','viewability','epubacsTokenLink','pdfdownloadlink','webReaderLink'); 

// sort fields
asort($book_fields);

// existing wordpress fields 
$sql = "SELECT DISTINCT meta_key FROM {$wpdb->postmeta} ORDER BY meta_key LIMIT 150";
$dbcustomfields = $wpdb->get_col($sql);

$mappedfields = get_option('gbi_fields');
$key = get_option('gbi_apikey');

?>
<div class="wrap">

	<h2 class="gbtitle"><span class="dashicons dashicons-book-alt"></span> Google Books Importer</h2>

	<div class="gbi_top">
		<?php if(!empty($note)) { ?><div class="updated"><p><strong><?php echo $note; ?></strong></p></div><?php } ?>
		
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if($adminpage == 'google-books-importer') { echo 'nav-tab-active'; } ?>" id="gbi-search" href="<?php echo admin_url('admin.php?page=google-books-importer'); ?>">Search</a>
			<a class="nav-tab <?php if($adminpage == 'google-books-settings') { echo 'nav-tab-active'; } ?>" id="gbi-settings" href="<?php echo admin_url('admin.php?page=google-books-settings'); ?>">Settings</a>
		</h2>
	
		<?php include($adminpage.'.php'); ?>
		
	</div><!-- /.gbi_top -->

</div><!-- /.wrap -->
