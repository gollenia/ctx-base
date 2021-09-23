<?php
/**
 * Class to generate a custom post type for colors
 * 
 * @since 1.5.0
 */

namespace Contexis\Core\Color;

class Options {

    protected static $color_array = [
        'primary' => '#3066BE', 
        'secondary' => '#BFD7FF', 
        'error' => "F72C25", 
        'warning' => "#F2AF29", 
        'success' => "#1EFFBC",
        'black' => "#000000",
        'white' => "#ffffff",
        'darkgray' => "333333",
        'gray' => "#999999",
        'lightgray' => "#cccccc"
    ];

	/*
	 * Constructor - the brain of our class
	 * */ 
	public function __construct() {
		add_action( 'init', array( 'Contexis\Core\Color\Options', 'register_color_post_type' ) );
	}

    public static function register() {
        add_action('admin_menu', array( 'Contexis\Core\Color\Options', 'add_settings_menu' ), 9);    
		add_action( 'admin_init', ['Contexis\Core\Color\Options','register_settings'] );
        add_action('after_switch_theme', ['Contexis\Core\Color\Options','generate_default_options']);
        
    }

    public static function add_settings_menu(){
        add_submenu_page( 
			'themes.php', 			// URL Location
			__('Base Colors', 'ctx-theme'),	// Name
			__('Base Colors', 'ctx-theme'), 								// Title
			'administrator', 							// Access Level
			'ctx-base-colors', 					// Page Name
			['Contexis\Core\Color\Options', 'display_admin_settings']			// Callback
		);
        add_submenu_page('themes.php', __('Custom Colors', 'ctx-theme'), __('Custom Colors', 'ctx-theme'), 'manage_options', 'edit.php?post_type=ctx-color-palette');
	}

	public static function display_admin_settings() {
		?>
		<div class="wrap">
		        <div id="icon-themes" class="icon32"></div>  
		        <h2><?php echo __("Base Colors", 'ctx-products') ?></h2>  
				<?php settings_errors(); ?>  
		        <form method="POST" action="options.php">  
		            <?php 
		                settings_fields( 'ctx_base_colors' );
		                do_settings_sections( 'ctx-main-colors' ); 
                        submit_button();
		            ?>             
		        </form> 
		</div>
		<?php
	}

	public static function register_settings() {
		register_setting( 'ctx_base_colors', 'ctx_base_color_options' );
		add_settings_section( 'main_colors', 'Main Colors', ['Contexis\Core\Color\Options','main_section_text'], 'ctx-main-colors' );
        
        foreach (self::$color_array as $name => $value) {
            add_settings_field( 'ctx_base_color_' . $name, __(ucfirst($name) . ' Color', 'ctx-theme'), ['Contexis\Core\Color\Options','ctx_color_setting_colorfield'], 'ctx-main-colors', 'main_colors', ['name' => $name] );
        }
	
	}

	public static function main_section_text() {
        echo __("Here you can define the base colors of your theme.");
	}

	public static function gray_section_text() {
        echo "hihi";
	}

	public static function ctx_product_options_validate( $input ) {
		$newinput['slug'] = trim( $input['slug'] );
		if ( ! preg_match( '/^[a-z0-9]{32}$/i', $newinput['slug'] ) ) {
			$newinput['slug'] = '';
		}
	
		return $newinput;
	}

	public static function ctx_color_setting_colorfield($color) {
        
		$options = get_option( 'ctx_base_color_options' );
        if(!$options) {
            self::generate_default_options();
        }
        
        $color_value = array_key_exists($color['name'], $options) ? $options[$color['name']] : "#ffffff";
		echo "<input id='ctx_color_setting_" . $color['name'] . "' name='ctx_base_color_options[" . $color['name'] . "]' type='text' class='ctx-color-picker' value='" . $color_value . "' />";
	}

    public static function generate_default_options()
    {
        $options = get_option( 'ctx_base_color_options' );
        if($options) {
            return;
        }
        add_option('ctx_base_color_options', self::$color_array);
    }

    public static function get() {
        $base_colors = get_option('ctx_base_color_options');
        $colors = [];
        foreach ($base_colors as $slug => $color) {
            $brightness = \Contexis\Core\Color\Utils::get_brightness($color) < 170 ? "dark" : "light";
            array_push($colors, [
                    "slug" => $slug,
                    "name" => __(ucfirst($slug) . ' Color', 'ctx-theme'),
                    "color" => $color,
                    "brightness" => $brightness,
                    "contrast" => $brightness == "dark" ? "#ffffff" : "#000000"
            ]);
        }
        return $colors;
    }
}
    

    
	

