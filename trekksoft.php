<?php
/*
Plugin Name: TrekkSoft
Plugin URI: http://wordpress.org/extend/plugins/trekksoft
Description: This plugin allows you to integrate the TrekkSoft booking solution into your Wordpress site.
Version: 0.10.0
Author: TrekkSoft AG
Author URI: http://www.trekksoft.com
License: GPL2
*/
require dirname(__FILE__).'/vendor/autoload_52.php';

class TrekkSoft
{
    const OPTS_ACCOUNT_NAME = 'trekksoft_account';
    const OPTS_LANGUAGE     = 'trekksoft_lang';


    /**
     * @return string
     */
    public function getAccountName()
    {
        return (string)get_option(self::OPTS_ACCOUNT_NAME);
    }


    /**
     * @return string
     */
    public function getLanguage()
    {
        return (string)get_option(self::OPTS_LANGUAGE);
    }


    /**
     * Load the TrekkSoft JS API
     */
    public function onEnqueueScripts()
    {
        wp_register_script('trekksoft_api', $this->getTargetUrl());
        wp_enqueue_script('trekksoft_api');
    }

    public function getTargetUrl()
    {
        return '//'.$this->getHost().'/'.$this->getLanguage().'/api/public';
    }

    public function getHost()
    {
        return $this->getAccountName().'.trekksoft.'.($_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? 'dev' : 'com');
    }

    /**
     * @param array|string $options
     */
    public function parseShortCode($options)
	{
        $generator = new TrekkSoft_Widget_Generator();
        //var_dump($generator->getDefaultOptions());die();
        $options = shortcode_atts(
            $generator->getDefaultOptions()+array('language'=>$this->getLanguage()),
            $options
        );

        return $generator->generateEmbedCode($this->getHost(), $options);
	}


    /**
     * Renders the admin page, which shows a configuration form
     * and saves the settings.
     */
    public function renderAdminPage()
    {
        if (isset($_POST['trekksoft_account'])) {
            $account = $_POST['trekksoft_account'];
            update_option(self::OPTS_ACCOUNT_NAME, trim(strip_tags($account)));
        }
        
        if (isset($_POST['trekksoft_lang'])) {
            $lang = $_POST['trekksoft_lang'];
            update_option(self::OPTS_LANGUAGE, trim(strip_tags($lang)));
        }
        
        require dirname(__FILE__) . '/pages/configuration.php';
    }


    /**
     * Add admin menu on the 'admin_menu' hook
     */
    public function onAdminMenu()
    {
        add_menu_page(
            'TrekkSoft Settings',               // page title
            'TrekkSoft',                        // menu title
            1,                                  // capability
            'trekksoft',                        // menu slug
            array($this, 'renderAdminPage'),    // function
            '',                                 // icon url
            1337                                // position
        );
    }
}

$trekksoft = new TrekkSoft();
add_shortcode('trekksoft', array($trekksoft, 'parseShortCode'));
add_action('admin_menu', array($trekksoft, 'onAdminMenu'));
add_action('wp_enqueue_scripts', array($trekksoft, 'onEnqueueScripts'));