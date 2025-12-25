<?php

function acf_load_color_field_choices( $field ) {


   // Reset choices
    $field['choices'] = array();

    // Check to see if Repeater has rows of data to loop over
    if( have_rows('gallery_filters', 'option') ) {
        
        // Execute repeatedly as long as the below statement is true
        while( have_rows('gallery_filters', 'option') ) {
            
            // Return an array with all values after the loop is complete
            the_row();
            
            
            // Variables
            $value = get_sub_field('category_name_clean');
            $label = get_sub_field('category_name');

            
            // Append to choices
            $field['choices'][ $value ] = $label;

        }
        
    }

    // Return the field
    return $field;
    
}

add_filter('acf/load_field/name=data_category', 'acf_load_color_field_choices');