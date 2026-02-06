<?php
defined('ABSPATH') or die('Not allowed');


$consentmanager_update_success = false;
$consentmanager_validation_error = false;
$consentmanager_error = false;

if (
    isset($_POST['submit']) &&
    isset($_POST['consent_manager_mode']) &&
    isset($_POST['consent_manager_id']) &&
    isset($_POST['consent_manager_code_id']) &&
    isset($_POST['_wpnonce']) &&
    wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), ConsentManagerMain::getAdminUrl()) &&
    check_admin_referer(ConsentManagerMain::getAdminUrl())
) {
    //      temporary deactivated until found perfomance solution for serverside blocking
//    $consentmanager_ignore_domains = isset($_POST['consent_manager_ignore_domains']) ? sanitize_text_field(wp_unslash($_POST['consent_manager_ignore_domains'])) : '';
    $consentmanager_mode = intval($_POST['consent_manager_mode']);
    $consentmanager_cmp_id = intval($_POST['consent_manager_id']);
    $consentmanager_cmp_code_id = sanitize_text_field(wp_unslash($_POST['consent_manager_code_id']));
    $consentmanager_host = isset($_POST['consent_manager_host']) ? sanitize_text_field(wp_unslash($_POST['consent_manager_host'])) : '';
    $consentmanager_cdn = isset($_POST['consent_manager_cdn']) ? sanitize_text_field(wp_unslash($_POST['consent_manager_cdn'])) : '';
    $consentmanager_hide_on_editor = isset($_POST['consent_manager_hide_on_editor']) ? intval($_POST['consent_manager_hide_on_editor']) : 0;

    try {
        update_option(ConsentManagerMain::getOptionID(), $consentmanager_cmp_id);
        update_option(ConsentManagerMain::getOptionCodeID(), $consentmanager_cmp_code_id);
        update_option(ConsentManagerMain::getOptionMode(), $consentmanager_mode);
        update_option(ConsentManagerMain::getHideOnEditor(), $consentmanager_hide_on_editor);
        update_option(ConsentManagerMain::getOptionHost(), $consentmanager_host);
        update_option(ConsentManagerMain::getOptionCDN(), $consentmanager_cdn);
        //temporary deactivated until found perfomance solution for serverside blocking
//        update_option(ConsentManagerMain::getOptionIgnoreDomains(), $consentmanager_ignore_domains);
    } catch (Exception $e) {
        $consentmanager_error = $e->getMessage();
    }
}

?>
<div class="wrap consentmanager_admin">
    <h1 id="logo">
        <img width="200px"
             src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/logo_neu.png', '__FILE__'); ?>"
             alt="consentmanager"/>
    </h1>

    <?php if ($consentmanager_error) : ?>
        <div>
            <p class="notice notice-error">
                <?php esc_html_e('The ID could not be saved. Please check your database and Wordpress version!', 'consent-manager'); ?>
            </p>
        </div>
    <?php endif; ?>
    <?php if ($consentmanager_validation_error) : ?>
        <div>
            <p class="notice notice-error">
                <?php echo esc_html($consentmanager_validation_error); ?>
            </p>
        </div>
    <?php endif; ?>
    <?php if ($consentmanager_update_success) : ?>
    <div>
    <p class="notice notice-success">
        <?php esc_html_e('Updated', 'consent-manager'); ?>
    </p>
</div>
<?php endif; ?>
<div clasS="wrapper">
    <div>
        <p><i>Please insert your consentmanager Credentials here:</i></p>

        <form method="post">

            <?php wp_nonce_field(ConsentManagerMain::getAdminUrl()); ?>

            <div class="consentmanager_flex">
                <div>
                    <label>CMP ID:</label>
                    <input placeholder="Example: 123456" type="text" name="consent_manager_id" id="consent_manager_id"
                           value="<?php echo intval(get_option(ConsentManagerMain::OPTION_ID, 0)); ?>"/>
                    <br>
                    <i>(consentmanager account => CMPs => get Code => ID)</i>
                </div>
                <img class="consentmanager_img"
                     src="<?php echo esc_url(plugin_dir_url(__DIR__) . '/assets/images/cmpid.png', '__FILE__'); ?>"
                     alt="CMP ID"/>
            </div>
            <hr>
            <div class="consentmanager_flex">
                <div>
                    <label>CMP Code-ID:</label>
                    <input placeholder="Example: asdf5hk783" type="text" name="consent_manager_code_id"
                           id="consent_manager_code_id"
                           value="<?php echo esc_attr(get_option(ConsentManagerMain::OPTION_CODEID, '')); ?>"/>
                    <br>
                    <i>(consentmanager account => CMPs => get Code => Code-ID)</i>
                </div>
                <img class="consentmanager_img"
                     src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/cmpcodeid.png', '__FILE__'); ?>"
                     alt="CMP Code ID"/>
            </div>
            <hr>
            <div class="consentmanager_flex">
                <div>
                    <label>Host:</label>
                    <input placeholder="Example: delivery.consentmanager.net" type="text" name="consent_manager_host"
                           id="consent_manager_host"
                           value="<?php echo esc_attr(get_option(ConsentManagerMain::OPTION_HOST, '')); ?>"/>
                    <br>
                    <i>(consentmanager account => CMPs => get Code => Host)</i>
                </div>
                <img class="consentmanager_img"
                     src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/cmphost.png', '__FILE__'); ?>"
                     alt="CMP host"/>
            </div>
            <hr>
            <div class="consentmanager_flex">
                <div>
                    <label>CDN:</label>
                    <input placeholder="Example: cdn.consentmanager.net" type="text" name="consent_manager_cdn"
                           id="consent_manager_cdn"
                           value="<?php echo esc_attr(get_option(ConsentManagerMain::OPTION_CDN, '')); ?>"/>
                    <br>
                    <i>(consentmanager account => CMPs => get Code => CDN)</i>
                </div>
                <img class="consentmanager_img"
                     src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/cmpcdn.png', '__FILE__'); ?>"
                     alt="CMP CDN"/>
            </div>
            <hr>
            <div class="consentmanager_flex">
                <div>
                    <label>Blocking Mode:</label>
                    <select name="consent_manager_mode" id="consent_manager_mode">
                        <option value="1" <?php echo intval(get_option(ConsentManagerMain::getOptionMode(), 0)) == 1 ? 'selected' : ''; ?>><?php esc_html_e('Automatic clientside blocking', 'consent-manager'); ?></option>
                        <option value="3" <?php echo intval(get_option(ConsentManagerMain::getOptionMode(), 0)) == 3 ? 'selected' : ''; ?>><?php esc_html_e('Semiautomatic Code', 'consent-manager'); ?></option>
                    </select>
                </div>
                <div>
                    <h4>Automatic Clientside</h4>
                    <p>Javascript based blocking of 3rd party scripts listed in your consentmanager account.</p>
                    <h4>Semiautomatic Clientside</h4>
                    <p>Blocks all scripts that you marked in your code.</p>
                    <a target="_blank"
                       href="https://help.consentmanager.net/books/cmp/page/how-to-block-third-party-codes-cookies-if-no-consent-is-given">Difference
                        between blocking modes</a>
                </div>
            </div>
            <hr>
            <div class="consentmanager_flex">
                <div>
                    <label for="consent_manager_hide_on_editor">Hide for logged-in users?</label>
                    <input value="1" type="checkbox" id="consent_manager_hide_on_editor"
                           name="consent_manager_hide_on_editor" <?php echo((intval(get_option(ConsentManagerMain::getHideOnEditor(), 0)) == 1) ? 'checked="checked"' : ''); ?>>
                </div>
            </div>

            <?php submit_button(); ?>

        </form>
        <div>
            <i>If you don’t yet have an ID, please get in touch with us at: <a target="_blank"
                                                                               href="mailto:support@consentmanager.net">support@consentmanager.net</a></i>
            <br>
            <a target="_blank"
               href="https://help.consentmanager.net/">consentmanager documentation & Help</a>
        </div>
    </div>
</div>