<form method="post" action="">
    <div class="wrap">
        <div style="float: right;">
            <img width="109" height="38" src="<?php echo WP_PLUGIN_URL . '/trekksoft/logo.png'; ?>" alt="TrekkSoft Logo" title="TrekkSoft Logo">
        </div>
        
        <h2>TrekkSoft Wordpress Plugin</h2>
        
        <?php if (isset($_POST['trekksoft_account'])): ?>
            <div class="update-nag">
                Successfully saved settings.
            </div>
        <?php endif; ?>
        
        <div id="poststuff" class="metabox-holder has-right-sidebar">
            <div class="inner-sidebar">
                <div class="postbox">
                    <h3 class="hndle"><span>Save</span></h3>
                    
                    <div class="inside">
                        <div id="publishing-action">
                            <input type="submit" value="Save Settings" accesskey="s" tabindex="2" id="save" class="button-primary" name="save">
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <div class="clear"></div>
                </div>
            </div>
            
            <div id="post-body">
                <div id="post-body-content">
                    <div class="stuffbox">
                        <h3><label for="trekksoft_account">Settings</label></h3>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                    <tr valign="top">
                                        <td style="width: 110px;">TrekkSoft Account:</td>
                                        <td>http://<input type="text" value="<?php echo $this->getAccountName(); ?>" id="trekksoft_account" tabindex="1" name="trekksoft_account" style="width: 200px;">.trekksoft.com</td>
                                    </tr>
                                    <tr valign="top">
                                        <td>Language:</td>
                                        <td>
                                            <label for="trekksoft_lang_en" class="selectit">
                                                <input type="radio" id="trekksoft_lang_en" name="trekksoft_lang" value="en"<?php if ('en' === $this->getLanguage()): ?> checked<?php endif; ?>>
                                                English
                                            </label>
                                            <br>
                                            <label for="trekksoft_lang_de" class="selectit">
                                                <input type="radio" id="trekksoft_lang_de" name="trekksoft_lang" value="de"<?php if ('de' === $this->getLanguage()): ?> checked<?php endif; ?>>
                                                German
                                            </label>
                                            <br>
                                            <label for="trekksoft_lang_de" class="selectit">
                                                <input type="radio" id="trekksoft_lang_es" name="trekksoft_lang" value="es"<?php if ('es' === $this->getLanguage()): ?> checked<?php endif; ?>>
                                                Spanish
                                            </label>
                                            <br>
                                            <label for="trekksoft_lang_de" class="selectit">
                                                <input type="radio" id="trekksoft_lang_it" name="trekksoft_lang" value="it"<?php if ('it' === $this->getLanguage()): ?> checked<?php endif; ?>>
                                                Italian
                                            </label>
                                            
                                            <p>
                                                <strong>Attention:</strong> The language must be active in your TrekkSoft account.
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>  
                    
                    <div class="stuffbox">
                        <h3>Use</h3>
                        
                        <div class="inside">
                            <p>Use the short code <code>trekksoft</code> to integrate an iframe on any of your pages.</p>
                            <p>The following options are available:</p>
                            
                            <table class="form-table">
                                <tbody>
                                    <tr valign="top">
                                        <td><strong><code>type</code></strong></td>
                                        <td>
                                            Must either be <code>tours</code> (tours overview), <code>tour_booking</code>
                                            (tour booking), <code>tour_details</code> (tour details) or <code>shop</code>
                                            (shop items overview).
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td><strong><code>tour_id</code></strong></td>
                                        <td>If <code>type</code> is <code>tour_booking</code>, this option must be the numeric ID of the tour you want to integrate.</td>
                                    </tr>
                                    <tr valign="top">
                                        <td><strong><code>category_id</code></strong></td>
                                        <td>If <code>type</code> is <code>shop</code>, this option can optionally be set to show a specific shop category.</td>
                                    </tr>
                                    <tr valign="top">
                                        <td><strong><code>referral</code></strong></td>
                                        <td>This option can optionally be set to associate made bookings with an agent. The expected value is the name of the agent.</td>
                                    </tr>
                                    <tr valign="top">
                                        <td><strong><code>width</code></strong></td>
                                        <td>
                                            Must be one of the following forms: <code>NUMpx</code> or <code>NUM%</code>, where <code>NUM</code> is a numeric value.
                                            A minimum width of 720 Pixels is recommended.
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td><strong><code>height</code></strong></td>
                                        <td>Must be one of the following forms: <code>NUMpx</code> or <code>NUM%</code>, where <code>NUM</code> is a numeric value.</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            
                            <p>
                                Example: <code>[trekksoft type="tour_booking" tour_id="4331" width="720px" height="800px" referral="john312"]</code>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>