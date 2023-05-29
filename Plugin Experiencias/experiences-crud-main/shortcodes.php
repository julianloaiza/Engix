<?php
function experiences_crud( $atts ) {
    global $wpdb;
    //$timezone_string = get_option( 'timezone_string' );
    //date_default_timezone_set($timezone_string);
    $a = shortcode_atts( array(
        'type' => 'now',
        'scale' => '0',
    ), $atts );
    
    wp_register_script('experiences_crud-select2-script-frontend', crudex_plugin_base_URL .'select2.min.js?v='.crudex_plugin_V);
    wp_enqueue_script('experiences_crud-select2-script-frontend');
    wp_register_script('experiences_crud-script-frontend', crudex_plugin_base_URL .'frontend.js?v='.crudex_plugin_V);
    wp_enqueue_script('experiences_crud-script-frontend');
    wp_register_style('experiences_crud-select2-style-frontend', crudex_plugin_base_URL .'select2.min.css?v='.crudex_plugin_V);
    wp_enqueue_style('experiences_crud-select2-style-frontend');
    wp_register_style('experiences_crud-style-frontend', crudex_plugin_base_URL .'frontend.css?v='.crudex_plugin_V);
    wp_enqueue_style('experiences_crud-style-frontend');
    ob_start();

    $result = um_get_requested_user();
    $user = wp_get_current_user();
    $profile_id = um_profile_id();
    $maxDate = date('Y-m-d');
    $roles = ( array ) $user->roles;
    
    ?>
    <div class="experiences-crud-wrap">
        <div class="experiences-crud-list-experiences">
            <?php
            $the_query = new WP_Query( array(
                'author__in'=> array($result),
                'post_type' => 'experience-crud',
                'post_status' => 'publish',
                'posts_per_page' => '-1'
            ));

            while ( $the_query->have_posts() ) :
               $the_query->the_post();
               $post_ID = get_the_ID();
               $author_id = get_post_field( 'post_author', $post_ID );
               $experience_bussiness = get_post_meta( $post_ID, '_experience_bussiness', true );
               $experience_datein = get_post_meta( $post_ID, '_experience_datein', true );
               $experience_dateout = get_post_meta( $post_ID, '_experience_dateout', true );
            ?>
            <div class="experiences-crud-list-experiences-el experiences-crud-box">
                <div class="experiences-crud-list-experiences-el-header">
                    <div class="experiences-crud-categories">
                       
                    </div>
                    <?php if($profile_id == $user->ID && in_array(crud_plugin_role, $roles)): ?>
                    <div>
                        <a href="#delete" data-servtag="<?php echo $post_ID; ?>" data-uidd="<?php echo $result; ?>" class="experiences-crud-link experiences-crud-delete">Eliminar</a>
                        <a href="#edit" data-servtag="<?php echo $post_ID; ?>" class="experiences-crud-edit-service-btn experiences-crud-link experiences-crud-edit"
                            data-title="<?php echo ucfirst(get_the_title()); ?>"
                            data-bussiness="<?php echo $experience_bussiness; ?>"
                            data-datein="<?php echo $experience_datein; ?>"
                            data-dateout="<?php echo $experience_dateout; ?>"
                            data-content="<?php echo get_the_content(); ?>"
                            >Editar</a> 
                    </div>
                    <?php endif; ?>
                </div>
                <h3><?php echo ucfirst(get_the_title()); ?></h3>
                <div class="experiences-crud-content"> <?php the_content(); ?> </div>
                <table>
                    <tr>
                        <th>Nombre de Empresa</th>
                        <td><?php echo $experience_bussiness; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha Inicio</th>
                        <td><?php echo $experience_datein; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha Fin</th>
                        <td><?php echo $experience_dateout; ?></td>
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
        <div class="experiences-crud-edit-service-btn experiences-crud-box" 
            data-servtag="0"
            data-title=""
            data-categories=""
            data-content="">
            <span class="experiences-fake-icon">+</span>
            <h2> Agregar nueva experiencia</h2>
        </div>
        <div class="experiences-crud-editor" style="display: none;" id="experiences-crud-editor">
            <form class="experiences-crud-box">
                <input type="hidden" name="action" value="experiences_crud_servtag">
                <input type="hidden" name="serv-uidd" value="<?php echo $result; ?>">
                <input type="hidden" name="experiences-crud-servtag-editor" class="experiences-crud-servtag-editor" value="0">
                <div class="form-elm">
                    <input type="text" name="servtag-title" class="servtag-title" placeholder="Título" required>
                </div>
                <div class="form-elm">
                    <textarea name="servtag-content" class="servtag-content" placeholder="Descripción" required></textarea>
                </div>
                <div class="form-elm">
                    <input type="text" name="servtag-bussiness" class="servtag-bussiness" placeholder="Nombre de Empresa" required>
                </div>
                <div class="form-elm form-col2">
                    <div class="col">
                        <b>Fecha Inicio</b>
                        <input type="date" name="servtag-datein" class="servtag-datein" placeholder="Fecha Inicio"
                        max="<?php echo $maxDate; ?>" required>
                    </div>
                    <div class="col">
                        <b>Fecha Fin</b>
                        <input type="date" name="servtag-dateout" class="servtag-dateout" placeholder="Fecha Fin"
                        max="<?php echo $maxDate; ?>" required>
                    </div>
                </div>
                <button class="um-do-search um-button" >Guardar</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        var experiences_crud = {
            ajax_url: "<?php echo admin_url( 'admin-ajax.php' ); ?>"
        };
    </script>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'experiences_crud', 'experiences_crud' );