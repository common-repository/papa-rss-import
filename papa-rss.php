<?php
/*
Plugin Name: PAPA DESTRA RSS IMPORT
Plugin URI: http://papadestra.wordpress.com/
Description: Imports news from Google and creates posts for them. All the settings you can do with ease. It is expected that the website will always be fresh content to attract your loyal visitors. For Information And Support <a href="http://papadestra.wordpress.com/" target="_blank" title="Papa Destra Developer In Public Service "><em>http://papadestra.wordpress.com/</em></a>
Version: 1.4
Author: Papa Destra
Author URI: http://papadestra.wordpress.com/
Stable tag: 1.4
*/
/*
ATTENTION PLEASE! Little changes you make in Scripts and the damage was not including our responsibility.
==========================================================================================================
==========================================================================================================
			!................(_).......................................... !
			!...............(___)......................................... !
			!...............(___)......................................... !
			!...............(___)......................................... !
			!...............(___)......................................... !
			!..... /\___/\__/---\__/\__/\................................. !
			!......\_____\_°_¤ ---- ¤_°_/................................. !
			!.............\ __°__ /....................................... !
			!..............|\_°_/|........................................ !
			!..............[|\_/|]........................................ !
			!..............[|[P]|].. http://papadestra.wordpress.com/..... !
			!..............[|;A;|]........................................ !
			!..............[;;P;;]......Web Design & Development.......... !
			!.............;[|;A]|]\....................................... !
			!............;;[|;D]|]-\......Our Best Services............... !
			!...........;;;[|[E]|]--\..................................... !
			!..........;;;;[|[S]|]---\...WEBSITE MAINTENANCE.............. !
			!.........;;;;;[|[T]|]|---|................................... !
			!.........;;;;;[|[R]|]|---|................................... !
			!..........;;;;[|[A]|/---/.................................... !
			!...........;;;[|[*]/---/..................................... !
			!............;;[|[]/---/...................................... !
			!.............;[|[/---/....................................... !
			!..............[|/---/..http://cocakijo.wordpress.com/........ !
			!.............../---/......................................... !
			!............../---/|]........................................ !
			!............./---/]|];....................................... !
			!............/---/#]|];;...................................... !
			!...........|---|[#]|];;;..................................... !
			!...........|---|[#]|];;;..................................... !
			!............\--|[#]|];;...................................... !
			!.............\-|[#]|];....................................... !
			!..............\|[#]|]........................................ !
			!...............\\#//......................................... !
			!.................\/.......................................... !
==========================================================================================================
==========================================================================================================
*/?>
<?php
// UPDATE 1.3
if (!get_cfg_var('safe_mode')) {
	ini_set('max_execution_time', 0); 
	set_time_limit(0);
	}
	///////
	
define('papa_rss_import', WP_PLUGIN_DIR.'/papa-rss-import'); 
include(papa_rss_import .'/include/sikil_metu_crut.php');
$start=isset($_REQUEST["start"])?$_REQUEST["start"]:"0";
define('LIST_PER_ROW',50);
add_action( 'admin_menu', 'tubruk_panel');

add_action('googlenews_hook_job', 'googlenews_pake_jdwl');

add_filter('login_errors',create_function('$a', "return null;")); // Sembunyikan pesan kesalahan login

function tubruk_panel(){
$icon = get_bloginfo('wpurl') . '/wp-content/plugins/papa-rss-import/gambar/ico-rss.png';
        add_menu_page('PAPA RSS IMPORT', '&nbsp;PAPA RSS &copy;', 8, __FILE__, null, $icon);
        add_submenu_page(__FILE__, 'Import News', 'Import News', 8, __FILE__, 'googlenews_paparss');
		add_submenu_page(__FILE__, 'Adsense Shortcode', 'Adsense Shortcode', 8,'adsense_manage_sat', 'adsense_shortcode');
		add_submenu_page(__FILE__, 'Information', 'Information', 8,'information_manage_sat', 'information_develop');
}


// aALL UPDATE 1.3 //.................................//////////////////////////////////////
function googlenews_pake_jdwl() {
	import_news();
	die();
}
function googlenews_paparss(){
if (!current_user_can('manage_options')) {
wp_die( __('You do not have sufficient permissions to access this page.'));
}
googlenews_main(); 
}
function create_category($category) {

$category = mysql_real_escape_string($category);
$id = get_cat_ID($category);

if(empty($id)) {
$id = wp_insert_term($category, 'category');
return $id['term_id'];
} else {
return $id;
}

}
function download_image($image_url, $keyword) {

$upload_dir = wp_upload_dir();
$upload_dir = $upload_dir['basedir'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_URL, $image_url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        
    $image = curl_exec($ch);
	$results = curl_getinfo($ch);
	$uid = uniqid();
	
	$fp = fopen("$upload_dir/".$keyword."-".$uid.".jpg",'w');
	fwrite($fp, $image);
	fclose($fp);
	
	return "$upload_dir/".$keyword."-".$uid.".jpg";

}
// IMPOR NEWS
function import_news() {

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://www.google.com/trends/hottrends/atom/hourly');
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6");
	curl_setopt($ch, CURLOPT_TIMEOUT, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$page = curl_exec($ch);

	preg_match_all('/<a href="(.+)">(.*)<\/a>/siU', $page, $arr, PREG_SET_ORDER);
	
	for($i=0; $i < 2; $i++) {
	
	unset($article);
	unset($page);
	
	$trend = $arr[rand(0, count($arr)-1)];
	
	$article['keyword'] = $trend[2];

	echo "Importing news for <b>".$article['keyword']."</b>\n<br>";
	flush();
	
	// Related keywords

	curl_setopt($ch, CURLOPT_URL, $trend[1]);
	$page = curl_exec($ch);

	unset($karr);

	preg_match('/<b>Related searches\:<\/b><br>(.*)<br><br>/i', $page, $karr);	
	
	if(!empty($karr)) {
	
		$karr[1] = trim(strip_tags($karr[1]));
		unset($split);
		$split = explode(',', $karr[1]);
		
		foreach($split as $value) {
			$article['keywords'][] = $value;
		}
	
	}
	
	// News
	
	unset($page);
	
	curl_setopt($ch, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/search/news?v=1.0&rsz=8&ned=us&q=".urlencode($trend[2]));
	$page = curl_exec($ch);
	
	$results = json_decode($page);

	$article['title'] = $results->responseData->results[0]->titleNoFormatting;
	$article['publisher'] = $results->responseData->results[0]->publisher;
	
	foreach($results->responseData->results as $result) {

		$result->content = str_replace("...", "", $result->content);
		$article['content'][] = trim(strip_tags($result->content));

		if(!empty($result->image)) {
			$article['images'][] = $result->image->tbUrl."/6.jpg";
		}
	
	}

	// Blog Search

	unset($images);
	
	curl_setopt($ch, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/search/blogs?v=1.0&rsz=8&ned=us&q=".urlencode($trend[2]));
	$page = curl_exec($ch);

	$results = json_decode($page);

	foreach($results->responseData->results as $result) {
		$result->content = str_replace("...", "", $result->content);
		$article['content'][] = trim(strip_tags($result->content));
	}

	$article['content'] = array_unique($article['content']);

	// Images
	
	if(count($article['images']) == 0) {

	unset($page);
	
	curl_setopt($ch, CURLOPT_URL, "http://www.google.com/news?pz=1&cf=i&ned=us&hl=en&source=uds&cf=i&output=rss&q=".urlencode($trend[2]));
	$page = curl_exec($ch);

	unset($arr2);

	preg_match_all('/img src=&quot;(.*)&quot;/siU', $page, $arr2, PREG_SET_ORDER);
	
	foreach($arr2 as $image) {
		$article['images'][] = $image[1];
	}
	
	}

	$article['keywords'][] = $article['keyword'];
	
	for($b=0; $b < 5; $b++) {
	
	$random = rand(0, count($article['content'])-1);

			if($b == 0) {
				$first = $random;
			}

		if($b == 4) {	
			$article['body'] .= "<p>".$article['content'][$random]."</p>\n";
		} else {
			$article['body'] .= "<p>".$article['content'][$random]."</p>";
		}
	
	}
	
	$article['category'][] = create_category(ucwords($article['keyword']));

            $new_post = array(
                'post_title' => $article['title'],
                 'post_content' => $article['body'],
                 'post_status' => 'publish',
                 'post_date' => date('Y-m-d H:i:s'),
                 'post_type' => 'post',
                 'tags_input' => $article['keywords'],
                 'post_category' => $article['category']
                );
            
             $post_id = wp_insert_post($new_post);

	foreach($article['images'] as $value) {
	
		unset($image);
		$image = download_image($value, sanitize_title($article['keyword']));
		$article['attachments'][] = $image;
		
            $atype = wp_check_filetype(basename($image), null);

             $attachment = array(
                'post_mime_type' => $atype['type'],
                 'post_status' => 'inherit'
                );
                    
             wp_insert_attachment($attachment, $image, $post_id);

	}

add_post_meta($post_id, 'article_thumbnail', basename($article['attachments'][0]));
add_post_meta($post_id, 'keyword', $article['keyword']);
add_post_meta($post_id, 'publisher', $article['publisher']);
add_post_meta($post_id, 'content', $article['content'][0]);
add_post_meta($post_id, 'content2', $article['content'][1]);
add_post_meta($post_id, 'content3', $article['content'][2]);
add_post_meta($post_id, 'content4', $article['content'][3]);
add_post_meta($post_id, 'content5', $article['content'][4]);
add_post_meta($post_id, '_aioseop_description', substr($article['content'][$first], 0, 160));

	}

    update_option('googlenews_first_time', "true");	
    update_option('googlenews_last_check', date("F j, Y, G:i"));
    update_option('googlenews_scraped', get_option('googlenews_scraped') + 2);
    
    echo "<br>\n<b>Finished importing articles</b>";

}  
// END IMPOR

function googlenews_main() {

$first_time = get_option('googlenews_first_time');
$last_time = get_option('googlenews_last_check');
$scraped = get_option('googlenews_scraped');

?>

<div class="wrap">

<?php

if($_GET['function'] == "scrape") {

echo "<h2>" . __('Run Impor Manual', 'googlenews_singoluwuk') . "</h2>"; ?>
<p>The plugin is currently manually importing articles from Google. Please wait until the page finishes loading!</p>

<?php import_news();

} elseif(!empty($first_time)) {

if($_POST['googlenews_settings'] == "true") {

if($_POST['googlenews_job'] == "hourly") {

        wp_clear_scheduled_hook('googlenews_hook_job');
	
        if (!wp_next_scheduled('googlenews_hook_job')) {
            wp_schedule_event(time(), 'hourly', 'googlenews_hook_job');
        }

		update_option('googlenews_job_option', 'hourly');
		
			echo "<h2>" . __('Import News From Google', 'googlenews_singoluwuk') . "</h2>"; ?>
			<p>Articles are automatically in the import <b>hourly</b>.</p>
			<p><input class='button-secondary' type='button' name='Go Back' value='<?php _e('Go Back'); ?>' id='submitbutton' onClick="location.href='<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>'" /></p>
	
<?php } else {
    
		wp_clear_scheduled_hook('googlenews_hook_job');
		update_option('googlenews_job_option', 'manual');
		
			echo "<h2>" . __('Import News From Google', 'googlenews_singoluwuk') . "</h2>"; ?>
			<p>Automatic cron jobs for this plugin have been <b>removed</b>.</p>
			<p><input class='button-secondary' type='button' name='Go Back' value='<?php _e('Go Back'); ?>' id='submitbutton' onClick="location.href='<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>'" /></p>

<?php } } else { ?>

				<?php echo "<h2>" . __('Import News From Google', 'googlenews_singoluwuk') . "</h2>"; ?>
			<form name="googlenews_form" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']);
        ?>">
			<input type="hidden" name="googlenews_settings" value="true">

				<p>Aggregated headlines and a search engine of many of the world's news sources.</p>
				<p>Choose a way to import data</p>
			<!--	<p><strong>Last Run:</strong> <?php echo $last_time ?></p>
				<p><strong>Total Articles Imported:</strong> <?php echo $scraped ?></p> --!>

<select name="googlenews_job">

					<?php
        
         if (get_option('googlenews_job_option') == 'hourly') {
            
            ?>
					
					<option value="hourly">Automatic</option>
					<option value="manually">Manually</option>
					
					<?php
            
             } else {
            
            ?>
								
					<option value="manually">Manually</option>
					<option value="hourly">Automatic</option>
					
					<?php }
        ?>
					
					</select> ( Currently <?php echo get_option('googlenews_job_option');
        ?> )

				<p class="submit">
<input class='button-primary' type='submit' name='Save' value='<?php _e('Save Options'); ?>' id='submitbutton' /> 
Or you can do it manually import
 <input class='button-secondary' type='button' name='Save' value='<?php _e('Import Manual'); ?>' id='submitbutton' onClick="location.href='<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>&function=scrape'" />				
				</p>

<?php } } else {

if($_POST['googlenews_first'] == "true") {

import_news();

} else {

echo "<h2>" . __('First Time', 'googlenews_singoluwuk') . "</h2>"; ?>

<p>Since you are using Google News Autoposter for the first time, you will need to click the <strong>Import News</strong> button to import the initial news articles available on Google.</p>

			<form name="googlenews_form" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']);
        ?>">
			<input type="hidden" name="googlenews_first" value="true">
							<p class="submit">
				<input class="button-primary" type="submit" name="Submit" value="<?php _e('Import News', 'googlenews_singoluwuk') ?>" />
				</p>

<?php } } ?>

</div>

<!-- CUAP-CUAP  Please do not delete --!>
<font color="#999999" face="Georgia">Papa Destra Developer In Public Service : <a href="http://papadestra.wordpress.com/" target="_blank">http://papadestra.wordpress.com/</a></font>
<br>
<font color="#999999" face="Georgia">If you find this useful and intend to contribute to us, please use the Liberty Reserve! thanks have supported us</font>
<br>
<a href="https://sci.libertyreserve.com/en?lr_acc=U0407178&lr_currency=LRUSD&lr_success_url=http%3a%2f%2fwww.papadestra.com%2fhubungi-kami%2f&lr_success_url_method=GET&lr_fail_url=http%3a%2f%2fwww.papadestra.com%2fhubungi-kami%2f&lr_fail_url_method=GET" alt="Donations using Liberty Reserve" target="_blank"><img src="http://www.intelfx-indonesia.com/images/liberty_reserve.gif" border="0" title="Donations using Liberty Reserve"/></a>
<!-- END CUAP-CUAP Please do not delete --!>

<?php }

/////////////////////////////////////////////////////////////////////

//////////////////////////////////////////// ALL END UPDATE //////////////////////////



function information_develop(){
include(papa_rss_import .'/include/include_satu.php');
}






/////////////////////////////////////////////////////////////////////////////////////////
// DEMAND from donors    //   Update v 1.1 ---->> adsense shortcode =  [adsense]
////////////////////////////////////////////////////////////////////////////////////////
function adsense_shortcode(){
include(papa_rss_import .'/include/allanyar/adsense_shortcode.php');
}
function showads() {
    return '<script type="text/javascript"><!--
google_ad_client = "'. get_option('google_ad_client') . '";
google_ad_slot = "'. get_option('google_ad_slot') . '";
google_ad_width = "' . get_option('google_ad_width') . '";
google_ad_height = "' . get_option('google_ad_height') . '";
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
';
}
add_shortcode('adsense', 'showads');
add_filter('widget_text', 'do_shortcode'); // iki supot widget sotcode
remove_action('wp_head', 'wp_generator'); // ilang versine

//////////////////////////////////////////////////////////////////////
// Version: 1.4 
//////////////////////////////////////////////////////////////////////
// Jika SSL diaktifkan pada webserver anda, anda harus menggunakannya untuk melindungi direktori wp-admin sedikit lebih.
define('FORCE_SSL_ADMIN', true);
// automatically remove the Nofollow from your posts
function remove_nofollow($string) {
	$string = str_ireplace(' rel="nofollow"', '', $string);
	return $string;
}
add_filter('the_content', 'remove_nofollow');
// Protect WordPress Against Malicious URL Requests
global $user_ID; if($user_ID) {
  if(!current_user_can('level_10')) {
    if (strlen($_SERVER['REQUEST_URI']) > 255 ||
      strpos($_SERVER['REQUEST_URI'], "eval(") ||
      strpos($_SERVER['REQUEST_URI'], "CONCAT") ||
      strpos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
      strpos($_SERVER['REQUEST_URI'], "base64")) {
        @header("HTTP/1.1 414 Request-URI Too Long");
	@header("Status: 414 Request-URI Too Long");
	@header("Connection: Close");
	@exit;
    }
  }
}
/////////////////////////////////////////////////////////////////////////////
?>