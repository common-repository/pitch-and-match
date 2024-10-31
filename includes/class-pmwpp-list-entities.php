<?php

/**
 * Adds ListEntities widget.
 */
class PmwppListEntities extends WP_Widget {

    const ATTENDEES_LIST_TYPE_ID = "1";

    const COMPANIES_LIST_TYPE_ID = "2";

    const DEFAULT_LIST_ITEMS = 10;

    private $pluginName;

    /**
     * Register widget with WordPress.
     */
    function __construct() {

        $plugin = new Pmwpp();
        $this->pluginName = $plugin->get_plugin_name();

        parent::__construct(
            'list_entities', // Base ID
            esc_html__( 'Pitch and Match list', $this->pluginName ), // Name
            array( 'description' => esc_html__( 'Widget with a list of attendees or companies in the selected event.', $this->pluginName ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        echo $args['before_widget'];
        if ( ! empty( $instance['pmwpp_lstent_title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['pmwpp_lstent_title'] ) . $args['after_title'];

        }
        if ( ! empty( $instance['pmwpp_lstent_list_items'] ) ) {
            echo '<input type="hidden" id="listItems" value="' . $instance['pmwpp_lstent_list_items'] . '">';
        }
        $widgetIdSplitted = explode('-', $args['widget_id']);
        if ( count($widgetIdSplitted) > 1 ) {

            echo '<input type="hidden" id="instanceId" value="' . $widgetIdSplitted[1] . '">';
        }
        echo '<div class="list_spinner off"></div>';
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        $currentTitle = ! empty( $instance['pmwpp_lstent_title'] ) ? $instance['pmwpp_lstent_title'] : esc_html__( 'List of attendees', $this->pluginName );
        $currentListType = ! empty( $instance['pmwpp_lstent_list_type'] ) ? $instance['pmwpp_lstent_list_type'] : self::ATTENDEES_LIST_TYPE_ID;
        $currentListItems = ! empty( $instance['pmwpp_lstent_list_items'] ) ? $instance['pmwpp_lstent_list_items'] : self::DEFAULT_LIST_ITEMS;

        $listTypes = array(
            0 => array(
                'text' => esc_html__( 'Attendees', $this->pluginName ),
                'value' => self::ATTENDEES_LIST_TYPE_ID,
            ),
            1 => array(
                'text' => esc_html__( 'Companies', $this->pluginName ),
                'value' => self::COMPANIES_LIST_TYPE_ID,
            ),
        );

        include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-list-entities-form.php' );
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['pmwpp_lstent_title'] = ( ! empty( $new_instance['pmwpp_lstent_title'] ) ) ? strip_tags( $new_instance['pmwpp_lstent_title'] ) : '';
        $instance['pmwpp_lstent_list_type'] = ( ! empty( $new_instance['pmwpp_lstent_list_type'] ) ) ? strip_tags( $new_instance['pmwpp_lstent_list_type'] ) : '';
        $instance['pmwpp_lstent_list_items'] = ( ! empty( $new_instance['pmwpp_lstent_list_items'] ) ) ? strip_tags( $new_instance['pmwpp_lstent_list_items'] ) : '';

        return $instance;
    }

    public function display($instance) {

        $integration = new PmwppIntegration();
        $imagesBaseURL = $integration->getServer();

        if ($instance['pmwpp_lstent_list_type'] == self::ATTENDEES_LIST_TYPE_ID) {

            $itemList = $integration->getEventAttendees();

            if (count($itemList) > 0) {

                for ($index = 0; $index < count($itemList); $index++) {

                    if ($index % intval($instance['pmwpp_lstent_list_items']) == 0) {
                        if ($index != 0) {
                            echo '</div>';
                        }
                        echo '<div class="page">';
                    }

                    $item = $itemList[$index];

                    include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-attendee.php' );
                }
                echo '</div>';
            }
            else {
                include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-noattendees.php' );
            }
        }
        elseif ($instance['pmwpp_lstent_list_type'] == self::COMPANIES_LIST_TYPE_ID) {

            $itemList = $integration->getEventCompanies();

            if (count($itemList) > 0) {

                for ($index = 0; $index < count($itemList); $index++) {

                    if ($index % intval($instance['pmwpp_lstent_list_items']) == 0) {
                        if ($index != 0) {
                            echo '</div>';
                        }
                        echo '<div class="page">';
                    }

                    $item = $itemList[$index];

                    include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-company.php' );
                }
                echo '</div>';
            }
            else {
                include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-nocompanies.php' );
            }
        }
    }

    public function save_site_settings( $settings ) {

        $settings['_multiwidget'] = 1;
        update_site_option( $this->option_name, $settings );
    }

} // class ListEntities