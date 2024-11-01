<?php
/*
Plugin Name: Synaio Calendar
Plugin URI: https://wordpress.org/plugins/synaio-calendar
Description: Synaio Calendar est un plugin destiné aux utilisateurs de la fonction "Événement" de l'outil Synaio.
Version: 1.1
Author: onylrocks
Author URI: https://profiles.wordpress.org/onylrocks/
*/

// if ( ! defined( 'ABSPATH' ) ){
//     define( 'ABSPATH', dirname( __FILE__ ) . '/' );
// }


// Add an admin menu page
function synaio_admin_plugin_app_post_calendar(){
    $main_menu_page_title = "Synaio Calendar";
    $main_menu_button_name = "Synaio Calendar";
    $main_menu_slug = "synaio_calendar_form_button";
    $main_menu_function_name = "synaio_main_menu_calendar_form";
    $main_menu_icon_dashicon_url = "dashicons-calendar-alt";
    $main_menu_position = 6;

    add_menu_page($main_menu_page_title, $main_menu_button_name, 'manage_options', $main_menu_slug, 
    $main_menu_function_name, $main_menu_icon_dashicon_url, $main_menu_position);

}
add_action('admin_menu', 'synaio_admin_plugin_app_post_calendar');

//https://deliciousbrains.com/create-wordpress-plugin-settings-page/#custom-fields
// Settings page form
function synaio_main_menu_calendar_form(){
    ?>
    <h1>Synaio Calendar Plugin</h1>
    <form action="options.php" method="post">
        <?php 
        settings_fields( 'calendar_options_group' );
        do_settings_sections( 'calendar_options' ); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Valider' ); ?>" />
    </form>
    <?php
}

function synaio_calendar_register_settings() {
    register_setting( 'calendar_options_group', 'synaio_calendar_options', array('synaio_calendar_options_validate') );
    add_settings_section( 'calendar_options_form', 'Paramètres', 'synaio_calendar_section_text', 'calendar_options' );

    add_settings_field( 'synaio_calendar_options_api', 'URL API', 'synaio_calendar_options_api', 'calendar_options', 'calendar_options_form' );
    add_settings_field( 'synaio_calendar_options_api_key', 'Clé API', 'synaio_calendar_options_api_key', 'calendar_options', 'calendar_options_form' );
    add_settings_field( 'synaio_calendar_options_select_view', 'Vue par défaut', 'synaio_calendar_options_select_view', 'calendar_options', 'calendar_options_form' );
    add_settings_field( 'synaio_calendar_options_checkbox_nav', 'Navigation', 'synaio_calendar_options_checkbox_nav', 'calendar_options', 'calendar_options_form' );
    add_settings_field( 'synaio_calendar_options_checkbox_days', 'Affichage des jours', 'synaio_calendar_options_checkbox_days', 'calendar_options', 'calendar_options_form' );
    add_settings_field( 'synaio_calendar_options_color', 'Couleur par défaut', 'synaio_calendar_options_color', 'calendar_options', 'calendar_options_form' );
}
add_action( 'admin_init', 'synaio_calendar_register_settings' );

// Validation (or not) of some parameters
function synaio_calendar_options_validate( $input ) {
    // $newinput['api'] = trim( $input['api'] );
    // $newinput['api_key'] = trim( $input['api_key'] );
    // $newinput['select_view'] = trim( $input['select_view'] );
    // $newinput['checkbox_nav'] = trim( $input['checkbox_nav'] );
    // $newinput['color'] = trim( $input['color'] );

    // return $newinput;

    $new_input = array();
        // if( isset( $input['api'] ) )
        //     $new_input['api'] = sanitize_text_field( $input['api'] );

        // if( isset( $input['api_key'] ) )
        //     $new_input['api_key'] = sanitize_text_field( $input['api_key'] );

        return $new_input;
}

function synaio_calendar_section_text() {
    echo '<p>Ici personnalisez le comportement de votre calendrier</p>';
}

function synaio_calendar_options_api() {
    $options = get_option( 'synaio_calendar_options' );
    echo "<input id='api' name='synaio_calendar_options[api]' type='text' size='70' value='" . esc_attr( $options['api'] ) . "' />";
}

function synaio_calendar_options_api_key() {
    $options = get_option( 'synaio_calendar_options' );
    echo "<input id='api_key' name='synaio_calendar_options[api_key]' type='text' size='70' value='" . esc_attr( $options['api_key'] ) . "' />";
}

function synaio_calendar_options_select_view() {
    $options = get_option( 'synaio_calendar_options' );
    ?>
    <select id='select_view' name='synaio_calendar_options[select_view]'>
        <option value="" selected disabled></option>
        <option value="day"<?php if (esc_attr( $options['select_view']) == 'day') {echo 'selected';} ?>>Jour</option>
        <option value="week"<?php if (esc_attr( $options['select_view']) == 'week') {echo 'selected';} ?>>Semaine</option>
        <option value="month"<?php if (esc_attr( $options['select_view']) == 'month') {echo 'selected';} ?>>Mois</option>
    </select>
    <?php
}

function synaio_calendar_options_checkbox_nav() {
    $options = get_option( 'synaio_calendar_options' );
    echo "<label for='checkbox_nav'>Masquer les boutons de navigation: </label>";
    echo "<input id='checkbox_nav' name='synaio_calendar_options[checkbox_nav]' type='checkbox' />";
}

function synaio_calendar_options_checkbox_days() {
    $options = get_option( 'synaio_calendar_options' );

    echo "Lundi <input id='calendar_options_checkbox_days' name='calendar_options_group[checkbox_days_lundi]' type='checkbox' />";
    echo "Mardi <input id='calendar_options_checkbox_days' name='calendar_options_group[checkbox_days_mardi]' type='checkbox' />";
    echo "Mercredi <input id='calendar_options_checkbox_days' name='calendar_options_group[checkbox_days_mercredi]' type='checkbox' />";  
    echo "Jeudi <input id='calendar_options_checkbox_days' name='calendar_options_group[checkbox_days_jeudi]' type='checkbox' />";
    echo "Vendredi <input id='calendar_options_checkbox_days' name='calendar_options_group[checkbox_days_vendredi]' type='checkbox' />";
    echo "Samedi <input id='calendar_options_checkbox_days' name='calendar_options_group[checkbox_days_samedi]' type='checkbox' />";
    echo "Dimanche <input id='calendar_options_checkbox_days' name='calendar_options_group[checkbox_days_dimanche]' type='checkbox' />";
}

function synaio_calendar_options_color() {
    $options = get_option( 'synaio_calendar_options' );
    echo "<input id='color' name='synaio_calendar_options[color]' type='text' value='" . esc_attr( $options['color'] ) . "' />";
}

// Adding the calendar's css and scripts to the page
function synaio_callback_for_setting_up_scripts() {
    wp_register_style( 'my_css', plugins_url('css/styles.css', __FILE__) );
    wp_enqueue_style( 'my_css' );

    wp_register_style( 'my_css_core', plugins_url('fullcalendar/core/main.css', __FILE__) );
    wp_enqueue_style( 'my_css_core' );

    wp_register_style( 'my_css_day', plugins_url('fullcalendar/daygrid/main.css', __FILE__) );
    wp_enqueue_style( 'my_css_day' );

    wp_register_style( 'my_css_time', plugins_url('fullcalendar/timegrid/main.css', __FILE__) );
    wp_enqueue_style( 'my_css_time' );

    wp_register_style( 'my_css_list', plugins_url('fullcalendar/list/main.css', __FILE__) );
    wp_enqueue_style( 'my_css_list' );

    wp_enqueue_script( 'my_script_core', plugins_url('fullcalendar/core/main.js', __FILE__), array( 'jquery' ) );
    wp_enqueue_script( 'my_script_day', plugins_url('fullcalendar/daygrid/main.js', __FILE__), array( 'jquery' ) );
    wp_enqueue_script( 'my_script_time', plugins_url('fullcalendar/timegrid/main.js', __FILE__), array( 'jquery' ) );
    wp_enqueue_script( 'my_script_list', plugins_url('fullcalendar/list/main.js', __FILE__), array( 'jquery' ) );
    wp_enqueue_script( 'my_script_scripts', plugins_url('js/scripts.js', __FILE__), array( 'jquery' ) );
}
add_action('wp_enqueue_scripts', 'synaio_callback_for_setting_up_scripts');

// Shortcode
function synaio_calendar_shortcode( $atts ) {
    // Picks up the calendar's data from DB
    $options = get_option( 'synaio_calendar_options' );
    $url = esc_attr( $options['api'] ) ;

    // Picks up the API Key from DB
    $body = [
        'token' => esc_attr( $options['api_key'] )
    ];
    // JSON-ise the body
    $body = wp_json_encode($body);

    // Create an array of all the args, here headers & body.
    // The rest is assumed by default like timeout, redirection, blocking etc
    $args = array(
        'headers' => [
            'content-type'=>'application/json', 
            'accept'=>'application/json', 
            'user-agent'=>'synaio'
        ],
        'body' => $body
    );

    // https://developer.wordpress.org/plugins/http-api/
    // https://developer.wordpress.org/reference/functions/wp_remote_post/
    $response = wp_remote_post($url, $args);
    // We are only interested in the body of the response
    $result = wp_remote_retrieve_body( $response );

    ob_start();
    $data = json_decode($result);
    echo '<script>$webresult = "'.base64_encode(json_encode($data->data)).'";</script>';
    ?>
        <div id="calendrier"></div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'synaio_calendar', 'synaio_calendar_shortcode' );
// The short code will be [synaio_calendar]