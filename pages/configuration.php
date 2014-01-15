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
                                            <label for="trekksoft_lang_en_AU" class="selectit">
                                                <input type="radio" id="trekksoft_lang_en_AU" name="trekksoft_lang" value="en_AU"<?php if ('en_AU' === $this->getLanguage()): ?> checked<?php endif; ?>>
                                                Australian English
                                            </label>
                                            <br>
                                            <label for="trekksoft_lang_de" class="selectit">
                                                <input type="radio" id="trekksoft_lang_de" name="trekksoft_lang" value="de"<?php if ('de' === $this->getLanguage()): ?> checked<?php endif; ?>>
                                                German
                                            </label>
                                            <br>
                                            <label for="trekksoft_lang_es" class="selectit">
                                                <input type="radio" id="trekksoft_lang_es" name="trekksoft_lang" value="es"<?php if ('es' === $this->getLanguage()): ?> checked<?php endif; ?>>
                                                Spanish
                                            </label>
                                            <br>
                                            <label for="trekksoft_lang_it" class="selectit">
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
                            <?php include dirname(__FILE__).'/../vendor/trekksoft/base-extension/about.html'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>