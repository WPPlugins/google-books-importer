jQuery(document).ready(function($) { 
	
	$("#selectallbox input").change(function() { 
		var cboxes = $(".gbi_itemcheckbox");
		if($(this).is(":checked")) { 
			cboxes.attr('checked', 'checked');
		} else { 
			cboxes.removeAttr('checked');
		}
	});
	
	$("#newcustomfield").on('click', function(e) { 
		
		var gbfields = ['id', 'title', 'subtitle', 'authors', 'publisher', 'publishedDate', 'description', 'pageCount', 'categories', 'averageRating', 'smallThumbnail', 'mediumImage', 'largeImage', 'thumbnail', 'language', 'previewLink', 'infoLink', 'saleability', 'isEbook', 'viewability', 'epubacsTokenLink', 'pdfdownloadlink', 'webReaderLink']
		
		// pick up saved custom field keys 
		var dbcustomfields = $("#dbcustomfields").val();
		dbcustomfields = dbcustomfields.split(',');
		
		var newentry = '<tr><td>';
		newentry += '<select name="customfields[]">';
		newentry += '<option value="defaultgbkey"> -- select -- </option>';
		for(x = 0; x < dbcustomfields.length; x++) { 
			if(dbcustomfields[x] == '') { continue; } 
			newentry += '<option value"' + dbcustomfields[x] + '">' + dbcustomfields[x] + '</option>';
		}
		newentry += '</select>';
		newentry += '</td><td>';
		newentry += '<select name="customfields[]">';
		for(x = 0; x < gbfields.length; x++) { 
			newentry += '<option value="' + gbfields[x] + '">' + gbfields[x] + '</option>';
		}
		newentry += '</select>';
		newentry += ' <a href="#" class="cfieldremove">X</a>';
		newentry += '</td></tr>';
		
		$('.gbi_customfieldsarea').append(newentry);
		e.preventDefault();
	});
	
	$(".gbi_fieldsmaparea").on('click', '.cfieldremove', function(e) { 
		$(this).parent().parent().remove();
		e.preventDefault();
	});

});
