<?php

namespace WAETAG;

class Waetag
{
    private static $instance;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        // Schedule the cron event when the plugin is activated
        register_activation_hook(__FILE__, array($this, 'activate_plugin'));
        // Remove the cron event when the plugin is deactivated
        register_deactivation_hook(__FILE__, array($this, 'deactivate_plugin'));
        // Hook the cron event to run your function
        add_action('wa_cron_event', array($this, 'update_all_bp_usermeta'));
    }

    public function activate_plugin()
    {
        if (!wp_next_scheduled('wa_cron_event')) {
            wp_schedule_event(time(), 'daily', 'wa_cron_event');
        }
    }

    public function deactivate_plugin()
    {
        // Unschedule the cron event when the plugin is deactivated
        wp_clear_scheduled_hook('wa_cron_event');
    }

    public function update_all_bp_usermeta() : void
    {
        // Get all user IDs
        $user_ids = get_users(array('fields' => 'ID'));
        // Loop through each user ID and update BuddyPress user meta
        foreach ($user_ids as $user_id) {
            $this->update_bp_usermeta($user_id);
        };
    }

    public function update_bp_usermeta($user_id) : void
    {
        // Check if user ID is valid
        if ($user_id > 0) {
            try {
                // get memberpress field values
                $school_name = get_user_meta($user_id, 'mepr_school_name', true);
                $school_district = get_user_meta($user_id, 'mepr_school_district', true);
                $job_title = get_user_meta($user_id, 'mepr_what_titles_is_the_most_appropriate_for_you_select_all_that_apply', true);

                // move memberpress field values to BuddyPress table
                if (function_exists('xprofile_set_field_data')) {
                    xprofile_set_field_data(42, $user_id, $school_name);
                    xprofile_set_field_data(43, $user_id, $school_district);
                    xprofile_set_field_data(44, $user_id, $job_title);
                }

                error_log('Cron job - update_bp_usermeta - ran for user ' . $user_id . ' at ' . date('Y-m-d H:i:s'));
            } catch (\Exception $e) {
                // Fail silently
                error_log('Error updating BP user meta for user ' . $user_id . ': ' . $e->getMessage());
            }
        }
    }
}
