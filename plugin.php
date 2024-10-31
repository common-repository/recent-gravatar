<?php
/*
Plugin Name: Recent Gravatar
Plugin URI: http://mr.hokya.com/recent-gravatar
Description: Place additional widget containing the gravatar of your recent commentators.
Version: 1.05
Author: Julian Widya Perdana
Author URI: http://mr.hokya.com/
*/


if(!get_option("rgravatar_size")) update_option("rgravatar_size",30);
if(!get_option("rgravatar_count")) update_option("rgravatar_count",25);

function recent_gravatar () {
	global $wpdb,$comment;
	$count = get_option("rgravatar_count");
	$size = get_option("rgravatar_size");
	$comments = $wpdb->get_results("select * from $wpdb->comments where comment_approved=1 LIMIT 0,$count ");
	foreach ($comments as $comments) {
		$comment = $comments;
		echo '<a title="'.get_comment_author().'" href="'.get_comment_link().'">'.get_avatar($comment,$size).'</a>';
	}
}

function widget_recent_gravatar($args) {
	extract($args);
	$title = get_option("rgravatar_title");
	echo $before_widget.$before_title.$title.$after_title;
	recent_gravatar();
	echo $after_widget;
}


function control_recent_gravatar () {
	if ($_POST["control_recent_gravatar"]) {
		update_option("rgravatar_size",$_POST["size"]);
		update_option("rgravatar_count",$_POST["count"]);
		update_option("rgravatar_title",$_POST["title"]);
	}
	$title = get_option("rgravatar_title");
	$size = get_option("rgravatar_size");
	$count = get_option("rgravatar_count");
	echo "<p>Title:<br/><input name='title' value='$title' size='32'/></p>";
	echo "<p>Number of Gravatars:<input size='3' value='$count' name='count' maxlength='2'/></p>";
	echo "<p>Size of each Gravatars:<input size='3' value='$size' name='size' maxlength='3'/>px</p>";
	echo "<div align='right'><small><a href='http://mr.hokya.com/recent-gravatar/' target='_blank'>how does it work?</a></small></div>";
	echo "<input type='hidden' name='control_recent_gravatar' value='1'/>";
}

function register_recent_gravatar () {
	register_sidebar_widget("Recent Gravatar","widget_recent_gravatar");
	register_widget_control("Recent Gravatar","control_recent_gravatar");
}

add_action('plugins_loaded','register_recent_gravatar');

?>