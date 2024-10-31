<?php
include_once(ABSPATH . WPINC . '/rss.php'); // MENIKO KEDAH WONTEN, YEN ICAL MBOTEN MLAMPAH !!!!
add_theme_support('post-thumbnails');

/////////////////////////////
add_action( 'wp_footer', 'sikil_link_crut');
function sikil_link_crut(){
?>

<?php
}

////////////////////////////////////////////////////////////////////////////
// Secara otomatis menambahkan tombol Twitter dan Facebook untuk posting //
//////////////////////////////////////////////////////////////////////////
function share_this($content){
    if(!is_feed() && !is_home()) {
        $content .= '<div class="share-this">
                    <a href="http://twitter.com/share"
class="twitter-share-button"
data-count="horizontal">Tweet</a>
                    <script type="text/javascript"
src="http://platform.twitter.com/widgets.js"></script>
                    <div class="facebook-share-button">
                        <iframe
src="http://www.facebook.com/plugins/like.php?href='.
urlencode(get_permalink($post->ID))
.'&amp;layout=button_count&amp;show_faces=false&amp;width=200&amp;action=like&amp;colorscheme=light&amp;height=21"
scrolling="no" frameborder="0" style="border:none;
overflow:hidden; width:200px; height:21px;"
allowTransparency="true"></iframe>
                    </div>
                </div>';
    }
    return $content;
}
add_action('the_content', 'share_this');
////////////////////////////////////////////////////////////////////////////
// END -- otomatis menambahkan tombol Twitter dan Facebook untuk posting //
//////////////////////////////////////////////////////////////////////////




?>
