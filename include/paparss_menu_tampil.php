<?php
global $start,$wpdb;

$submit=$_POST["submit"];

if($submit=="Save"){

	$tags=$_POST["tags"];

	$rss=$_POST["rss"];

	$cats=$_POST["cat"];

	$rss_ID=$_POST["ID"];

	$items=$_POST["items"];

	$socializeit=$_POST["socializeit"];

	$link_source=$_POST["link_source"];

	if(is_array($cats)){

		foreach($cats as $cat){

			$cat_desc.=get_the_category_by_ID($cat).",";

		}

		$cat_desc=substr($cat_desc,0,strlen($cat_desc)-1);

	}

	else if($cats){

		$cat_desc=get_the_category_by_ID($cats);

	}

	if($rss_ID){

		$sql="update {$wpdb->prefix}paparssdbase_feed set rss='$rss',category='$cat_desc',tags='$tags',items='$items',socializeit='$socializeit',link_source='$link_source' where id='$rss_ID'";

	}

	else{

		$sql="insert into {$wpdb->prefix}paparssdbase_feed(rss,category,tags,items,socializeit,link_source) values('$rss','$cat_desc','$tags','$items','$socializeit','$link_source')";

	}

	

	$wpdb->query($sql);

	if($wpdb->insert_id){

		$msg1="RSS Feed Successfully Added";

	}

	else{

		$msg1="RSS Feed Successfully Updated";

	}

}

$action=$_REQUEST["act"];

if($action=="delete"){

	$chk=$_REQUEST["chk"];

	if(is_array($chk)){

		$i=0;

		foreach($chk as $id){

			$sql="delete from {$wpdb->prefix}paparssdbase_feed where ID='$id'";

			$wpdb->query($sql);

			$i++;

		}

		$msg="$i RSS Feed Have Been Deleted";

	}

	else if($chk){

			$sql="delete from {$wpdb->prefix}paparssdbase_feed where ID='$chk'";

			$wpdb->query($sql);

			$msg="1 RSS Feed Have Been Deleted";

	}

	else{

			$msg="No Article Deleted";

	}

}

if($action=="enable" || $action=="disable"){

	$chk=$_REQUEST["chk"];

	$i=0;

	if(is_array($chk)){

		foreach($chk as $id){

			$sql="update {$wpdb->prefix}paparssdbase_feed set status='".($action=="enable"?"1":"0")."' where ID='$id'";

			$wpdb->query($sql);

			$i++;

		}

		$msg="$i RSS Feed Have Been Updated";

	}

	else if($chk){

			$sql="update {$wpdb->prefix}paparssdbase_feed set status='".($action=="enable"?"1":"0")."' where ID='$chk'";

			$wpdb->query($sql);

			$msg="1 RSS Feed Have Been Updated";

	}

	else{

			$msg="No Rss Feed Updated";

	}

}

if($action=="fetch"){

	$chk=$_REQUEST["chk"];

	$i=0;

	if(is_array($chk)){

		foreach($chk as $id){

			paparss_melakukan_cron($id);

			$i++;

		}

		$msg="$i RSS Feed Import Success!";

	}

	else if($chk){

		paparss_melakukan_cron($chk);			

		$msg="1 RSS Feed Have Been Fetched Manually";

	}

	else{

			$msg="No Rss Feed Fetched";

	}

}
?>