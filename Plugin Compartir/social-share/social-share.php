<?php
/*
Plugin Name: Compartir Perfil
Plugin URI: https://github.com/julianloaiza/Engix/tree/main/Plugin%20Compartir
Description: El plugin "Compartir Perfil" agrega funcionalidad de compartir en redes sociales a los perfiles de usuario, permitiendo a los usuarios compartir sus perfiles en diversas plataformas de redes sociales.
Author: Julian Loaiza
Author URI: https://github.com/julianloaiza
Version: 1.0
*/

require_once( plugin_dir_path( __FILE__ ) . 'phpqrcode/qrlib.php' );

function social_share_enqueue_scripts() {
    // Enqueue frontend.css
    wp_enqueue_style( 'social-share-frontend', plugin_dir_url( __FILE__ ) . 'frontend.css' );

    // Enqueue clipboard.js
    wp_enqueue_script( 'clipboard', 'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js', array(), '2.0.8', true );
}
add_action( 'wp_enqueue_scripts', 'social_share_enqueue_scripts' );


// Function to generate the shortcode content
function social_share_shortcode() {
    // Retrieves the current page URL
    $current_url = esc_url( home_url( $_SERVER['REQUEST_URI'] ) );

    // Removes the trailing characters from the URL string
    $current_url = rtrim( $current_url, '?profiletab=compartir' );

    // Dynamically generates the QR code for the profile URL
    $qr_code_file = plugin_dir_path( __FILE__ ) . 'qr_codes/' . md5( $current_url ) . '.png';
    if ( ! file_exists( $qr_code_file ) ) {
        QRcode::png( $current_url, $qr_code_file, QR_ECLEVEL_L, 5, 2 );
    }

    // Dynamically generates the QR code for the profile URL
    $output = '<div class="social-share-container">';
    $output .= '<div class="social-share-icons">';
    $output .= '<div class="social-share-icon"><a href="https://t.me/share?url=' . $current_url . '" target="_blank"><img src="' . plugin_dir_url( __FILE__ ) . 'images/logo-telegram.png" alt="Telegram"><label>Telegram</label></a></div>';
    $output .= '<div class="social-share-icon"><a href="whatsapp://send?text=' . $current_url . '" target="_blank"><img src="' . plugin_dir_url( __FILE__ ) . 'images/logo-whatsapp.png" alt="WhatsApp"><label>WhatsApp</label></a></div>';
    $output .= '<div class="social-share-icon"><a href="https://www.facebook.com/sharer/sharer.php?u=' . $current_url . '" target="_blank"><img src="' . plugin_dir_url( __FILE__ ) . 'images/logo-facebook.png" alt="Facebook"><label>Facebook</label></a></div>';
    $output .= '<div class="social-share-icon"><a href="https://www.linkedin.com/shareArticle?url=' . $current_url . '" target="_blank"><img src="' . plugin_dir_url( __FILE__ ) . 'images/logo-linkedin.png" alt="LinkedIn"><label>LinkedIn</label></a></div>';
    $output .= '<div class="social-share-icon"><a href="https://www.instagram.com/direct/" onclick="event.preventDefault(); navigator.clipboard.writeText(\'' . $current_url . '\').then(function() { window.open(\'https://www.instagram.com/direct/\', \'_blank\'); });"><img src="' . plugin_dir_url( __FILE__ ) . 'images/logo-instagram.png" alt="Instagram"><label>Instagram</label></a></div>';
    $output .= '<div class="social-share-icon"><a href="https://twitter.com/intent/tweet?url=' . $current_url . '" target="_blank"><img src="' . plugin_dir_url( __FILE__ ) . 'images/logo-twitter.png" alt="Twitter"><label>Twitter</label></a></div>';
    $output .= '</div>';
    $output .= '<div class="social-share-profile">';
    $output .= '<input type="text" id="social-share-url" value="' . $current_url . '" readonly>';
    $output .= '<button class="share-button" data-clipboard-text="' . $current_url . '" id="clipboard-button" title="Copiar">Copiar</button>';
    $output .= '</div>';
    $output .= '<div class="social-share-qr">';
    $output .= '<div class="qr-container"><img src="' . plugin_dir_url( __FILE__ ) . 'qr_codes/' . md5( $current_url ) . '.png" alt="Código QR"></div>';
    $output .= '<div class="button-container"><button class="share-button"><a href="' . plugin_dir_url( __FILE__ ) . 'qr_codes/' . md5( $current_url ) . '.png" download="engix-qr.png">Descargar QR del perfil</a></button></div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

add_shortcode( 'social_share', 'social_share_shortcode' );


function social_share_init_clipboard() {
    ob_start(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new ClipboardJS('#clipboard-button');
        });
    </script>
    <?php
    $script = ob_get_clean();
    echo $script;
}

add_action( 'wp_footer', 'social_share_init_clipboard' );