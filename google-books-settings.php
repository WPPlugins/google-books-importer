
<div id="settings-page-wrap">
<div id="gbi_mapfields">
	<div class="gbi_fieldsmaparea">
		<form method="post">
			<table class="gbi_fieldsmaparea_main">
				<tr><td>Post Title</td><td><select name="post_title"><?php foreach($book_fields as $f) { ?>
					<option value="<?php echo $f; ?>" <?php if($mappedfields['post_title'] == $f) { echo "selected"; } ?>><?php echo $f; ?></option>
					<?php } ?></select></td></tr>
				<tr><td>Post Content</td><td><select name="post_content"><?php foreach($book_fields as $f) { ?>
					<option value="<?php echo $f; ?>" <?php if($mappedfields['post_content'] == $f) { echo "selected"; } ?>><?php echo $f; ?></option>
					<?php } ?></select></td></tr>
				<tr><td>Post Excerpt</td><td><select name="post_excerpt"><?php foreach($book_fields as $f) { ?>
					<option value="<?php echo $f; ?>" <?php if($mappedfields['post_excerpt'] == $f) { echo "selected"; } ?>><?php echo $f; ?></option>
					<?php } ?></select></td></tr>
				<tr><td>Post Status</td><td>
					<select name="post_status">
						<option value="publish" <?php if($mappedfields['post_status'] == 'publish') { echo "selected"; } ?>>publish</option>
						<option value="pending" <?php if($mappedfields['post_status'] == 'pending') { echo "selected"; } ?>>pending</option>
						<option value="draft" <?php if($mappedfields['post_status'] == 'draft') { echo "selected"; } ?>>draft</option>
					</select>
				</td></tr>
				<tr><td>Comment Status</td><td>
					<select name="comment_status">
						<option value="open" <?php if($mappedfields['comment_status'] == 'open') { echo "selected"; } ?>>open</option>
						<option value="closed" <?php if($mappedfields['comment_status'] == 'closed') { echo "selected"; } ?>>closed</option>
					</select>
				</td></tr>
				<tr><td>Post Type</td><td>
					<select name="post_types">
						<?php foreach(get_post_types() as $post_type) { ?>
							<option value="<?php echo $post_type; ?>" <?php if($mappedfields['post_types'] == $post_type) { echo "selected"; } ?>><?php echo $post_type; ?></option>
						<?php } ?>
					</select>
				</td></tr>
				<tr><td>Post Category</td><td>
					<select name="category">
						<option value="0"> --- </option>
						<?php foreach($book_fields as $f) { ?>
						<option value="<?php echo $f; ?>" <?php if($mappedfields['category'] == $f) { echo "selected"; } ?>><?php echo $f; ?></option>
						<?php } ?>
					</select></td></tr>
				<tr>
				<tr><td>Featured Image</td><td>
					<input type="checkbox" name="featuredimage" value="1" <?php if($mappedfields['featured'] == '1') { echo "checked"; } ?>>
					</td></tr>
				<tr>
			</table>
			
			<table class="gbi_customfieldsarea">		
					<td><hr></td><td><hr></td></tr>
					<?php if(isset($mappedfields['customfields']) && !empty($mappedfields['customfields'])) { 
							foreach($mappedfields['customfields'] as $ckey => $cval) { ?>
								<tr>
									<td>
										<select name="customfields[]">
											<?php if(is_int(strpos($ckey, 'defaultgbkey_'))) { ?>
											<option value="defaultgbkey" selected> -- select -- </option>
											<?php } ?>
											<?php foreach($dbcustomfields as $dbkey) { ?>
											<option value="<?php echo $dbkey; ?>" <?php if($dbkey == $ckey) { echo "selected"; } ?>><?php echo $dbkey; ?></option>
											<?php } ?>
										</select>
									</td>
									<td>
										<select name="customfields[]">
											<?php foreach($book_fields as $bf) { ?>
											<option value="<?php echo $bf; ?>" <?php if($bf == $cval) { echo "selected"; } ?>><?php echo $bf; ?></option>
											<?php } ?>
										</select> <a href="#" class="cfieldremove">X</a>
									</td>
								</tr>
					<?php } } ?>
			</table>
			<a href="#" id="newcustomfield">+ New Custom Field</a><br />
			<input type="hidden" name="mapfield" value="1" /><br />
			<input type="hidden" name="dbcustomfields" id="dbcustomfields" value="<?php foreach($dbcustomfields as $v) { echo $v.','; } ?>" />

			<br>
			<input type="submit" class="button" value="Save" />
		</form>
	</div>
			
</div><!-- #gbi_mapfields -->

<div id="gbi_searchoptions">
	<div class="gbi_optionsarea"> 
		<form method="post">
			<label>API Key:</label>
			<input type="text" name="gbi_apikey" size="30" value="<?php if(isset($key)) { echo $key; } ?>" /> <a href="https://console.developers.google.com/home/dashboard" target="_blank">Get API Key</a></p>
			<input type="submit" class="button" value="Save" />
		</form>
	</div>
</div><!-- #gbi_searchoptions -->
		
</div>
