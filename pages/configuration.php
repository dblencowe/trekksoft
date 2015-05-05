<form method="post" action="">
    <div class="wrap">
        <div style="float: right;">
            <img width="109" height="38" src="<?php echo WP_PLUGIN_URL . '/trekksoft/logo.png'; ?>" alt="TrekkSoft Logo" title="TrekkSoft Logo">
        </div>
        
        <h2>TrekkSoft Wordpress Plugin</h2>
        
        <?php if (isset($_POST['trekksoft_account']) || isset($_POST['trekksoft_primary_domain'])): ?>
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
                                    <tr>
                                        <td style="width: 110px;vertical-align:top;">Primary Domain:</td>
                                        <td style="vertical-align:top;">
                                            <input type="text" value="<?php echo $this->getPrimaryDomain(); ?>" id="trekksoft_primary_domain" tabindex="1" name="trekksoft_primary_domain" style="width: 200px;" placeholder="(e.g. www.my-domain.com)">
                                            <p>
                                                <strong>Attention:</strong>
                                                Enter the primary domain that is set up for your TrekkSoft website (leave out the http:// or https://). This domain will then be used to generate your widget and will act as the base domain for all links, buttons, etc...in your widget.
                                                If you enter a domain that is not set up for your TrekkSoft website then the widget will not work. We highly recommend that you use this option so long as you have at least one custom domain set up in your TrekkSoft website.
                                                You can check to see if a custom domain is set up for your TrekkSoft website by going to the "Manage Domains" section in the admin desk of your TrekkSoft website.
                                                If, however, you do not have a custom domain set up for your TrekkSoft website then leave this field empty and make sure to enter a value for the "TrekkSoft Account" field which can be found directly below.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 110px;vertical-align:top;">TrekkSoft Account:</td>
                                        <td style="vertical-align:top;">
                                            <input type="text" value="<?php echo $this->getAccountName(); ?>" id="trekksoft_account" tabindex="1" name="trekksoft_account" style="width: 200px;" placeholder="(e.g. my-trekksoft-slug)">.trekksoft.com
                                            <p>
                                                <strong>Attention:</strong>
                                                You should ONLY choose this option if you do NOT have a custom domain set up for your TrekkSoft website. In such a case you MUST leave the above "Primary Domain" field empty and be sure to enter a value here for your "TrekkSoft Account".
                                                The value entered here should be the slug of your TrekkSoft website. The slug is the subdomain part of the TrekkSoft URL without the rest of the url. So for example in example.trekksoft.com the slug part is "example".
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Language:</td>
                                        <td style="vertical-align:top;">
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