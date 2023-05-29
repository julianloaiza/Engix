<?php
/**
 * Returns a user meta value
 * Usage [um_user user_id="" meta_key="" ] // leave user_id empty if you want to retrive the current user's meta value.
 * meta_key is the field name that you've set in the UM form builder
 * You can modify the return meta_value with filter hook 'um_user_shortcode_filter__{$meta_key}'
 */
add_action('template_redirect','sc_init_um_user_shortcode');
add_action('init','sc_init_um_user_shortcode');
function sc_init_um_user_shortcode(){
    add_shortcode( 'um_user', 'sc_um_user_shortcode' );
}

function sc_um_user_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'user_id' => get_current_user_id(),
        'meta_key' => ''
    ), $atts );
    extract( $atts );
    if ( ! $user_id || empty( $meta_key ) ) return;
    
    $raw_meta_value  = get_user_meta( $user_id, $meta_key, true );
    
    if( is_serialized( $raw_meta_value ) ){
       $meta_value = unserialize( $raw_meta_value );
    }else if( is_array( $raw_meta_value ) ){
         $meta_value = implode(",",$raw_meta_value);
    }else{
        $meta_value = $raw_meta_value;
    } 

    return apply_filters("um_user_shortcode_filter__{$meta_key}", $meta_value,  $raw_meta_value, $user_id );
 
}
/*
Usage: [um_user user_id="123" meta_key="cover_photo" ]
*/
add_filter("um_user_shortcode_filter__profile_photo","um_user_shortcode_filter__profile_photo", 10, 3);
function um_user_shortcode_filter__profile_photo( $meta_value,  $raw_meta_value, $user_id ){
    
   return  UM()->uploader()->get_upload_user_base_url( $user_id )."/".$meta_value; 
}
/*
Usage: [um_user user_id="123" meta_key="profile_photo" ]
*/
add_filter("um_user_shortcode_filter__cover_photo","um_user_shortcode_filter__cover_photo", 10, 3);
function um_user_shortcode_filter__cover_photo( $meta_value,  $raw_meta_value, $user_id ){
    
   return  UM()->uploader()->get_upload_user_base_url( $user_id )."/".$meta_value; 
}