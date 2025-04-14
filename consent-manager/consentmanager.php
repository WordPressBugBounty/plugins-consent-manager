<?php
defined('ABSPATH') or die('No rights!');

/*
Plugin Name: consentmanager Cookie Banner for Cookie Consent (Google Consent Mode and GDPR compliant Cookie Notice)
Description: The consentmanager Cookie Banner and Cookie Notice allows you to easily collect cookie consent from your website visitors, ensuring GDPR compliance.
Version: 3.1.0
Author: consentmanager
Author URI: https://www.consentmanager.net
License: GPL2
*/

require_once dirname(__FILE__) . '/ConsentManagerMain.php';

if (!function_exists('consentmanager_add_autoblocking')) {
    function consentmanager_add_autoblocking()
    {
        $cmpID = intval(get_option(ConsentManagerMain::getOptionID(), 0));
        $cmpCodeID = esc_attr(get_option(ConsentManagerMain::getOptionCodeID(), ''));

        $host = esc_attr(get_option(ConsentManagerMain::getOptionHost(), ''));
        if ($host == '') {
            $host = esc_attr(get_option(ConsentManagerMain::getHost(), 'delivery.consentmanager.net'));
        }
        $host = ConsentManagerMain::removeProtocol($host);

        $cdn = esc_attr(get_option(ConsentManagerMain::getOptionCDN(), ''));
        if ($cdn == '') {
            $cdn = esc_attr(get_option(ConsentManagerMain::getCDN(), 'cdn.consentmanager.net'));
        }
        $cdn = ConsentManagerMain::removeProtocol($cdn);

        if ($cmpCodeID != '') {
            $src = 'https://' . $cdn . '/delivery/autoblocking/' . $cmpCodeID . '.js';
        } else {
            $src = 'https://' . $cdn . '/delivery/autoblock/' . $cmpID . '.js';
        }

        if ($cmpCodeID == '') {
            $dataCmpID = 'data-cmp-id="' . $cmpID . '"';
        } else {
            $dataCmpID = '';
        }
        ?>
        <script type="text/javascript" src="<?php echo esc_url($src); ?>" data-cmp-ab="1"
                data-cmp-host="<?php echo $host; ?>"
                data-cmp-cdn="<?php echo $cdn; ?>"
                data-cmp-codesrc="10" <?php echo $dataCmpID ?>></script>
        <?php
    }
}

if (!function_exists('consentmanager_start_cmp')) {
    /**
     * starting consentmanager script logic
     */
    function consentmanager_start_cmp()
    {
        $cmpMode = 3; //semiautomatic default
        $hideOnEditor = 0;
        try {
            $cmpMode = intval(get_option(ConsentManagerMain::getOptionMode(), 0));
            $hideOnEditor = intval(get_option(ConsentManagerMain::getHideOnEditor(), 0));
        } catch (Exception $e) {
        }

        //Actions______________________________________________________________________________________________

        if (!is_admin() &&
            (!is_user_logged_in() || (is_user_logged_in() && $hideOnEditor === 0))) {
            if (function_exists('amp_is_request') && amp_is_request()) {
                //AMP Code
                add_action('wp_head', 'consentmanager_amp_script');
                add_action('after_body_open_tag', 'consentmanager_amp_body');
            } else if ($cmpMode === 1 || $cmpMode === 2) {

                add_action('wp_head', 'consentmanager_add_autoblocking', -9999);

            } else {

                /**  temporary deactivated until found perfomance solution for serverside blocking
                 *
                 * if ($cmpMode === 2) {
                 * //Serverside blocking
                 * add_action('after_setup_theme', 'consentmanager_bufferStart');
                 * add_action('shutdown', 'consentmanager_bufferEnd');
                 * }
                 */

                add_action('wp_print_scripts', 'consentmanager_semiblocking');
            }
        }
    }
}
add_action('wp', 'consentmanager_start_cmp');

if (!function_exists('consentmanager_semiblocking')) {
    /**
     * get semiautomatic blocking code
     */
    function consentmanager_semiblocking()
    {
        $cmpID = intval(get_option(ConsentManagerMain::getOptionID(), 0));
        $cmpCodeID = esc_attr(get_option(ConsentManagerMain::getOptionCodeID(), ''));
        $mode = intval(get_option(ConsentManagerMain::getOptionMode(), 0));
        $host = esc_attr(get_option(ConsentManagerMain::getOptionHost(), ''));
        if ($host == '') {
            $host = esc_attr(get_option(ConsentManagerMain::getHost(), 'delivery.consentmanager.net'));
        }
        $host = ConsentManagerMain::removeProtocol($host);

        $cdn = esc_attr(get_option(ConsentManagerMain::getOptionCDN(), ''));
        if ($cdn == '') {
            $cdn = esc_attr(get_option(ConsentManagerMain::getCDN(), 'cdn.consentmanager.net'));
        }
        $cdn = ConsentManagerMain::removeProtocol($cdn);

        if ($cmpID > 0 || $cmpCodeID != '') {
            //serverside automatic & clientside semi automatic
            if ($mode != 1) {
                echo ConsentManagerMain::getSemiBlockingCode($cmpID, $cmpCodeID, $host, $cdn);
            }
        }
    }
}


//Shortcodes__________________________________________________________________________________________________

if (!function_exists('consentmanager_vendorlist_shortcode')) {

    /**
     * Shortcode function to get vendorlist
     */
    function consentmanager_vendorlist_shortcode()
    {
        $cmpID = intval(get_option(ConsentManagerMain::getOptionID(), 0));
        $cmpCodeID = esc_attr(get_option(ConsentManagerMain::getOptionCodeID(), ''));
        $host = esc_attr(get_option(ConsentManagerMain::getOptionHost(), ''));
        if ($host == '') {
            $host = esc_attr(get_option(ConsentManagerMain::getHost(), 'delivery.consentmanager.net'));
        }

        if ($cmpCodeID != '') {
            $src = esc_url('https://' . $host . '/delivery/vendorlist.php?cdid=' . $cmpCodeID);
            return esc_html('<div id="cmpvendorlist"></div><script src="' . $src . '" type="text/javascript" async></script>');
        } else if ($cmpID > 0) {
            $src = esc_url('https://' . $host . '/delivery/vendorlist.php?id=' . $cmpID);
            return esc_html('<div id="cmpvendorlist"></div><script src="' . $src . '" type="text/javascript" async></script>');
        }
    }
}
add_shortcode('consentmanager_vendors', 'consentmanager_vendorlist_shortcode');

if (!function_exists('consentmanager_cookie_list_shortcode')) {

    /**
     * Shortcode function to get cookielist
     */
    function consentmanager_cookie_list_shortcode()
    {
        $cmpID = intval(get_option(ConsentManagerMain::getOptionID(), 0));
        $cmpCodeID = esc_attr(get_option(ConsentManagerMain::getOptionCodeID(), ''));
        $host = esc_attr(get_option(ConsentManagerMain::getOptionHost(), ''));
        if ($host == '') {
            $host = esc_attr(get_option(ConsentManagerMain::getHost(), 'delivery.consentmanager.net'));
        }

        if ($cmpCodeID != '') {
            $src = esc_url('https://' . $host . '/delivery/cookieinfo.php?cdid=' . $cmpCodeID);
            return esc_html('<div id="cmpcookieinfo"></div><script src="' . $src . '" type="text/javascript" async></script>');
        } else if ($cmpID > 0) {
            $src = esc_url('https://' . $host . '/delivery/cookieinfo.php?id=' . $cmpID);
            return esc_html('<div id="cmpcookieinfo"></div><script src="' . $src . '" type="text/javascript" async></script>');
        }
    }
}
add_shortcode('consentmanager_cookies', 'consentmanager_cookie_list_shortcode');

//Admin area_______________________________________________________________________________________

/** Add Settings button to plugin overview page */
if (!function_exists('consentmanager_admin_action_links')) {

    /**
     * Add Buttons and links to Admin page
     * @param $links
     * @param $file
     * @return mixed|void
     */
    function consentmanager_admin_action_links($links, $file)
    {
        if (!current_user_can('edit_posts')) {
            return;
        }
        static $my_plugin;
        if (!$my_plugin) {
            $my_plugin = plugin_basename(__FILE__);
        }
        if ($file == $my_plugin) {
            $settings_link = '<a href="/wp-admin/admin.php?page=' . ConsentManagerMain::getAdminUrlConst() . '">Settings</a>';
            array_unshift($links, $settings_link);
        }
        return $links;
    }
}
add_filter('plugin_action_links', 'consentmanager_admin_action_links', 10, 2);

if (!function_exists('consentManager_display_admin_page')) {
    /**
     * Display view
     */
    function consentManager_display_admin_page()
    {
        if (!current_user_can('edit_posts')) {
            return;
        }
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        include_once 'views/admin.php';
    }
}

if (!function_exists('consentmanager_admin_menu')) {

    /**
     * Add left main menu item
     */
    function consentmanager_admin_menu()
    {
        if (is_admin() && current_user_can('edit_posts')) {
            add_menu_page('consentmanager options', 'consentmanager', 'manage_options', ConsentManagerMain::getAdminUrlConst(), 'consentManager_display_admin_page', '/wp-content/plugins/consent-manager/assets/images/logo20.png', 80);
        }
    }
}
add_action('admin_menu', 'consentmanager_admin_menu');

if (!function_exists('consentmanager_admin_register_head')) {
    function consentmanager_admin_register_head()
    {
        $url = esc_url(plugin_dir_url(__FILE__) . 'assets/css/admin.css', '__FILE__');

        wp_register_style('consentmanager_wp_admin_css', $url, false, '1.0.0');
        wp_enqueue_style('consentmanager_wp_admin_css');
    }
}
add_action('admin_enqueue_scripts', 'consentmanager_admin_register_head');

//AMP Functions______________________________________________________________________________________

if (!function_exists('consentmanager_amp_script')) {
    /**
     * AMP Head injection
     */
    function consentmanager_amp_script()
    {
        ?>
        <script async custom-element="amp-consent" src="https://cdn.ampproject.org/v0/amp-consent-0.1.js"></script>
        <meta name="amp-consent-blocking" content="amp-ad">
        <?php
    }
}

if (!function_exists('consentmanager_amp_body')) {
    /**
     * AMP Bodx injection
     */
    function consentmanager_amp_body()
    {
        ?>
        <amp-consent id="ConsentManager" layout="nodisplay" type="ConsentManager">
            <script type="application/json">
    {
     "postPromptUI": "postPromptUI",
     "clientConfig": {
      "id": "<?php echo intval(get_option(ConsentManagerMain::getOptionID(), 0)) ?>",
      "params": ""
     }
    }



















            </script>
            <div id="postPromptUI">
                <button on="tap:ConsentManager.prompt()" role="button">Manage privacy settings</button>
            </div>
        </amp-consent>
        <?php
    }
}

//Serverside blocking________________________________________________________________________________________

/**  temporary deactivated until found perfomance solution for serverside blocking
 *
 * /**
 * manipulate output buffer to block JS serverside
 * @param $buffer
 * @return array|mixed|string|string[]
 *
 * function consentmanager_callbackForBuffer($buffer)
 * {
 * $id = '';
 * $ignoreDomains = '';
 * try {
 * $id = esc_attr(get_option(ConsentManagerMain::getOptionID()));
 * $ignoreDomains = esc_attr(get_option(ConsentManagerMain::getOptionIgnoreDomains()));
 * } catch (Exception $e) {
 * }
 *
 * $_buffer = $buffer;
 * //caching -> 1Tag
 * $cache_file = $id . '.js';
 * $url = 'https://' . ConsentManagerMain::getHost() . '/delivery/customblocking/' . $id . '.js';
 *
 * $file = file_get_contents($url);
 * $blocking = json_decode($file);
 *
 * //scripts
 * preg_match_all('#<script(.*?)</script>#is', $_buffer, $matches);
 * foreach ($matches[0] as $value) {
 * $_v = $value;
 * $src = ConsentManagerMain::getUrlFromString($value);
 * if ($src != '') {
 * $_v = consentmanager_changeElements('script', $value, $src, $blocking, $ignoreDomains);
 * }
 *
 * // modify buffer here, and then return the updated code
 * $_buffer = str_replace($value, $_v, $_buffer);
 * }
 *
 * //iframes
 * preg_match_all('#<iframe(.*?)</iframe>#is', $_buffer, $matches);
 * foreach ($matches[0] as $value) {
 * $_v = $value;
 * $src = ConsentManagerMain::getUrlFromString($value);
 * if ($src != '') {
 * $_v = consentmanager_changeElements('iframe', $value, $src, $blocking, $ignoreDomains);
 * }
 *
 * // modify buffer here, and then return the updated code
 * $_buffer = str_replace($value, $_v, $_buffer);
 * }
 * return $_buffer;
 * }
 */

/**
 * @param $type
 * @param $val
 * @param $src
 * @param $blocking
 * @param $ignoreDomains
 * @return array|string|string[]
 *
 * function consentmanager_changeElements($type, $val, $src, $blocking, $ignoreDomains)
 * {
 * if (strpos($val, 'class="') !== false) {
 * $val = str_replace('class="', 'class="cmplazyload ', $val);
 * } else {
 * $val = str_replace('<' . $type, '<' . $type . ' class="cmplazyload"', $val);
 * }
 * $domain = ConsentManagerMain::getDomainFromUrl($src);
 * foreach ($blocking as $key => $b) {
 * if (strpos($domain, $b->d) !== false && strpos($ignoreDomains, $b->d) === false) {
 * $r = '<' . $type . ' data-cmp-vendor="' . $b->v . '"';
 * $val = str_replace('<' . $type, $r, $val);
 * $val = str_replace('src', 'data-cmp-src', $val);
 * break;
 * }
 * if ($key === count($blocking)) {
 * ConsentManagerMain::sendUnblockedDomainInfo($domain, (int)get_option(ConsentManagerMain::getOptionID()));
 * }
 * }
 *
 * return $val;
 * }
 */

/**
 * Check when HTML is completely build
 *
 * function consentmanager_bufferStart()
 * {
 * ob_start("consentmanager_callbackForBuffer");
 * }
 */

/**
 * Flush Output stream
 *
 * function consentmanager_bufferEnd()
 * {
 * if (ob_get_length()) {
 * ob_end_flush();
 * }
 * }
 */
