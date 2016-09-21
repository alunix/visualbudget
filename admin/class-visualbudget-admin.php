<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://visgov.com
 * @since      0.1.0
 *
 * @package    VisualBudget
 * @subpackage VisualBudget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    VisualBudget
 * @subpackage VisualBudget/admin
 */

class VisualBudget_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.1.0
     * @param    string    $plugin_name   The name of this plugin.
     * @param    string    $version       The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Add dashboard page
     */
    public function visualbudget_add_dashboard_sidelink() {
        add_menu_page(
            'Visual Budget',                                // string $page_title,
            'Visual Budget',                                // string $menu_title,
            'manage_options',                               // string $capability,
            'visualbudget',                                 // string $menu_slug,
            array($this, 'visualbudget_display_dashboard'), // callable $function = '',
            '',                                             // string $icon_url = '',
            null                                            // int $position = null
        );
    }

    /**
     * Dashboard page callback
     */
    public function visualbudget_display_dashboard() {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/visualbudget-admin-display.php';

    }

    /**
     * Register and add settings
     */
    public function visualbudget_dashboard_init() {
        register_setting(
            'visualbudget_settings_group',  // Option group
            'visualbudget_settings',        // Option name
            array( $this, 'sanitize' )      // Sanitize
        );

        // Add a new setting section
        add_settings_section(
            'visualbudget_config',          // section ID
            'Configuration',  // section title
            array( $this, 'print_section_info' ), // callback
            'visualbudget_dashboard'        // page
        );

        // Add the town name setting
        add_settings_field(
            'town_name',                    // setting ID
            'Town name',                    // setting title
            array( $this, 'town_name_callback' ), // callback function
            'visualbudget_dashboard',       // page
            'visualbudget_config'           // settings section
        );

        // Add the contact email setting
        add_settings_field(
            'contact_email',
            'Contact email address',
            array( $this, 'contact_email_callback' ),
            'visualbudget_dashboard',
            'visualbudget_config'
        );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array     $input      Contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        $new_input = array();
        if( isset( $input['town_name'] ) )
            $new_input['town_name'] = sanitize_text_field( $input['town_name'] );

        if( isset( $input['contact_email'] ) )
            $new_input['contact_email'] = sanitize_email( $input['contact_email'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info() {
        print 'Required configuration for your Visual Budget website:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function town_name_callback() {
        printf(
            '<input type="text" size="35" id="town_name" name="visualbudget_settings[town_name]" value="%s" />',
            isset( $this->options['town_name'] ) ? esc_attr( $this->options['town_name']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function contact_email_callback() {
        printf(
            '<input type="text" size="35" id="contact_email" name="visualbudget_settings[contact_email]" value="%s" />',
            isset( $this->options['contact_email'] ) ? esc_attr( $this->options['contact_email']) : ''
        );
    }


    /**
     * Register the stylesheets for the admin area.
     *
     * @since    0.1.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in VisualBudget_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The VisualBudget_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/visualbudget-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    0.1.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in VisualBudget_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The VisualBudget_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/visualbudget-admin.js', array( 'jquery' ), $this->version, false );

    }

}
