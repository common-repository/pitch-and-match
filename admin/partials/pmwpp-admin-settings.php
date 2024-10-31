<div class="wrap <?php echo $this->pluginName; ?>">

    <h2><?php esc_html_e( 'Pitch and Match Widget', $this->pluginName); ?></h2>

    <form method="post" name="cleanup_options" class="pmwpp-form" action="options.php">

        <?php
        settings_fields($this->pluginName);
        do_settings_sections($this->pluginName);
        ?>

        <fieldset>
            <legend class="screen-reader-text"><span><?php esc_html_e( 'Pitch and Match Widget', $this->pluginName); ?></span></legend>

            <div class="field">
                <label for="<?php echo $this->pluginName . '-' . Pmwpp::OPTION_APIKEY; ?>">
                    <span><?php esc_html_e( 'API Key', $this->pluginName); ?></span>
                    <input type="text" id="<?php echo $this->pluginName . '-' . Pmwpp::OPTION_APIKEY; ?>"
                           name="<?php echo $this->pluginName . '[' . Pmwpp::OPTION_APIKEY . ']'; ?>"
                           data-value="<?php if(!empty($apikey)) echo $apikey; ?>"
                           value="<?php if(!empty($apikey)) echo $apikey; ?>" />
                </label>
            </div>
            <?php
            if (isset($apikey) && $apikey != null) {
                ?>
                <div class="field">
                    <label for="<?php echo $this->pluginName . '-' . Pmwpp::OPTION_EVENTID; ?>">
                        <span><?php esc_html_e( 'Event list', $this->pluginName); ?></span>
                        <select id="<?php echo $this->pluginName . '-' . Pmwpp::OPTION_EVENTID; ?>"
                                name="<?php echo $this->pluginName . '[' . Pmwpp::OPTION_EVENTID . ']'; ?>">
                            <?php
                            echo "<option>" . esc_html__( 'Select an event', $this->pluginName) . "</option>";

                            foreach ($eventsList as $thisEvent) {
                                echo '<option value="' . $thisEvent->id . '"' .
                                    ($eventid == $thisEvent->id ? " selected" : "") . '>' . $thisEvent->name . '</option>';
                            }
                            ?>
                        </select>
                    </label>
                </div>
                <?php
            }
            ?>
        </fieldset>

        <?php submit_button('Save all changes', 'primary','submit_form', TRUE); ?>

    </form>

</div>