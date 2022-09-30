<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://yeasir.adaptstoday.co.uk/
 * @since      1.0.0
 *
 * @package    Asnf
 * @subpackage Asnf/admin
 */

 /**
 * The admin style
 * 
 * */
function admin_register_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/asnf-admin.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}
add_action('admin_head', 'admin_register_head');
 /**
 * The admin settings
 * 
 * */
function asnf_register_settings() {
	add_option( 'asnf_option_name', '');
	register_setting( 'asnf_options_group', 'asnf_option_name', 'asnf_callback' );
 }
 add_action( 'admin_init', 'asnf_register_settings' );

 function asnf_register_options_page() {
	add_options_page('Self activating nofollow', 'SANF Option', 'manage_options', 'asnf', 'asnf_options_page');
  }
  add_action('admin_menu', 'asnf_register_options_page');

 function asnf_options_page()
{
?>
  <div class="asnf_setingWrapper">
  <?php screen_icon(); ?>
  <h2>Nofollow All External Links</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'asnf_options_group' ); ?>  
  <p>If you want to add any extra attribute like "noopener" or "noreferrer" please add them in the below box and separate them by space.</p>
  <table>
  <tr valign="top">
  <th width="100px" scope="row"><label for="asnf_option_name">rel attribute</label></th>
  <td><input type="text" id="asnf_option_name" name="asnf_option_name" value="<?php echo get_option('asnf_option_name'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
} 


