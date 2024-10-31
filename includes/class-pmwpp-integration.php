<?php

/**
 * Adds PmwppIntegration.
 */
class PmwppIntegration {

    private $api;

    private $selectedEventId;

    function __construct() {

        $plugin = new Pmwpp();
        $pluginOptions = get_site_option( $plugin->get_plugin_name() );

        if (isset($pluginOptions[ Pmwpp::OPTION_APIKEY ])) {

            $this->api = new PitchAndMatchApi($pluginOptions[ Pmwpp::OPTION_APIKEY ]);
        }

        if (isset($pluginOptions[ Pmwpp::OPTION_EVENTID ])) {

            $this->selectedEventId = $pluginOptions[ Pmwpp::OPTION_EVENTID ];
        }
    }

    function getServer() {

        return PitchAndMatchApi::SERVER;
    }

    function getEvents() {

        $result = array();

        if (isset($this->api) && $this->api instanceof PitchAndMatchApi) {

            $result = $this->api->getEvents();
        }

        return $result;
    }

    function getSelectedEventURL() {

        $result = array();

        if (
            isset($this->api) &&
            $this->api instanceof PitchAndMatchApi &&
            isset($this->selectedEventId)
        ) {

            $result = $this->api->getEvent($this->selectedEventId);
        }

        return $result;
    }

    function getEventAttendees() {

        $result = array();

        if (
            isset($this->api) &&
            $this->api instanceof PitchAndMatchApi &&
            isset($this->selectedEventId)
        ) {

            $result = $this->api->getEventAttendees($this->selectedEventId);
        }

        return $result;
    }

    function getEventCompanies() {

        $result = array();

        if (
            isset($this->api) &&
            $this->api instanceof PitchAndMatchApi &&
            isset($this->selectedEventId)
        ) {

            $result = $this->api->getEventCompanies($this->selectedEventId);
        }

        return $result;
    }

} // class PmwppIntegration