<?php
get_header();

$dc_suite_post = get_option( 'dc_suite_post' );

if (rcp_user_can_access( get_current_user_id(), $dc_suite_post )) {
    ?>
    <div class="dcsuite" id="dc-suite"></div>
    <?php
} else {
    ?>
    <p>You need a valid membership to access this content. Please <a href="<?php echo wp_login_url(); ?>">login</a> or <a href="<?php echo wp_registration_url(); ?>">register</a>.</p>
    <?php
}

get_footer();
?>
