<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'pmwpp_lstent_title' ) ); ?>"><?php esc_html_e( 'Title:', $this->pluginName ); ?></label>
    <input type="text" class="widefat"
           id="<?php echo esc_attr( $this->get_field_id( 'pmwpp_lstent_title' ) ); ?>"
           name="<?php echo esc_attr( $this->get_field_name( 'pmwpp_lstent_title' ) ); ?>"
           value="<?php echo $currentTitle; ?>">

    <label for="<?php echo esc_attr( $this->get_field_id( 'pmwpp_lstent_list_type' ) ); ?>"><?php esc_html_e( 'List type:', $this->pluginName ); ?></label>
    <select class="widefat attendees"
            id="<?php echo esc_attr( $this->get_field_id( 'pmwpp_lstent_list_type' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'pmwpp_lstent_list_type' ) ); ?>" >

        <?php foreach ($listTypes as $thisListType) { ?>

            <option
                    value="<?php echo $thisListType['value']; ?>"
                <?php echo ($currentListType == $thisListType['value'] ? " selected" : ""); ?>>
                <?php echo $thisListType['text']; ?></option>

        <?php } ?>

    </select>

    <input type="hidden" id="titleForAttendees" value="<?php esc_html_e( 'List of attendees', $this->pluginName ); ?>">
    <input type="hidden" id="titleForCompanies" value="<?php esc_html_e( 'List of companies', $this->pluginName ); ?>">

    <label for="<?php echo esc_attr( $this->get_field_id( 'pmwpp_lstent_list_items' ) ); ?>"><?php esc_html_e( 'List items:', $this->pluginName ); ?></label>
    <input type="text" class="widefat"
           id="<?php echo esc_attr( $this->get_field_id( 'pmwpp_lstent_list_items' ) ); ?>"
           name="<?php echo esc_attr( $this->get_field_name( 'pmwpp_lstent_list_items' ) ); ?>"
           value="<?php echo $currentListItems; ?>">
</p>