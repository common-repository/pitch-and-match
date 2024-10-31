<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'pmwpp_cta_title' ) ); ?>"><?php esc_html_e( 'Title:', $this->pluginName ); ?></label>
    <input class="widefat" type="text"
           id="<?php echo esc_attr( $this->get_field_id( 'pmwpp_cta_title' ) ); ?>"
           name="<?php echo esc_attr( $this->get_field_name( 'pmwpp_cta_title' ) ); ?>"
           value="<?php echo esc_attr( $title ); ?>">

    <label for="<?php echo esc_attr( $this->get_field_id( 'pmwpp_cta_button_text' ) ); ?>"><?php esc_html_e( 'Button text:', $this->pluginName ); ?></label>
    <input class="widefat" type="text"
           id="<?php echo esc_attr( $this->get_field_id( 'pmwpp_cta_button_text' ) ); ?>"
           name="<?php echo esc_attr( $this->get_field_name( 'pmwpp_cta_button_text' ) ); ?>"
           value="<?php echo esc_attr( $buttonText ); ?>">
</p>