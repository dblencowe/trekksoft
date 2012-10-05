<?php
/*
Plugin Name: TrekkSoft
Plugin URI: http://www.trekksoft.com
Description: This plugin allows you to integrate the TrekkSoft booking solution into your Wordpress site.
Version: 0.9.5
Author: TrekkSoft AG
Author URI: http://www.trekksoft.com
License: GPL2
*/

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
        $url = sprintf(
            'http://%s.trekksoft.%s/%s/api/public', 
            $this->getAccountName(),
            isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? 'dev' : 'com', 
            $this->getLanguage()
        );
        
        wp_register_script('trekksoft_api', $url);
        wp_enqueue_script('trekksoft_api');
    }
    

    /**
     * @param array|string $options
     */
    public function parseShortCode($options)
	{
        $options = shortcode_atts(
            array(
                'type'        => 'tours',
                'tour_id'     => 0,
                'category_id' => 0,
                'width'       => '720px',
                'height'      => '600px',
            ),
            $options
        );
        
        $id = 'trekksoft_' . mt_rand(1000, 9999);
        
        $code = <<<CODE
<div id="%s">Loading TrekkSoft booking engine, please wait ...</div>

<script>
    (function() {
        var iframe = new TrekkSoft.Embed.Iframe();
        iframe.setAttrib("width", "%s")
              .setAttrib("height", "%s")
              .setAttrib("entryPoint", "%s")
CODE;
        
        $args = array(
            $id,
            $options['width'],
            $options['height'],
        );
        
        switch ($options['type'])
        {
            case 'tours':
                $args[] = 'tours';
                break;
            
            case 'tour_booking':
                $code .= '              .setAttrib("tourId", %d)' . PHP_EOL;
                
                $args[] = 'tour';
                $args[] = $options['tour_id'];
                break;
            
            case 'shop':
                $args[] = 'shop';
                
                if ($options['category_id'] > 0) {
                    $code .= '              .setAttrib("categoryId", %d)' . PHP_EOL;
                    $args[] = $options['category_id'];
                }
                break;
            
            default:
                $args = false;
                break;
        }
        
        if ($args === false) {
            echo '<p>Failed to render the TrekkSoft smart code: The <code>type</code> option is invalid.</p>';
        } else {
            $code .= <<<CODE
              .render("#%s");
    })();
</script>
CODE;
            
            $args[] = $id;
            vprintf($code, $args);
        }
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