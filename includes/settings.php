<?php

function wa_register_settings() {
  
  // create a settings section
  add_settings_section( 'wa', 'Plugin Settings for WAETAG Plugin', 'wa_section_text', 'wa_settings' );
  
  // create new setting object: WAETAG post ID
  register_setting( 'wa_options', 'wa_post', 'wa_post_validate' );
  add_settings_field( 'wa_post', 'WAETAG Post Id', 'wa_post_callback', 'wa_settings', 'wa' );
}
add_action( 'admin_init', 'wa_register_settings' );

function wa_post_validate( $value ) {
  return $value;
}

function wa_post_callback() {
  $wa_post = get_option( 'wa_post' );
  echo '<input id="wa_post" name="wa_post" title="The post used to check if user is autorized to access to WAETAG user directory" type="text" value="' . $wa_post . '" />';
}

function wa_section_text() {
  echo '';
}

function wa_register_options_page() {
  add_options_page('WAETAG Settings', 'WAETAG', 'manage_options', 'wa', 'wa_options_page');
}

add_action( 'admin_menu', 'wa_register_options_page' );

function wa_options_page()
{
  ?>
    <h1>WAETAG Settings</h1>
    <form action="options.php" method="post">
      <?php
        settings_fields( 'wa_options' );
        do_settings_sections( 'wa_settings' );
      ?>
      <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
    </form>
  <?php
}