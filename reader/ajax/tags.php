<?php
include('apps/reader/lib/tag_utils.php');
	$path_of_ebook = $_POST['path'];
	$new_tag = $_POST['tag'];
	$path_of_ebook = urldecode($path_of_ebook);
	$tags = find_tags_for_ebook($path_of_ebook);
	if ($tags != NULL) {
		$new_tag = $tags.",".$new_tag;
		update_tag_for_ebook($new_tag,$path_of_ebook);
	}
	else {
		insert_new_tag($new_tag,$path_of_ebook);
	}
?>
