<?php

/**
 * Adds CallToAction widget.
 */
class PmwppCallToAction extends WP_Widget {

    private $pluginName;

    /**
     * Register widget with WordPress.
     */
    function __construct() {

        $plugin = new Pmwpp();
        $this->pluginName = $plugin->get_plugin_name();

        parent::__construct(
            'call_to_action', // Base ID
            esc_html__( 'Pitch and Match call to action', $this->pluginName ), // Name
            array( 'description' => esc_html__( 'Widget with a button redirecting to the selected event page.', $this->pluginName ), ) // Args
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
        if ( ! empty( $instance['pmwpp_cta_title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['pmwpp_cta_title'] ) . $args['after_title'];
        }
        $this->display($instance);
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

        $title = ! empty( $instance['pmwpp_cta_title'] ) ? $instance['pmwpp_cta_title'] : esc_html__( 'New title', $this->pluginName );
        $buttonText = ! empty( $instance['pmwpp_cta_button_text'] ) ? $instance['pmwpp_cta_button_text'] : esc_html__( 'Button text', $this->pluginName );

        include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-call-to-action-form.php' );
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
        $instance['pmwpp_cta_title'] = ( ! empty( $new_instance['pmwpp_cta_title'] ) ) ? strip_tags( $new_instance['pmwpp_cta_title'] ) : '';
        $instance['pmwpp_cta_button_text'] = ( ! empty( $new_instance['pmwpp_cta_button_text'] ) ) ? strip_tags( $new_instance['pmwpp_cta_button_text'] ) : '';

        return $instance;
    }

    public function display($instance) {

        $endpoint = null;
        $buttonText = $instance['pmwpp_cta_button_text'];

        $integration = new PmwppIntegration();
        $event = $integration->getSelectedEventURL();

        if (isset($event->landing_page_url)) {

            $endpoint = $event->landing_page_url;
        }

        include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pmwpp-call-to-action-display.php' );
    }

    public function save_site_settings( $settings ) {

        $settings['_multiwidget'] = 1;
        update_site_option( $this->option_name, $settings );
    }

} // class CallToAction