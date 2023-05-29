<?php
/*
Plugin Name: CRUD Acreditaciones
Plugin URI: https://github.com/julianloaiza/Engix/tree/main/Plugin%20Acreditaciones
Description: El plugin "CRUD Acreditaciones" permite a los usuarios cargar, administrar y mostrar sus documentos de acreditación en su sitio web de WordPress.
Author: Julian Loaiza
Author URI: https://github.com/julianloaiza
Version: 1.0
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'crudac_plugin_base_URL', plugin_dir_url(__FILE__));
define( 'crudac_plugin_V', '1.0');
define( 'crud_plugin_role', 'engineer');


require_once 'shortcodes.php';

// Register Custom Post Type
function accreditations_crud_post_type() {

    $labels = array(
        'name'                  => _x( 'Acreditaciones', 'Post Type General Name', 'accreditation_crud_post_type' ),
        'singular_name'         => _x( 'Acreditación', 'Post Type Singular Name', 'accreditation_crud_post_type' ),
        'menu_name'             => __( 'Acreditaciones', 'accreditation_crud_post_type' ),
        'name_admin_bar'        => __( 'Acreditaciones', 'accreditation_crud_post_type' ),
        'archives'              => __( 'Archivos de Items', 'accreditation_crud_post_type' ),
        'attributes'            => __( 'Atributos de Item', 'accreditation_crud_post_type' ),
        'parent_item_colon'     => __( 'Item padre:', 'accreditation_crud_post_type' ),
        'all_items'             => __( 'Todos los Items', 'accreditation_crud_post_type' ),
        'add_new_item'          => __( 'Agregar Nuevo Item', 'accreditation_crud_post_type' ),
        'add_new'               => __( 'Agregar Nuevo', 'accreditation_crud_post_type' ),
        'new_item'              => __( 'Nuevo Item', 'accreditation_crud_post_type' ),
        'edit_item'             => __( 'Editar Item', 'accreditation_crud_post_type' ),
        'update_item'           => __( 'Actualizar Item', 'accreditation_crud_post_type' ),
        'view_item'             => __( 'Ver Item', 'accreditation_crud_post_type' ),
        'view_items'            => __( 'Ver Items', 'accreditation_crud_post_type' ),
        'search_items'          => __( 'Buscar Item', 'accreditation_crud_post_type' ),
        'not_found'             => __( 'No encontrado', 'accreditation_crud_post_type' ),
        'not_found_in_trash'    => __( 'No encontrado en la Papelera', 'accreditation_crud_post_type' ),
        'featured_image'        => __( 'Imagen Destacada', 'accreditation_crud_post_type' ),
        'set_featured_image'    => __( 'Establecer Imagen Destacada', 'accreditation_crud_post_type' ),
        'remove_featured_image' => __( 'Eliminar Imagen Destacada', 'accreditation_crud_post_type' ),
        'use_featured_image'    => __( 'Usar como Imagen Destacada', 'accreditation_crud_post_type' ),
        'insert_into_item'      => __( 'Insertar en el Item', 'accreditation_crud_post_type' ),
        'uploaded_to_this_item' => __( 'Subido a este Item', 'accreditation_crud_post_type' ),
        'items_list'            => __( 'Lista de Items', 'accreditation_crud_post_type' ),
        'items_list_navigation' => __( 'Navegación de la Lista de Items', 'accreditation_crud_post_type' ),
        'filter_items_list'     => __( 'Filtrar Lista de Items', 'accreditation_crud_post_type' ),
    );

    $args = array(
        'label'                 => __( 'Acreditaciones', 'accreditation_crud_post_type' ),
        'description'           => __( 'Post Type Description', 'accreditation_crud_post_type' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'author' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-feedback',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'page',
    );
    register_post_type( 'accreditation-crud', $args );

}
add_action( 'init', 'accreditations_crud_post_type', 0 );

// Ajax Handlr create/update
add_action( 'wp_ajax_accreditations_crud_servtag', 'accreditations_crud_servtag' );
add_action( 'wp_ajax_nopriv_accreditations_crud_servtag', 'accreditations_crud_servtag' );
function accreditations_crud_servtag() {
    $return = array('state'=>false);
    $post_ID = intval($_POST['accreditations-crud-servtag-editor']);
    $post_arr = array(
        'post_title'   => sanitize_text_field($_POST['servtag-title']),
        'post_content' => sanitize_text_field($_POST['servtag-content']),
        'post_status'  => 'publish',
        'post_author'  => $_POST['serv-uidd'],
        'post_type'    => 'accreditation-crud'
    );
    if ($post_ID > 0) {
        $return['state'] = true;
        $post_arr['ID'] = $post_ID;
        wp_update_post( $post_arr );
    }else{
        $return['state'] = true;
        $post_arr['ID'] = wp_insert_post( $post_arr );
    }

    $pluginPath = trailingslashit(plugin_dir_path(__FILE__));
    $target_dir = $pluginPath."base/";
    $uploadOk = 1;
    
    // Check if image file is a actual image or fake image
    if(!empty($_FILES["fileToUpload"]["name"])) {        
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // aqui ID para el nombre
        $target_file = $target_dir . 'accreditation-'.$post_arr['ID'].'.pdf';
        /*$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $saved = true;
        }
        */
        //var_dump($_FILES["fileToUpload"]["size"]);die;
        // Check if file already exists
        /*if (file_exists($target_file)) {
            //echo '<div class="notice notice-warning is-dismissible">Sorry, file already exists.</div>';
            $uploadOk = 0;
        }*/

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            //echo '<div class="notice notice-error is-dismissible">Sorry, your file is too large more than 500kb.</div>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "pdf"  ) {
            //echo  '<div class="notice notice-warning is-dismissible">Sorry, only XLS, XLSX files are allowed.</div>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
        //    echo '<div class="notice notice-error is-dismissible">Sorry, your file was not uploaded.</div>';
        // if everything is ok, try to upload file
        // } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $saved = true;
            } /*else {
               echo '<div class="notice notice-error is-dismissible">Sorry, there was an error uploading your file.</div>';
            }*/
        }
    }
    update_post_meta( $post_arr['ID'], '_accreditation_bussiness', $_POST['servtag-bussiness'] );
    update_post_meta( $post_arr['ID'], '_accreditation_date', $_POST['servtag-datein'] );
    //update_post_meta( $post_arr['ID'], '_accreditation_dateout', $_POST['servtag-dateout'] );
    wp_send_json($return);
}
// Ajax Handlr delete
add_action( 'wp_ajax_accreditations_crud_servtag_delete', 'accreditations_crud_servtag_delete' );
add_action( 'wp_ajax_nopriv_accreditations_crud_servtag_delete', 'accreditations_crud_servtag_delete' );
function accreditations_crud_servtag_delete() {
    $return = array('state'=>false);
    $author_id = get_post_field( 'post_author', $_POST['id'] );
    if ($author_id == $_POST['uidd']) {
        $return['state'] = true;
        $pluginPath = plugin_dir_path(__FILE__);
        $target_dir = $pluginPath.'base/accreditation-'.$_POST['id'].'.pdf';
        //var_dump($target_dir);die;
        unlink($target_dir);
        wp_delete_post( $_POST['id'] );
    }
    wp_send_json($return);
}
