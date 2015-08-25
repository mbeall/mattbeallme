<?php
/**
 * mattbeallme functions and definitions
 *
 * @package Flint
 * @sub-package mattbeallme
 */

/*
 * Create theme functions for download button
 */
function has_download_btn() {
	global $post;
	$custom = get_post_custom($post->ID);
	if (!empty($custom['download_link'][0])) {return true;}
	else {return false;}
}
function the_download_btn() {
	global $post;
	$custom = get_post_custom($post->ID);
	isset($custom['download_label']) ? $label = $custom['download_label'][0] : $label = 'Download';
	echo '<a class="btn btn-primary btn-block visible-lg" href="' . $custom['download_link'][0] . '"><span class="glyphicon glyphicon-download"></span> ' . $label . '</a>';
}

/*
 * Create custom meta boxes
 */
add_action( 'add_meta_boxes', 'mbme_download_meta_boxes' );
function mbme_download_meta_boxes() { add_meta_box('mbme_download_meta', 'Download Button', 'mbme_download_meta', 'post', 'side', 'high'); }
function mbme_download_meta() { ?>
  
  <p><label>Label</label><br /><input type="text"  size="25" name="download_label" value="<?php echo mbme_meta('download_label'); ?>" /></p>
  <p><label>Link</label><br /><input type="text" size="25" name="download_link" value="<?php echo mbme_meta('download_link'); ?>" /></p><?php
}

/*
 * Save data from meta boxes
 */
add_action('save_post', 'save_steel_profile');
function save_steel_profile() {
  global $post;
  if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE && (isset($post_id))) { return $post_id; }
  if(defined('DOING_AJAX') && DOING_AJAX && (isset($post_id))) { return $post_id; } //Prevents the metaboxes from being overwritten while quick editing.
  if(preg_match('/\edit\.php/', $_SERVER['REQUEST_URI']) && (isset($post_id))) { return $post_id; } //Detects if the save action is coming from a quick edit/batch edit.
  if (isset($_POST['download_label'])) { update_post_meta($post->ID, "download_label", $_POST["download_label"]); }
  if (isset($_POST['download_link' ])) { update_post_meta($post->ID, "download_link" , $_POST["download_link" ]); }
}

/*
 * Display custom metadata
 */
function mbme_meta( $key, $post_id = NULL ) {
  global $post;
  $custom = $post_id == NULL ? get_post_custom($post->ID) : get_post_custom($post_id);
  $meta = !empty($custom[$key][0]) ? $custom[$key][0] : '';
  return $meta;
}
