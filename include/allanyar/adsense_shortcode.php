<?
/*
    *   Waiver  — Any of the above conditions can be waived if you get permission from the copyright holder.
    * Public Domain — Where the work or any of its elements is in the public domain under applicable law, that status is in no way affected by the license.
    * Other Rights — In no way are any of the following rights affected by the license:
          o Your fair dealing or fair use rights, or other applicable copyright exceptions and limitations;
          o The author's moral rights;
          o Rights other persons may have either in the work itself or in how the work is used, such as publicity or privacy rights.
    * Notice — For any reuse or distribution, you must make clear to others the license terms of this work. The best way to do this is with a link to this web page.

*/
?>
<?php
echo'<font color="#666666" face="Georgia"><p>';
echo'<font face="Georgia"><h2>Adsense Setting</h2></font>';
echo'Perform the following settings and you can display adsense ads in which you want to display just by using a shortcode';

echo'<p>';
echo '<form method="post" action="options.php">';
    wp_nonce_field('update-options');	
	
echo '<b>google_ad_client</b>&nbsp;&nbsp;: <input type="text" name="google_ad_client" value="' . get_option('google_ad_client') . '" />&nbsp;&nbsp;<em>Examples : pub-3631232123124321</em><br/>';
echo '<b>google_ad_slot</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="google_ad_slot" value="' . get_option('google_ad_slot') . '" />&nbsp;&nbsp;<em>Examples : 4668915978 </em><br/>';
echo '<b>google_ad_width</b>&nbsp;&nbsp;: <input type="text" name="google_ad_width" value="' . get_option('google_ad_width') . '" />&nbsp;&nbsp;<em>Examples : 468 (numbers only)</em><br/>';
echo '<b>google_ad_height</b>&nbsp;: <input type="text" name="google_ad_height" value="' . get_option('google_ad_height') . '" />&nbsp;&nbsp;<em>Examples : 60 (numbers only)</em><br/>';
echo'</p>';

echo '<input type="hidden" name="action" value="update" />';
echo '<input type="hidden" name="page_options" value="google_ad_client,google_ad_slot,google_ad_width,google_ad_height" />';
echo '<p class="submit"><input type="submit" name="Submit" value="Save Changes" /></p>';

echo'<p>';
echo'To display ads, paste the following code on a post or widget <code>  [adsense]  </code>';
echo'</p>';
echo'</font>';

// sumbangan
?>
<!-- CUAP-CUAP  Please do not delete --!>
<font color="#999999" face="Georgia">Papa Destra Developer In Public Service : <a href="http://papadestra.wordpress.com/" target="_blank">http://papadestra.wordpress.com/</a></font>
<br>
<font color="#999999" face="Georgia">If you find this useful and intend to contribute to us, please use the Liberty Reserve! thanks have supported us</font>
<br>
<a href="https://sci.libertyreserve.com/en?lr_acc=U0407178&lr_currency=LRUSD&lr_success_url=http%3a%2f%2fwww.papadestra.com%2fhubungi-kami%2f&lr_success_url_method=GET&lr_fail_url=http%3a%2f%2fwww.papadestra.com%2fhubungi-kami%2f&lr_fail_url_method=GET" alt="Donations using Liberty Reserve" target="_blank"><img src="http://www.intelfx-indonesia.com/images/liberty_reserve.gif" border="0" title="Donations using Liberty Reserve"/></a>
<!-- END CUAP-CUAP Please do not delete --!>
<?

?>