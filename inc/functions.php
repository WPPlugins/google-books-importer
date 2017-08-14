<?php

/*
* Create attachment from remote image 
* 
* @param string remote image url 
* @param int ID of the post to assign attachment to
* @return int attachment ID
* */
function generateimageremote($url, $postid = 0) { 
	
	if(!filter_var($url, FILTER_VALIDATE_URL)) { 
		return;
	}
	
	$filename = uniqid().'_gbooks.png';
	$updir = wp_upload_dir();
	$newfile = $updir['path'].'/'.$filename;
	$filetype = wp_check_filetype($filename, null);
	copy($url, $newfile);
	
	$attachment = array(
		'guid'           => $updir['url'].'/'.$filename,
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);
	
	$attach_id = wp_insert_attachment($attachment, $newfile, $postid);
		
	require_once(ABSPATH.'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata($attach_id, $newfile); 
	wp_update_attachment_metadata($attach_id, $attach_data);
	return $attach_id;

}

/*
 * Pagination 
 * */
function unipagination($pages = 1, $paged = 1, $range = 3) { 
	
	$showitems = ($range * 2)+1;  
	
	if(isset($_GET['paged'])) { 
		$paged = $_GET['paged'];
	}
	
	if(1 != $pages) { 
		
		 echo '<ul class="unipagination">';
			 
		 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
		 if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

		 for ($i=1; $i <= $pages; $i++)
		 {
			 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			 {
				 echo ($paged == $i)? "<li class='active'><a>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
			 }
		 }
			
		 if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>"; 
		 
		 echo '</ul>';
	 }

}
