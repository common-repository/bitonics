<div class="wrap">

    <div class="cf_settings">

        <h1>Settings</h1>

        <form action="options.php" method="POST" id="bitonics-config">
            <?php settings_fields( 'bitonics_options_group' ); ?>

            <fieldset class="fieldset">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="bitonics_link"><?php _e( 'Bitonics link', 'bitonics' ); ?></label></th>
                        <td style="white-space: nowrap">
                            <input id="bitonics_link" name="bitonics_link" type="text" size="30" value="<?php echo get_option( 'bitonics_link' ); ?>" class="regular-text code">
                            <p class="description" id="tagline-description">Default: <?php echo BITONICS_LINK; ?></p>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <h2 class="title">Shortcode</h2>

            <fieldset class="fieldset">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="bitonics_shortcode_showcode"><?php _e( 'Show code', 'bitonics' ); ?></label></th>
                        <td style="white-space: nowrap">
                            <select id="bitonics_shortcode_showcode" name="bitonics_shortcode_showcode">
                                <?php
                                $bitonics_shortcode_showcode = get_option( 'bitonics_shortcode_showcode' );
                                ?>
                                <option <?php if ( $bitonics_shortcode_showcode == '0') { echo 'selected '; } ?>value="0"><?php _e( 'Disabled', 'bitonics' ); ?></option>';
                                <option <?php if ( $bitonics_shortcode_showcode == '1') { echo 'selected '; } ?>value="1"><?php _e( 'Enabled', 'bitonics' ); ?></option>';
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <?php submit_button(); ?>

        </form>

    </div>

</div>
