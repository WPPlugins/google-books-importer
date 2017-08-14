
<div id="search-page-wrap">
<?php
/*
var_dump('Total Pages: '.$pages);
var_dump('Offset: '.$start);
var_dump('Total items: '.$totalitems);
*/
?>
<div class="gbi_search_area">
	<form method="get" action="<?php echo admin_url('admin.php?page=google-books-importer'); ?>">
	<input type="hidden" name="page" value="google-books-importer">
	<input type="text" id="gbisearchform" name="gsearch" placeholder="Enter your keyword.." value="<?php if(isset($_GET['gsearch'])) { echo esc_attr($_GET['gsearch']); } ?>" /> 
	<input type="submit" class="button" value="Search Books" />
	</form>
</div>

<div class="gbi_results_area"> 
	<?php if(!empty($allbooks) && !is_string($allbooks)) { ?>
	<form method="post" action="">
	<div id="importbox"><input type="submit" value="Import" class="button" /></div>
	<div id="selectallbox"><input type="checkbox" /> Select All</div>
	<div class="clearfix"></div>
	<?php foreach($allbooks as $item) { ?>
		<div class="gbi_item">
			<a href="<?php echo $item['volumeInfo']['previewLink']; ?>" target="_blank" ><img src="<?php if(isset($item['volumeInfo']['imageLinks']['thumbnail'])) { echo $item['volumeInfo']['imageLinks']['thumbnail']; } else { echo plugins_url().'/google-books-importer/assets/noimage.png'; } ?>" height="140" width="120" /></a>
			<div class="gbi_item_meta">
			<input type="checkbox" name="gbooks[<?php echo $item['id']; ?>]" class="gbi_itemcheckbox" /> <?php echo $item['volumeInfo']['title']; ?>
		</div>
	</div>
	<?php } ?> 
	<div class="clearfix"></div>
	<div id="importbox"><input type="submit" value="Import" class="button" /></div>
	</form>
	<?php } ?>
	<?php if(is_string($allbooks)) { echo $allbooks; } ?>
</div>

<?php unipagination($pages); ?>

</div>
