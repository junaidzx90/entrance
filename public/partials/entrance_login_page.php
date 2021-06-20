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
?>

<div id="entranse_wrap">
    <div class="entrance_container">
        <div class="entrance_content">
            <div class="ent-form-contents">
                <?php
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
                            <input type="text" placeholder="Name" name="" class="">
                        </div>
                        <div class="ent-form-g">
                            <input type="password" placeholder="Password" name="" class="">
                        </div>
                        <div class="ent-form-g stay-login">
                            <label for="stay-login">
                                <input type="radio" name="stay-login" id="stay-login">
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