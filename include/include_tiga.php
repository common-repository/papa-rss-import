<?php
global $wpdb,$socialIt;

	if($id)

		$sql="select * from {$wpdb->prefix}paparssdbase_feed where status='1' and id='$id'";

	else

		$sql="select * from {$wpdb->prefix}paparssdbase_feed where status='1'";

	$rows=$wpdb->get_results($sql);
	foreach($rows as $row){

		$url=$row->rss;

		$rss=fetch_rss($url);
		
		if($rss->items){

		srand((float)microtime() * 1000000);

		shuffle($rss->items);

		$items=array_slice($rss->items,0,$row->items);

		$itempost=0;

		if(empty($items)) continue;

		foreach($items as $item){

			$item["title"]=attribute_escape($item["title"]);
			$asu="_blank";

			if($row->link_source)
// Iki Tampilan sing metu neng konten
$source_link="<b><br><br>Read more Complete<br><a ref='nofollow' href=".$item["link"]." target=".$asu.">".$item["title"]."</a></b>
				";

			else

				$source_link="";

			$item["description"]=$item["description"].$source_link;

			$sql="select ID from $wpdb->posts where post_title='".$item["title"]."' limit 0,1";

			

			$post_ID=$wpdb->get_var($sql);


			if($post_ID){

				$item["post_ID"]=$post_ID;


			} else{



				$item["cats"]=$row->category;

				$item["tags"]=$row->tags;

				$post_ID=rssagg_post_article($item);
				if($post_ID && $row->socializeit){

					if(isset($socialIt)){

						$_POST["theme_bookmark"]="1";

						$socialIt->submitWasb($post_ID);

					}

				}

				if($post_ID) $itempost++;

			}

		}

		$sql="update {$wpdb->prefix}paparssdbase_feed set totalpost=totalpost+".$itempost." where ID='".$row->ID."'";

		$wpdb->query($sql);

		}

	}
	?>