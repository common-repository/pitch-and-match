<div class="user-manual">

    <h3><?php esc_html_e( 'User manual', $this->pluginName); ?></h3>

    <h4><?php esc_html_e( 'Mandatory settings', $this->pluginName); ?></h4>

    <p>
        <?php _e(
            'You can access this settings by clicking on the Settings link in the plugin list or by going to the sidebar menu (Settings > Pitch and Match).<br><br>' .
            'Directly after the plugin is installed, you need to fill in the API Key, given to you by Pitch and Match and click the “Save all changes” button. To get the key go to <a href="http://www.pitchandmatch.com" target="_blank">www.pitchandmatch.com</a>, Login and go to My Profile > Your account.<br><br>' .
            'Then the list of your events from your account in Pitch and Match appears: you need to select one of the events in that list, in order to use the widgets in your Wordpress.<br><br>' .
            'Now you are good to go.'
            , $this->pluginName); ?>
    </p>

    <h4><?php esc_html_e( 'Widgets', $this->pluginName); ?></h4>

    <p>
        <?php _e(
            'To use the widgets go to Appearance >Widgets in the sidebar.<br><br>' .
            'This plugin gives you the opportunity to use two kinds of widgets: the first one allows you to display a button that redirects to the previously selected event, and the second one displays a list of attendees or companies of the previously selected event.<br><br>' .
            'You just need to drag and drop one of the widgets to one of the available areas (these areas could be different depending on the theme you have installed). Then you set the options of that particular instance and click “Save”.'
        , $this->pluginName); ?>
    </p>

    <h4><?php esc_html_e( 'Shortcodes', $this->pluginName); ?></h4>

    <p>
        <?php _e(
            'If you have installed a shortcode API plugin to use your widgets in posts and pages, you can combine the Pitch and Match plugin with it and achieve custom layouts with your lists and call to action buttons.'
            , $this->pluginName); ?>
    </p>

</div>