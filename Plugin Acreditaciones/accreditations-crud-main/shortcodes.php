<?php
function accreditations_crud( $atts ) {
    global $wpdb;
    //$timezone_string = get_option( 'timezone_string' );
    //date_default_timezone_set($timezone_string);
    $a = shortcode_atts( array(
        'type' => 'now',
        'scale' => '0',
    ), $atts );
    
    wp_register_script('accreditations_crud-select2-script-frontend', crudac_plugin_base_URL .'select2.min.js?v='.crudac_plugin_V);
    wp_enqueue_script('accreditations_crud-select2-script-frontend');
    wp_register_script('accreditations_crud-script-frontend', crudac_plugin_base_URL .'frontend.js?v='.crudac_plugin_V);
    wp_enqueue_script('accreditations_crud-script-frontend');
    wp_register_style('accreditations_crud-select2-style-frontend', crudac_plugin_base_URL .'select2.min.css?v='.crudac_plugin_V);
    wp_enqueue_style('accreditations_crud-select2-style-frontend');
    wp_register_style('accreditations_crud-style-frontend', crudac_plugin_base_URL .'frontend.css?v='.crudac_plugin_V);
    wp_enqueue_style('accreditations_crud-style-frontend');
    ob_start();
    $profile_id = um_profile_id();
    $result = um_get_requested_user();
    $user = wp_get_current_user();
    $profile_id = um_profile_id();
    $maxDate = date('Y-m-d');
    $roles = ( array ) $user->roles;
    ?>
    <div class="accreditations-crud-wrap">
        <div class="accreditations-crud-list-accreditations">
            <?php
            $the_query = new WP_Query( array(
                'author__in'=> array($result),
                'post_type' => 'accreditation-crud',
                'post_status' => 'publish',
                'posts_per_page' => '-1'
            ));

            while ( $the_query->have_posts() ) :
               $the_query->the_post();
               $post_ID = get_the_ID();
               $author_id = get_post_field( 'post_author', $post_ID );
               $accreditation_bussiness = get_post_meta( $post_ID, '_accreditation_bussiness', true );
               $accreditation_datein = get_post_meta( $post_ID, '_accreditation_date', true );

               $accreditation_file = '';
               $pluginPath = plugin_dir_path(__FILE__);
               $target_dir = $pluginPath.'base/accreditation-'.$post_ID.'.pdf';
               if (file_exists($target_dir)) {
                   $accreditation_file = '<a target="_blank" class="crud-link" href="'.plugin_dir_url(__FILE__).'base/accreditation-'.$post_ID.'.pdf">
                   '.sanitize_title(get_the_title()).'.pdf
                   </a>';
               }
               //get_post_meta( $post_ID, '_accreditation_dateout', true );
            ?>
            <div class="accreditations-crud-list-accreditations-el accreditations-crud-box">
                <div class="accreditations-crud-list-accreditations-el-header">
                    <div class="accreditations-crud-categories">
                       
                    </div>
                    <?php if($profile_id == $user->ID && in_array(crud_plugin_role, $roles)): ?>
                    <div>
                        <a href="#delete" data-servtag="<?php echo $post_ID; ?>" data-uidd="<?php echo $result; ?>" class="accreditations-crud-link accreditations-crud-delete">Eliminar</a>
                        <a href="#edit" data-servtag="<?php echo $post_ID; ?>" class="accreditations-crud-edit-service-btn accreditations-crud-link accreditations-crud-edit"
                            data-title="<?php echo ucfirst(get_the_title()); ?>"
                            data-bussiness="<?php echo $accreditation_bussiness; ?>"
                            data-datein="<?php echo $accreditation_datein; ?>"
                            data-content="<?php echo get_the_content(); ?>"
                            >Editar</a> 
                    </div>
                    <?php endif; ?>
                </div>
                <h3><?php echo ucfirst(get_the_title()); ?></h3>
                <div class="accreditations-crud-content"> <?php the_content(); ?> </div>
                <table>
                    <tr>
                        <th>Acreditado por</th>
                        <td><?php echo $accreditation_bussiness; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td><?php echo $accreditation_datein; ?></td>
                    </tr>
                    <tr>
                        <th>Archivo</th>
                        <td><?php echo $accreditation_file; ?></td>
                    </tr>
                </table>
            </div>
            <?php
               // Show Posts ...
            endwhile;

            /* Restore original Post Data 
            * NB: Because we are using new WP_Query we aren't stomping on the 
            * original $wp_query and it does not need to be reset.
            */
            wp_reset_postdata();
            ?>
        </div>
        <?php if($profile_id == $user->ID && in_array(crud_plugin_role, $roles)): ?>
        <div class="accreditations-crud-edit-service-btn accreditations-crud-box" 
            data-servtag="0"
            data-title=""
            data-categories=""
            data-content="">
            <span class="accreditations-fake-icon">+</span>
            <h2>Agregar nueva acreditación</h2>
        </div>
        <div class="accreditations-crud-editor" style="display: none;" id="accreditations-crud-editor">
            <form class="accreditations-crud-box">
                <input type="hidden" name="action" value="accreditations_crud_servtag">
                <input type="hidden" name="serv-uidd" value="<?php echo $result; ?>">
                <input type="hidden" name="accreditations-crud-servtag-editor" class="accreditations-crud-servtag-editor" value="0">
                <div class="form-elm">
                    <input type="text" name="servtag-title" class="servtag-title" placeholder="Título" required>
                </div>
                <div class="form-elm">
                    <textarea name="servtag-content" class="servtag-content" placeholder="Descripción" required></textarea>
                </div>
                <div class="form-elm">
                    <input type="text" name="servtag-bussiness" class="servtag-bussiness" placeholder="Acreditado por" required>
                </div>
                <div class="form-elm">
                    <b>Seleccionar Archivo PDF (Certificado)</b>
                    <input type="file" name="fileToUpload" class="servtag-file" placeholder="Archivo" accept="application/pdf">
                </div>
                <div class="form-elm">
                    <b>Fecha</b>
                    <input type="date" name="servtag-datein" class="servtag-datein" placeholder="Fecha"
                    max="<?php echo $maxDate; ?>" required>
                </div>
                <button class="um-do-search um-button" >Guardar</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        var accreditations_crud = {
            ajax_url: "<?php echo admin_url( 'admin-ajax.php' ); ?>"
        };
    </script>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'accreditations_crud', 'accreditations_crud' );