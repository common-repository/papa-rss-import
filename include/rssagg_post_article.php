<?php

	global $wpdb;

$content=$row["description"];

	$post_content = apply_filters('phone_content', $content);

	$post_title = xmlrpc_getposttitle($row["title"]);

	if ($post_title == '') $post_title = $row["title"];

	if($row["post_ID"]){

		$ID=$row["post_ID"];

		$sql="select post_date,post_date_gmt from $wpdb->posts where ID='".$ID."'";

		$rows=$wpdb->get_results($sql);

		$post_date=$rows[0]->post_date;

		$post_date_gmt=$rows[0]->post_date_gmt;

	}
$post_status = 'publish';

	if($row["cats"]){

		$cats= explode(',',$row["cats"]);

		$i=0;

		foreach($cats as $cat){
			$ret=get_cat_ID($cat);
			$post_category[$i++]=$ret;

		}

	}

	else{

		$post_category=0;

	}

	

	if($row["tags"]){

		$tags_input= explode(',',$row["tags"]);

	}

	else{

		$tags_input=0;

	}

$post_data = compact('ID','post_content','post_title','post_status','post_type','post_category','tags_input','post_date','post_date_gmt');

	$post_data = add_magic_quotes($post_data);

$post_ID = wp_insert_post($post_data);

	return $post_ID;
?>