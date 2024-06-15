<?php

namespace WAETAG;

class RestAPI
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
        add_action('rest_api_init',  array($this, 'register_routes'));
    }

    public function register_routes() : void
    {
        //
    }
}