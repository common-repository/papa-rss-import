<div class="wrap">
<h2><?php echo __("PAPA DESTRA RSS IMPORT"); ?>&nbsp;&nbsp;&nbsp;<a href="http://www.facebook.com/login.php#!/profile.php?id=1668887139" target="_blank"><img src="http://i1008.photobucket.com/albums/af208/gagombale/facebook.png" border="0" title="Find On Facebook"></a>&nbsp;<a href="mailto:ngadiluwih@gmail.com" target="_blank"><img src="http://i1008.photobucket.com/albums/af208/gagombale/email.png" border="0" title="E-mail Me !"></a>&nbsp;<a href="http://feeds.feedburner.com/ProfesionalDesainWeb" target="_blank"><img src="http://i1008.photobucket.com/albums/af208/gagombale/rss-1.png" border="0" title="RSS Update"></a>&nbsp;&nbsp;<a href="http://profiles.wordpress.org/users/papadestra/" target="_blank"><img src="http://i1008.photobucket.com/albums/af208/gagombale/wpplg.jpg" border="0" title="papadestra's Plugins"></a></h2>
Simple and easy to import RSS feeds from several websites that you want. Keeping the content is always fresh with the display news or articles that are always updated. About RSS you can see at <a href="http://en.wikipedia.org/wiki/RSS" target="_blank" title="From Wikipedia, the free encyclopedia">this link</a>. If you need support please visit us at: <a href="http://www.papadestra.com/" target="_blank" title="Developer In Public Service">http://www.papadestra.com/</a>
<br /><br />
<?php 
rssagg_print_paginate($start);
?>
<!--////////////////////////////////////////////////////////////////// -->
<a anchor="edit">
<div class="wrap">
<h2>Add RSS Feed</h2>
<form name="post" method="post" id="post">
<?php
if($msg1){
	echo "<div class='updated fade' id=\"updatenotice\">$msg1</div>";
}
?>
<fieldset>
  <legend><?php _e('RSS Feed (<i>e.g:http://feeds.feedburner.com/ProfesionalDesainWeb</i>)') ?></legend>
  <div><input type="text" name="rss" size="40px" tabindex="1" value="<?php echo attribute_escape( $rss ); ?>" />
  <input type="hidden" name="ID" value="<?php echo $ID?>" />
  <input type="hidden" name="start" value="<?php echo $start?>" />
&nbsp;<?php _e('Items') ?>&nbsp;<input type="text" name="items" size="10px" tabindex="1" value="<?php echo attribute_escape( $items); ?>" />&nbsp;&nbsp;<?php _e('Tags') ?>&nbsp;<input type="text" name="tags" size="30px" tabindex="1" value="<?php echo attribute_escape( $tags); ?>" />
  </div>
</fieldset>
<fieldset>
  <legend><?php _e('Categories For RSS') ?></legend>
  <div><?php rssagg_dropdown_categories("hierarchical=1&hide_empty=0&selected=$catIDs")?></div>
</fieldset>
<fieldset>
&nbsp;<?php _e('Include Link Source ') ?>&nbsp;<input type="radio" name="link_source" value="1" <?php echo ($link_source==0?"checked":""); ?> />&nbsp;Yes&nbsp;<input type="radio" name="link_source" value="0" <?php echo ($link_source==1?"checked":""); ?> />&nbsp;No
</fieldset>
<fieldset class="submit">
<input type="submit" name="submit" value="<?php _e('Save') ?>" style="font-weight: bold;" />
</fieldset>
</form>
</div>
</a>
<!--///////////////////////////////////////////// -->
<?php
	if($msg) echo "<div class='updated fade' id=\"updatenotice\">".$msg."</div>";
	?>
<h2>Import RSS</h2>
<table class="widefat">
	<thead>
	<tr>
		<th scope="col"><div style="text-align: center">ID</div></th>
		<th scope="col">RSS Feed</th>
		<th scope="col">Items</th>
		<th scope="col">Categories</th>
		<!--<th scope="col">Tags</th> -->
		<th scope="col">Total Posts</th>
		<th scope="col">Status</th>
		<th scope="col">Source Link</th>
		<th scope="col" colspan=4></th>
	</tr>
	</thead>
<form method="post" id="edtForm">	
<input type="hidden" name="act" />
	<tbody id="the-list">
<?php
$rssagg_lists = rssagg_get_list($start);
if (count($rssagg_lists)) {
	$bgcolor = '';	
	$class = ('alternate' == $class) ? '' : 'alternate';
	foreach($rssagg_lists as $rssagg_list) {
		print "<tr id='post-{$rssagg_list->id}' class='$class'>\n";
		?>
		<th scope="row" style="text-align: center"><?=$rssagg_list->ID ?></th>
		<td><a href="<?=$rssagg_list->rss?>" target=_blank><?=$rssagg_list->rss ?></a></td>
		<td><?=$rssagg_list->items?></td>
		<td><?=$rssagg_list->category ?></td>
		<td><?=$rssagg_list->totalpost ?></td>
		<td><?=($rssagg_list->status==1?"Enabled":"Disabled") ?></td>
		<td><?=($rssagg_list->link_source==1?"Yes":"No") ?></td>
		<td><a href='edit.php?page=papa-rss-import/papa-rss.php&act=edit&chk=<?php echo $rssagg_list->ID?>&start=<?php echo $start?>#edit' class='edit'><?php echo ("Edit"); ?></a></td>
		<td><a href='edit.php?page=papa-rss-import/papa-rss.php&act=<?php echo ($rssagg_list->status==0?"enable":"disable")?>&chk=<?php echo $rssagg_list->ID?>&start=<?php echo $start?>' class='edit'><?php echo ($rssagg_list->status==0?"Enable":"Disable") ?></a></td>
		<td><a href='edit.php?page=papa-rss-import/papa-rss.php&act=delete&chk=<?php echo $rssagg_list->ID?>&start=<?php echo $start?>' class='delete' onClick="return confirm('<?php
			echo ("You Sure Delete this RSS??"); ?>');"><?=__('Delete')?></a></td>
		<td>
		<p class=submit><input type=checkbox name="chk[]" value="<?php echo $rssagg_list->ID?>"/></p>
		</td>
<?php
		}
?>
	</tr> 
<?php
	} else {
?>
	<tr style='background-color: <?php echo $bgcolor; ?>'> 
		<td colspan="6"><?php _e('No RSS Found.') ?></td> 
	</tr> 
<?php
}
?>
</tbody>
<input type=hidden name="start" value="<?php echo $start?>" />
</form>
</table>
</div>
<?php
if($action=="edit"){
	$ID=$_REQUEST["chk"];
	$sql="select * from {$wpdb->prefix}paparssdbase_feed where ID='$ID'";
	$row=$wpdb->get_row($sql);
	$rss=$row->rss;
	$items=$row->items;
	$tags=$row->tags;
	$socializeit=$row->socializeit;
	$category=$row->category;
	$link_source=$row->link_source;
	$cats=explode(",",$category);
	$catIDs="";
	foreach($cats as $cat){
		$sql="select term_id from $wpdb->terms where name='$cat'";
		$catID=$wpdb->get_var($sql);
		$catIDs .=$catID.",";
	}
	$catIDs=substr($catIDs,0,strlen($catIDs)-1);
}
?>
<p class=submit>
<input type=button value="Import Now!" onClick="doFetch(document.getElementById('edtForm'))" />
<input type=button value="Delete" onClick="deleteRss(document.getElementById('edtForm'))" /> 
</p>
<p><font color="#FF0000">NOTE :</font> For the first time you have to "<b>Deactivate</b>" this plugins, and hit again "<b>Activate</b>"
<br />
<em>( PLUGINS - Plugins - PAPA DESTRA RSS IMPORT - Press Deactivate (and wait deactivate process) - Then Click Activate - Completed )
</em>
</p>
<!-- sumbangan -->
<p>
<font color="#999999" face="Georgia">If you find this useful and intend to contribute to us, please use the Liberty Reserve! thanks have supported us</font><br><a href="https://sci.libertyreserve.com/en?lr_acc=U0407178&lr_currency=LRUSD&lr_success_url=http%3a%2f%2fwww.papadestra.com%2fhubungi-kami%2f&lr_success_url_method=GET&lr_fail_url=http%3a%2f%2fwww.papadestra.com%2fhubungi-kami%2f&lr_fail_url_method=GET" alt="Donations using Liberty Reserve" target="_blank"><img src="http://www.intelfx-indonesia.com/images/liberty_reserve.gif" border="0" title="Donations using Liberty Reserve"/></a>
</p>