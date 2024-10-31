<?php

/**
 * Adds PmwppSettings.
 */
class PmwppSettings {

    private $pluginName;

    function __construct($pluginName) {

        $this->pluginName = $pluginName;
    }

    public function display() {

        $integration = new PmwppIntegration();
        $eventsList = $integration->getEvents();
        $options = get_site_option($this->pluginName);
        $apikey = $options[ Pmwpp::OPTION_APIKEY ];
        $eventid = $options[ Pmwpp::OPTION_EVENTID ];

        include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-admin-settings.php' );
        include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-admin-user-manual.php' );
    }

}