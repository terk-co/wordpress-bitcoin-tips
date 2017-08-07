<?php

class BitcointipsSettings {

  /**
   * Installs hooks
   */

  public function __construct() {
    add_action('admin_init', array($this, 'register_settings'));
    add_action('admin_menu', array($this, 'menu'));
  }

  /**
   * Defines Wordpress Admin menu item
   */
  
  public function menu() {
    add_options_page('Bitcoin Tips', 'Bitcoin Tips', 'manage_options', 'bitcointips', array($this, 'show_options_page'));
  }


  public function show_options_page() {
    if (!current_user_can('manage_options')) {
      wp_die(__('You do not have sufficient permissions to access this page.'));
  	}
  
    ?>
      <style type="text/css">
        .bitcointips-width { width: 100%; max-width: 600px; }
        .bitcointips-settings th { font-weight: bold; text-align: right; }
      </style>
    <?php
    echo '<div class="wrap bitcointips-settings">';
    screen_icon();
  	echo '<h2>Bitcoin Tips</h2>';
  	?>
  	<div style="width: 800px;">
      <p><strong>
        This plugin allows collecting bitcoin tips from WordPress blog readers. Every blog post gets its unique bitcoin address for tips.
        This allows for detailed stats of tips per post, so you know which texts your readers appreciate the most.
      </strong>
      </p>
      <p>
        The plugin requires that you use a BIP32/44 deterministic wallet and generates public keys based on xPub provided by you.
        This allows creating public keys your wallet without knowing your private keys. Only you are in control of all tips you receive.
      </p>
       The plugin uses Blockchain.info API to handle per-post address generation and for notifications on new tips (used for stats displayed on post pages and to send you email notifications).
       You will need to <a href="https://api.blockchain.info/customer/signup" target="_blank">apply for an API key at their website</a>a>.
      <p>
        Please be aware of a BIP44 issue. Most BIP44 wallets scan up to 20 unused keys. If you have more consecutive posts with no tips at all, you might not see tips received for newer posts in your wallet (after the 20 untipped posts gap). The Blockchain.info API (and the plugin) will stop generating new keys after a gap of 20 not-tipped addresses will be detected (and the plugin won't be displayed on these posts). You can increase this gap in the settings if you know how to handle it in your wallet. A simple workaround for this is to generate a new xPub and update it in the plugin settings when you are nearly reaching or have already reached the gap limit.
      </p>
      <p>
    	 Both plugin and Blockchain.info API are free to use, though <strong>if you like this plugin, donations are welcome in the form of tips on the
  	 <a href="<?php echo BITCOINTIPS_HOME_URL; ?>" target="_blank">plugin home page</a></strong>.
  	 </p>
    </div>
  	<?php
  	echo '<form method="post" action="options.php">';
  	settings_fields('bitcointips');
  	do_settings_sections('bitcointips');
  	submit_button();
  	echo '</form>';
  	echo '</div>';
  }

  /**
   * Adds settings field definition
   */

  protected function add_field($id, $label) {
    add_settings_field('bitcointips_' . $id, $label, array($this, 'show_field_' . $id), 'bitcointips', 'bitcointips');
    register_setting('bitcointips', 'bitcointips_' . $id);
  }

  /**
   * Defines field settings
   */
  
  public function register_settings() {
    add_settings_section('bitcointips', 'Your Bitcoin Tips Settings', array($this, 'show_settings'), 'bitcointips');
    $this->add_field('xpub', 'Your wallet xPub');
    $this->add_field('xpubgap', 'xPub gap allowed<br />(Advanced)');
    $this->add_field('biapikey', 'Blockchain.info API key');
    $this->add_field('label', 'Tip box label');
    $this->add_field('text', 'Tip box text');
    $this->add_field('stats', 'Show public stats');
    $this->add_field('pluginad', 'Display link to plugin home page');
    $this->add_field('notify', 'Email notifications');
    $this->add_field('email', 'Email address');
  }
  
  /**
   * Displays info above settings form
   */
  
  public function show_settings() {
    $configured = strlen(get_option('bitcointips_address'));
    if (!$configured) {
      echo '<p style="color: red; font-weight: bold;">Bitcoin Tips plugin is not configured yet. You need to provide your bitcoin address where all tips will be forwarded.</p>';
    }
  }

  /**
   * Displays address field 
   */
  
  public function show_field_address() {
    echo 
      '<input name="bitcointips_address" type="text" value="' . get_option('bitcointips_address') . '" size="34" /><br />',
      '<p class="description bitcointips-width">',
        '<strong>Important:</strong> If you change this address to a new one, only tips for posts created after the change ',
        'will be sent to the new address and tips for previous posts will still be sent the the previous address. ',
        'This will be changed in one of next versions.',
      '</p>'
    ;
  }
  
  public function show_field_biapikey() {
    echo 
      '<input name="bitcointips_biapikey" type="text" class="bitcointips-width" value="' . get_option('bitcointips_biapikey') . '"/><br />',
      '<p class="description bitcointips-width">',
        'Your Blockchain.info API key. <a href="https://api.blockchain.info/customer/signup" target="_blank">You can request it at their website</a>',
      '</p>'
    ;
  }
  
  public function show_field_xpub() {
    echo 
      '<input name="bitcointips_xpub" type="text" class="bitcointips-width" value="' . get_option('bitcointips_xpub') . '"/><br />',
      '<p class="description bitcointips-width">',
        '<strong>Important:</strong> If you change this address to a new one, only tips for posts created after the change ',
        'will be sent to the new xPub account and tips for previous posts will still be sent the the previous address. ',
      '</p>'
    ;
  }

  public function show_field_xpubgap() {
    $value = ((integer) get_option('bitcointips_xpubgap')) >= 20 ? (integer)get_option('bitcointips_xpubgap') : 20; 
    echo 
      '<input name="bitcointips_xpubgap" type="text" value="' . $value . '" size=4/><br />',
      '<p class="description bitcointips-width">',
        'New addresses won\'t be generated after you reach this number of unused addresses. Increase this number only if you understand BIP44 gap and how your wallet handles it',
      '</p>'
    ;
  }
  
  /**
   * Displays label field 
   */
  
  public function show_field_label() {
    $value = get_option('bitcointips_label', 'Like this post? Tip me with bitcoin!');
    echo '<input name="bitcointips_label" type="text" class="bitcointips-width" value="' . $value . '" />';
  }
  
  /**
   * Displays text field
   */
  
  public function show_field_text() {
    $default = 'If you enjoyed reading this post, please consider tipping me using Bitcoin. Each post gets its own unique Bitcoin address so by tipping you\'re not only making my continued efforts possible but telling me what you liked.';
    echo
      '<textarea name="bitcointips_text" class="bitcointips-width">' . get_option('bitcointips_text', $default) . '</textarea>',
      '<p class="description bitcointips-width">',
        'Optional text for the tip box. You can explain here what bitcoins are - if your readers might not know that - ',
        'or simply convince your readers why they should consider tipping you.',
      '</p>'
    ;
  }
  
  /**
   * Displays stats checkbox
   */
  
  public function show_field_stats() {
    echo
      '<p class="description bitcointips-width">',
        '<input name="bitcointips_stats" type="checkbox" style="margin-right: 10px;" ' . checked( 'on', get_option('bitcointips_stats', 'on'), false )  . ' />',
        'Displaying total sum, average value and number of tips for each post in the tipping widget.',
      '</p>'
    ;
  }
  
  /**
   * Displays plugin link checkbox
   */
  
  public function show_field_pluginad() {
    echo
      '<p class="description bitcointips-width">',
        '<input name="bitcointips_pluginad" type="checkbox" style="margin-right: 10px;" ' . checked( 'on', get_option('bitcointips_pluginad', 'on'), false )  . ' />',
        'If enabled, a short link to plugin home page is displayed in the tip box. ',
        'Leave this enabled if you want to support bitcoin and bitcoin tipping adoption. ',
      '</p>'
    ;
  }

  /**
   * Displays notify checkbox
   */
  
  public function show_field_notify() {
    echo
      '<p class="description bitcointips-width">',
        '<input name="bitcointips_notify" type="checkbox" style="margin-right: 10px;" ' . checked( 'on', get_option('bitcointips_notify', 'on'), false )  . ' />',
        'You will get email notification on each tip detected if this is turned on.',
      '</p>'
    ;
  }
  
  /**
   * Displays email address field 
   */
  
  public function show_field_email() {
    $value = get_option('bitcointips_email');
    if (!strlen($value)) {
      $current_user = wp_get_current_user();
      $value = $current_user->user_email;
    }
    echo 
      '<input name="bitcointips_email" type="text" value="' . $value . '" size="34" /><br />',
      '<p class="description bitcointips-width">',
        'Address to use for email notifications',
      '</p>'
    ;
  }
  
  
}

new BitcointipsSettings();