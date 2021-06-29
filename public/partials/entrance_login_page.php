<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Entrance
 * @subpackage Entrance/public/partials
 */
global $pagebg,$formbg;
?>
<style>
 body{
    background: linear-gradient(1deg, #E22B6E, #FC6266) !important;
 }
</style>
<div id="entranse_wrap">
    <div class="entrance_container">
        <div class="entrance_content">
            <div class="ent-form-contents" style="background: <?php echo $formbg; ?> !important">
                <?php
                $res = $this->entrance_login_access_by_form();
                if(!empty($res)){
                    echo '<div class="errors">';
                    echo '<span class="error-icon">⊘</span>';
                    echo '<p>'.$res.'</p>';
                    echo '</div>';
                }
                if(isset($_REQUEST['error'])){
                    echo '<div class="errors">';
                    echo '<span class="error-icon">⊘</span>';
                    echo '<p>'.ucfirst(str_replace('_',' ',$_REQUEST['error'])).'</p>';
                    echo '</div>';
                }
                ?>

                <div class="ent-header">
                    <p>Login with your social account</p>
                    <div class="sc-loginbtns">
                        <?php echo $this->entrance_social_login('g'); ?>
                        <?php echo $this->entrance_social_login('fb'); ?>
                    </div>
                    <div class="ordecoration">
                        <span class="beforeline"></span>
                        <span class="text">or</span>
                        <span class="afterline"></span>
                    </div>
                </div>

                <div class="ent-body">
                    <h1 class="loginheading">Login</h1>
                    <form action="" class="entranceform" method="post">
                        <div class="ent-form-g">
                            <input type="text" placeholder="Name" name="username" value="<?php echo (isset($_COOKIE['username'])?$_COOKIE['username']:'') ?>">
                        </div>
                        <div class="ent-form-g">
                            <input type="password" placeholder="Password" name="password" value="<?php echo (isset($_COOKIE['password'])?$_COOKIE['password']:'') ?>">
                        </div>
                        <div class="ent-form-g stay-login">
                            <label for="stay-login">
                                <input type="radio" name="stay_login" id="stay-login">
                                Stay Logged In
                            </label>
                        </div>
                        <button class="login-btn" type="submit" name="login_btn">Login</button>
                    </form>
                </div>
            </div>
            <div class="ent-already-link">
                <p>Don't have an account? <a href="<?php echo esc_url(get_page_link(get_option('entrance_registster_page','#'))) ?>">SIGN UP</a></p>
            </div>
        </div>
    </div>
</div>
