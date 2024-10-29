<?php
/*
Plugin Name: AppToday RSS Widget
Plugin URI: https://apptoday.com/apptoday-rss-widget/
Description: Wordpress plugin widget that displays top iOS Apps from Apple RSS feed.
Version: 1.0
Author: Winston Tsao
Author URI: https://apptoday.com/
License: GPL2
*/

// The widget class
class Apptoday_RSS_Widget extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
			'Apptoday_RSS_Widget',
			__( 'Apptoday RSS Widget', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}

	// The widget form (for the backend )
	public function form( $instance ) {

		// Set widget defaults
		$defaults = array(
			'title'      => 'Top iOS Free Apps',
            'country'    => 'us',
			'mediatype'  => 'apple-music',
			'feedtype'   => 'top-free',
			'genre'      => 'all',
			'limit'      => '10',
            'explicit'   => 'non-explicit',
            'affiliate'  => '',
            'iconsize'   => 'small',
            'layout'     => '1',
            'dspname'    => 'true',
            'dsppub'     => 'true',
            'dspgenre'   => 'true',
		);
		
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

		<?php // Widget Title ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php // Select icon Sizes ?>
		<div style="clear:both;">
            <div style="float:left;width:20%;"><label for="<?php echo esc_attr( $this->get_field_id( 'iconsize' ) ); ?>"><?php _e( 'Icon Size: ', 'text_domain' ); ?></label></div>
			<div><input id="<?php echo esc_attr( $this->get_field_id( 'iconsize' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iconsize' ) ); ?>" type="radio" value="small" <?php checked( 'small', $iconsize ); ?> /><label for="<?php echo esc_attr( $this->get_field_name( 'iconsize' ) ); ?>"><img style="vertical-align:middle;" width="32" height="32" src=<?php echo plugin_dir_url(__FILE__)."images/icon_small.png"?> title="Small" /></label> &nbsp;&nbsp;
            <input id="<?php echo esc_attr( $this->get_field_id( 'explicit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iconsize' ) ); ?>" type="radio" value="medium" <?php checked( 'medium', $iconsize ); ?> /><label for="<?php echo esc_attr( $this->get_field_name( 'iconsize' ) ); ?>"><img style="vertical-align:middle;" width="32" height="32" src=<?php echo plugin_dir_url(__FILE__)."images/icon_medium.png"?> title="Medium" /></label> &nbsp;&nbsp;
            <input id="<?php echo esc_attr( $this->get_field_id( 'explicit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iconsize' ) ); ?>" type="radio" value="large" <?php checked( 'large', $iconsize ); ?> /><label for="<?php echo esc_attr( $this->get_field_name( 'iconsize' ) ); ?>"><img style="vertical-align:middle;" width="32" height="32" src=<?php echo plugin_dir_url(__FILE__)."images/icon_large.png"?> title="Large" /></label></div>
		</div>

        <hr>
        
		<?php // Select layout ?>
		<div style="clear:both;">
            <div style="float:left;width:20%"><label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php _e( 'Layout: ', 'text_domain' ); ?></label></div>
			<div><input id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" type="radio" value="1" <?php checked( '1', $layout ); ?> /><label for="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>"><img style="vertical-align:middle;" width="32" height="32" src=<?php echo plugin_dir_url(__FILE__)."images/icon_grid.png"?> title="Images Only" /></label> &nbsp;&nbsp;
            <input id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" type="radio" value="2" <?php checked( '2', $layout ); ?> /><label for="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>"><img style="vertical-align:middle;" width="32" height="32" src=<?php echo plugin_dir_url(__FILE__)."images/icon_img_text.png"?> title="Images + Text" /></label> &nbsp;&nbsp;
            <input id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" type="radio" value="3" <?php checked( '3', $layout ); ?> /><label for="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>"><img style="vertical-align:middle;" width="32" height="32" src=<?php echo plugin_dir_url(__FILE__)."images/icon_text_only.png"?> title="Text Only" /></label></div>
		</div>

        <hr>

		<?php // Display Name ?>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'dspname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dspname' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $dspname ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'dspname' ) ); ?>"><?php _e( 'Show Item Name', 'text_domain' ); ?></label>&nbsp;&nbsp;

		<?php // Display Publisher ?>
			<input id="<?php echo esc_attr( $this->get_field_id( 'dsppub' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dsppub' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $dsppub ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'dsppub' ) ); ?>"><?php _e( 'Show Publisher', 'text_domain' ); ?></label>&nbsp;&nbsp;

		<?php // Display Genre ?>
			<input id="<?php echo esc_attr( $this->get_field_id( 'dspgenre' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dspgenre' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $dspgenre ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'dspgenre' ) ); ?>"><?php _e( 'Show Genre', 'text_domain' ); ?></label>
		</p>

        <hr>
        
		<?php // Feed Country ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'country' ) ); ?>"><?php _e( 'Country/Region', 'text_domain' ); ?></label>
            (<a href="https://support.apple.com/en-us/HT204411" target="_blank">Services Availability</a>)
			<select class="widefat" name="<?php echo $this->get_field_name( 'country' ); ?>" id="<?php echo $this->get_field_id( 'country' ); ?>">
			<?php
			// Your countries array
			$options = array(
                'al' => __( 'Albania', 'text_domain' ),
                'dz' => __( 'Algeria', 'text_domain' ),
				'ao' => __( 'Angola', 'text_domain' ),
				'ai' => __( 'Anguilla', 'text_domain' ),
                'ag' => __( 'Antigua and Barbuda', 'text_domain' ),
                'ar' => __( 'Argentina', 'text_domain' ),
                'am' => __( 'Armenia', 'text_domain' ),
				'au' => __( 'Australia', 'text_domain' ),
				'at' => __( 'Austria', 'text_domain' ),
                'az' => __( 'Azerbaijan', 'text_domain' ),
                'bs' => __( 'Bahamas', 'text_domain' ),
                'bh' => __( 'Bahrain', 'text_domain' ),
				'bb' => __( 'Barbados', 'text_domain' ),
				'by' => __( 'Belarus', 'text_domain' ),
                'be' => __( 'Belgium', 'text_domain' ),
                'bz' => __( 'Belize', 'text_domain' ),
                'bj' => __( 'Benin', 'text_domain' ),
				'bm' => __( 'Bermuda', 'text_domain' ),
				'bt' => __( 'Bhutan', 'text_domain' ),
                'bo' => __( 'Bolivia', 'text_domain' ),
                'bw' => __( 'Botswana', 'text_domain' ),
                'br' => __( 'Brazil', 'text_domain' ),
				'vg' => __( 'British Virgin Islands', 'text_domain' ),
				'bn' => __( 'Brunei Darussalam', 'text_domain' ),
                'bg' => __( 'Bulgaria', 'text_domain' ),
                'bf' => __( 'Burkina Faso', 'text_domain' ),
                'kh' => __( 'Cambodia', 'text_domain' ),
				'ca' => __( 'Canada', 'text_domain' ),
				'cv' => __( 'Cape Verde', 'text_domain' ),
                'ky' => __( 'Cayman Islands', 'text_domain' ),
                'td' => __( 'Chad', 'text_domain' ),
                'cl' => __( 'Chile', 'text_domain' ),
				'cn' => __( 'China', 'text_domain' ),
				'co' => __( 'Colombia', 'text_domain' ),
                'cg' => __( 'Congo, Republic of the', 'text_domain' ),
                'cr' => __( 'Costa Rica', 'text_domain' ),
                'hr' => __( 'Croatia', 'text_domain' ),
				'cy' => __( 'Cyprus', 'text_domain' ),
				'cz' => __( 'Czech Republic', 'text_domain' ),
                'dk' => __( 'Denmark', 'text_domain' ),
                'dm' => __( 'Dominica', 'text_domain' ),
                'do' => __( 'Dominican Republic', 'text_domain' ),
				'ec' => __( 'Ecuador', 'text_domain' ),
				'eg' => __( 'Egypt', 'text_domain' ),
                'sv' => __( 'El Salvador', 'text_domain' ),
                'ee' => __( 'Estonia', 'text_domain' ),
                'fj' => __( 'Fiji', 'text_domain' ),
				'fi' => __( 'Finland', 'text_domain' ),
				'fr' => __( 'France', 'text_domain' ),
                'gm' => __( 'Gambia', 'text_domain' ),
                'de' => __( 'Germany', 'text_domain' ),
                'gh' => __( 'Ghana', 'text_domain' ),
				'gr' => __( 'Greece', 'text_domain' ),
				'gd' => __( 'Grenada', 'text_domain' ),
                'gt' => __( 'Guatemala', 'text_domain' ),
                'gw' => __( 'Guinea-Bissau', 'text_domain' ),
                'gy' => __( 'Guyana', 'text_domain' ),
				'hn' => __( 'Honduras', 'text_domain' ),
				'hk' => __( 'Hong Kong', 'text_domain' ),
                'hu' => __( 'Hungary', 'text_domain' ),
                'is' => __( 'Iceland', 'text_domain' ),
                'in' => __( 'India', 'text_domain' ),
				'id' => __( 'Indonesia', 'text_domain' ),
				'ie' => __( 'Ireland', 'text_domain' ),
                'il' => __( 'Israel', 'text_domain' ),
                'it' => __( 'Italy', 'text_domain' ),
                'jm' => __( 'Jamaica', 'text_domain' ),
				'jp' => __( 'Japan', 'text_domain' ),
				'jo' => __( 'Jordan', 'text_domain' ),
                'kz' => __( 'Kazakhstan', 'text_domain' ),
                'ke' => __( 'Kenya', 'text_domain' ),
                'kr' => __( 'Korea, Republic Of', 'text_domain' ),
				'kw' => __( 'Kuwait', 'text_domain' ),
				'kg' => __( 'Kyrgyzstan', 'text_domain' ),
                'la' => __( 'Lao, Peoples Democratic Republ', 'text_domain' ),
                'lv' => __( 'Latvia', 'text_domain' ),
                'lb' => __( 'Lebanon', 'text_domain' ),
				'lr' => __( 'Liberia', 'text_domain' ),
				'lt' => __( 'Lithuania', 'text_domain' ),
                'lu' => __( 'Luxembourg', 'text_domain' ),
                'mo' => __( 'Macau', 'text_domain' ),
                'mk' => __( 'Macedonia', 'text_domain' ),
				'mg' => __( 'Madagascar', 'text_domain' ),
				'mw' => __( 'Malawi', 'text_domain' ),
                'my' => __( 'Malaysia', 'text_domain' ),
                'ml' => __( 'Mali', 'text_domain' ),
                'mt' => __( 'Malta', 'text_domain' ),
				'mr' => __( 'Mauritania', 'text_domain' ),
				'mu' => __( 'Mauritius', 'text_domain' ),
                'mx' => __( 'Mexico', 'text_domain' ),
                'fm' => __( 'Micronesia, Federated States of', 'text_domain' ),
                'md' => __( 'Moldova', 'text_domain' ),
				'mn' => __( 'Mongolia', 'text_domain' ),
				'ms' => __( 'Montserrat', 'text_domain' ),
                'mz' => __( 'Mozambique', 'text_domain' ),
                'na' => __( 'Namibia', 'text_domain' ),
                'np' => __( 'Nepal', 'text_domain' ),
				'nl' => __( 'Netherlands', 'text_domain' ),
				'nz' => __( 'New Zealand', 'text_domain' ),
                'ni' => __( 'Nicaragua', 'text_domain' ),
                'ne' => __( 'Niger', 'text_domain' ),
                'ng' => __( 'Nigeria', 'text_domain' ),
				'no' => __( 'Norway', 'text_domain' ),
				'om' => __( 'Oman', 'text_domain' ),
                'pk' => __( 'Pakistan', 'text_domain' ),
                'pw' => __( 'Palau', 'text_domain' ),
                'pa' => __( 'Panama', 'text_domain' ),
				'pg' => __( 'Papua New Guinea', 'text_domain' ),
				'py' => __( 'Paraguay', 'text_domain' ),
                'pe' => __( 'Peru', 'text_domain' ),
                'ph' => __( 'Philippines', 'text_domain' ),
                'pl' => __( 'Poland', 'text_domain' ),
				'pt' => __( 'Portugal', 'text_domain' ),
				'qa' => __( 'Qatar', 'text_domain' ),
                'ro' => __( 'Romania', 'text_domain' ),
                'ru' => __( 'Russia', 'text_domain' ),
                'sa' => __( 'Saudi Arabia', 'text_domain' ),
				'sn' => __( 'Senegal', 'text_domain' ),
				'sc' => __( 'Seychelles', 'text_domain' ),
                'sl' => __( 'Sierra Leone', 'text_domain' ),
                'sg' => __( 'Singapore', 'text_domain' ),
                'sk' => __( 'Slovakia', 'text_domain' ),
				'si' => __( 'Slovenia', 'text_domain' ),
				'sb' => __( 'Solomon Islands', 'text_domain' ),
                'za' => __( 'South Africa', 'text_domain' ),
                'es' => __( 'Spain', 'text_domain' ),
                'lk' => __( 'Sri Lanka', 'text_domain' ),
				'kn' => __( 'St. Kitts and Nevis', 'text_domain' ),
				'lc' => __( 'St. Lucia', 'text_domain' ),
                'vc' => __( 'St. Vincent and The Grenadines', 'text_domain' ),
                'sr' => __( 'Suriname', 'text_domain' ),
                'sz' => __( 'Swaziland', 'text_domain' ),
				'se' => __( 'Sweden', 'text_domain' ),
				'ch' => __( 'Switzerland', 'text_domain' ),
                'st' => __( 'São Tomé and Príncipe', 'text_domain' ),
                'tw' => __( 'Taiwan', 'text_domain' ),
                'tj' => __( 'Tajikistan', 'text_domain' ),
				'tz' => __( 'Tanzania', 'text_domain' ),
				'th' => __( 'Thailand', 'text_domain' ),
                'tt' => __( 'Trinidad and Tobago', 'text_domain' ),
                'tn' => __( 'Tunisia', 'text_domain' ),
                'tr' => __( 'Turkey', 'text_domain' ),
				'tm' => __( 'Turkmenistan', 'text_domain' ),
				'tc' => __( 'Turks and Caicos', 'text_domain' ),
                'ug' => __( 'Uganda', 'text_domain' ),
                'ua' => __( 'Ukraine', 'text_domain' ),
                'ae' => __( 'United Arab Emirates', 'text_domain' ),
				'gb' => __( 'United Kingdom', 'text_domain' ),
				'us' => __( 'United States', 'text_domain' ),
                'uy' => __( 'Uruguay', 'text_domain' ),
                'uz' => __( 'Uzbekistan', 'text_domain' ),
                've' => __( 'Venezuela', 'text_domain' ),
				'vn' => __( 'Vietnam', 'text_domain' ),
				'ye' => __( 'Yemen', 'text_domain' ),
                'zw' => __( 'Zimbabwe', 'text_domain' ),
                
			);

			// Loop through options and add each one to the select dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $country, $key, false ) . '>'. $name . '</option>';

			} ?>
			</select>
		</p>

		<?php // Media Type ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'mediatype' ) ); ?>"><?php _e( 'Media Type:', 'text_domain' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'mediatype' ); ?>" id="<?php echo $this->get_field_id( 'mediatype' ); ?>">
			<?php
			// Your options array
			$options = array(
                'ios-apps' => __( 'iOS Apps', 'text_domain' ),
			);

			// Loop through options and add each one to the select dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $mediatype, $key, false ) . '>'. $name . '</option>';

			} ?>
			</select>
		</p>

		<?php // Feed Type ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'feedtype' ) ); ?>"><?php _e( 'Feed Type:', 'text_domain' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'feedtype' ); ?>" id="<?php echo $this->get_field_id( 'feedtype' ); ?>">
			<?php
			// Your options array
			$options = array(
                'new-apps-we-love'    => __( 'New Apps We Love', 'text_domain' ),
                'new-games-we-love'   => __( 'New Games We Love', 'text_domain' ),
				'top-free'            => __( 'Top Free', 'text_domain' ),
				'top-free-ipad'       => __( 'Top Free iPad', 'text_domain' ),
                'top-grossing'        => __( 'Top Grossing', 'text_domain' ),
                'top-grossing-ipad'   => __( 'Top Grossing iPad', 'text_domain' ),
                'top-paid'            => __( 'Top Paid', 'text_domain' ),
			);

			// Loop through options and add each one to the select dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $feedtype, $key, false ) . '>'. $name . '</option>';

			} ?>
			</select>
		</p>

		<?php // Genre ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'genre' ) ); ?>"><?php _e( 'Genre:', 'text_domain' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'genre' ); ?>" id="<?php echo $this->get_field_id( 'genre' ); ?>">
			<?php
			// Your options array
			$options = array(
                'all'     => __( 'All', 'text_domain' ),
                'games'   => __( 'Games', 'text_domain' ),
			);

			// Loop through options and add each one to the select dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $genre, $key, false ) . '>'. $name . '</option>';

			} ?>
			</select>
		</p>

		<?php // Limit ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit', 'text_domain' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'limit' ); ?>" id="<?php echo $this->get_field_id( 'limit' ); ?>">
			<?php
			// Your options array
			$options = array(
				'5'  => __( '  5', 'text_domain' ),
				'10' => __( ' 10', 'text_domain' ),
				'15' => __( ' 15', 'text_domain' ),
				'20' => __( ' 20', 'text_domain' ),
                '30' => __( ' 30', 'text_domain' ),
                '40' => __( ' 40', 'text_domain' ),
                '50' => __( ' 50', 'text_domain' ),
                '100'=> __( '100', 'text_domain' ),
			);

			// Loop through options and add each one to the select dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $limit, $key, false ) . '>'. $name . '</option>';

			} ?>
			</select>
		</p>
        
		<?php // Explicit ?>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'explicit' ) ); ?>"><?php _e( 'Allow Explicit: ', 'text_domain' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'explicit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'explicit' ) ); ?>" type="radio" value="explicit" <?php checked( 'explicit', $explicit ); ?> />Yes &nbsp;&nbsp;
            <input id="<?php echo esc_attr( $this->get_field_id( 'explicit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'explicit' ) ); ?>" type="radio" value="non-explicit" <?php checked( 'non-explicit', $explicit ); ?> />No
		</p>

		<?php // Affiliate ID not applicable for apps ?>

        <hr>

	<?php }

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        
        $instance['title']      = isset( $new_instance['title']     ) ? wp_strip_all_tags( $new_instance['title']     ) : '';
        
		$instance['country']    = isset( $new_instance['country']   ) ? wp_strip_all_tags( $new_instance['country']   ) : '';
		$instance['mediatype']  = isset( $new_instance['mediatype'] ) ? wp_strip_all_tags( $new_instance['mediatype'] ) : '';
		$instance['feedtype']   = isset( $new_instance['feedtype']  ) ? wp_strip_all_tags( $new_instance['feedtype']  ) : '';
		$instance['genre']      = isset( $new_instance['genre']     ) ? wp_strip_all_tags( $new_instance['genre']     ) : '';
		$instance['limit']      = isset( $new_instance['limit']     ) ? wp_strip_all_tags( $new_instance['limit']     ) : '';
        $instance['explicit']   = isset( $new_instance['explicit']  ) ? wp_strip_all_tags( $new_instance['explicit']  ) : '';
        $instance['affiliate']  = isset( $new_instance['affiliate'] ) ? wp_strip_all_tags( $new_instance['affiliate'] ) : '';
        
        $instance['iconsize']   = isset( $new_instance['iconsize']  ) ? wp_strip_all_tags( $new_instance['iconsize']  ) : '';
        $instance['layout']     = isset( $new_instance['layout']    ) ? wp_strip_all_tags( $new_instance['layout']    ) : '';
        
        $instance['dspname']    = isset( $new_instance['dspname']   ) ? wp_strip_all_tags( $new_instance['dspname']   ) : '';
        $instance['dsppub']     = isset( $new_instance['dsppub']    ) ? wp_strip_all_tags( $new_instance['dsppub']    ) : '';
        $instance['dspgenre']   = isset( $new_instance['dspgenre']  ) ? wp_strip_all_tags( $new_instance['dspgenre']  ) : '';
        
		return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) {

		extract( $args );

		// Check the widget options
        $title      = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        
		$country    = isset( $instance['country']   ) ? $instance['country'] : '';
		$mediatype  = isset( $instance['mediatype'] ) ? $instance['mediatype'] : '';
		$feedtype   = isset( $instance['feedtype']  ) ? $instance['feedtype'] : '';
		$genre      = isset( $instance['genre']     ) ? $instance['genre'] : ''; // currently the genere parameter is limited, waiting for Apple.
        $limit      = isset( $instance['limit']     ) ? $instance['limit'] : '';
        $explicit   = isset( $instance['explicit']  ) ? $instance['explicit'] : '';
        $affiliate  = isset( $instance['affiliate'] ) ? $instance['affiliate'] : '';
        
        $iconsize   = isset( $instance['iconsize']  ) ? $instance['iconsize'] : '';
        $layout     = isset( $instance['layout']    ) ? $instance['layout'] : '';
        
        $dspname    = isset( $instance['dspname']   ) ? $instance['dspname'] : '';
        $dsppub     = isset( $instance['dsppub']    ) ? $instance['dsppub'] : '';
        $dspgenre   = isset( $instance['dspgenre']  ) ? $instance['dspgenre'] : '';
        
        
        // Apple has stopped affiliate program for apps.  But still works for other media types
        if ($affiliate=='') {
            $affiliate = '?at=11l4Gs';
        }
        
        // Convert icon size config to actual pixel number
        switch ($iconsize) {
            case 'medium':
                $iconpixel = 100;
                $maskscale = 0.5;
                break;
            case 'large':
                $iconpixel = 200;
                $maskscale = 1;
                break;
            default:
               $iconpixel = 50;
               $maskscale = 0.25;
        }
        
        
        // example RSS request: rss.itunes.apple.com/api/v1/us/itunes-music/top-songs/all/5/explicit.json?at=11l4Gs
        
        $rssurl = 'https://rss.itunes.apple.com/api/v1/'.$country.'/'.$mediatype.'/'.$feedtype.'/'.$genre.'/'.$limit.'/'.$explicit.'.json'.$affiliate;
        
		// WordPress core before_widget hook (always include )
		echo $before_widget;

		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box Apptoday_RSS_Widget">';
        
		// Display widget title if defined
		echo '<div class="apptoday-rss-widget-title">' . $title . '</div>';
        
        // get RSS feed in JSON format from Apple (use wp_remote_get instead of file_get_contents)
        $results = wp_remote_get($rssurl);
        $content = wp_remote_retrieve_body($results);
        
        $data    = json_decode($content,true);
        
        // Loop through the results to get each item
        $count = 1;
        
        // initialize layout string and other variables
        $layoutStr = '';
        $itemLine1 = '';
        $itemLine2 = '';
        $itemLine3 = '';
        $itemLine4 = '';
        $bgAlpha   = '';
        $bgStr     = '';
        
        // Contruct each layout
        switch ($layout) {            
            case '2': // Layout 2
                foreach($data['feed']['results'] as $collection){
                    
                    // alternating background color
                    $bgAlpha = ($count % 2 == 0) ? 0 : 0.1;
                    $bgStr   = 'background-color: rgba(196, 196, 196,'.$bgAlpha.');';
                    
                    if ($dspname=='true') {
                        $itemLine1 = '<div class="apptoday-rss-item-title">'.$count.', <a target="_blank" href="'.$collection['url'].'">'.$collection['name'].'</a></div>'."\n";
                    }
                    
                    if ($dsppub=='true') {
                        $itemLine2 = '<div class="apptoday-rss-item-artist">By <a target="_blank" href="'.$collection['artistUrl'].'">'.$collection['artistName'].'</a></div>'."\n";
                    }
                    
                    $itemLine3 =  ''; // '<div class="apptoday-rss-item-releasedate">Release Date: '.$collection['releaseDate'].'</div>'."\n";
                    
                    if ($dspgenre=='true') {
                        $itemLine4 = 'Genre: ';
                        foreach($collection['genres'] as $genrelist){
                            $itemLine4 .= '<a target="_blank" href="'.$genrelist['url'].'">'.$genrelist['name'].'</a>, '; 
                        }              
                        $itemLine4 = '<div class="apptoday-rss-item-genres">' . substr($itemLine4, 0, -2) . '</div>'."\n";
                    }
                    
                    $itemTextBlock = '<div class="apptoday-rss-item-textblock" style="margin:4px;vertical-align:middle;">'."\n".$itemLine1.$itemLine2.$itemLine3.$itemLine4.'</div>'."\n";
                    
                    $itemArtwork = '<div class="apptoday-rss-item-artwork" style="float:left;margin:4px;"><a target="_blank" title="'.$collection['name'].'" href="'.$collection['url'].'"><img class="apptoday-squircle" alt="'.$collection['name'].'" src="'.$collection['artworkUrl100'].'" width="'.$iconpixel.'" height="'.$iconpixel.'" style="margin:4px;clip-path: url(#svg-shape-'.$this->id.');"></a></div>'."\n";

                    $layoutStr .= '<div class="apptoday-rss-item-row" style="display:flex; align-items:center; clear:both;overflow:auto;'.$bgStr.'">'."\n".$itemArtwork.$itemTextBlock.'</div>'."\n";
                
                    $count++;
                } // layout 2 foreach close
                break;
                
            case '3': // Layout 3
                foreach($data['feed']['results'] as $collection){
                    
                    // alternating background color
                    $bgAlpha = ($count % 2 == 0) ? 0 : 0.1;
                    $bgStr   = 'background-color:rgba(192,192,192,'.$bgAlpha.');';
                    
                    if ($dspname=='true') {
                        $itemLine1 = '<div class="apptoday-rss-item-title">'.$count.', <a target="_blank" href="'.$collection['url'].'">'.$collection['name'].'</a></div>'."\n";
                    }
                    
                    if ($dsppub=='true') {
                        $itemLine2 = '<div class="apptoday-rss-item-artist">By <a target="_blank" href="'.$collection['artistUrl'].'">'.$collection['artistName'].'</a></div>'."\n";
                    }
                    
                    $itemLine3 =  ''; // '<div class="apptoday-rss-item-releasedate">Release Date: '.$collection['releaseDate'].'</div>'."\n";
                    
                    
                    if ($dspgenre=='true') {
                        $itemLine4 = 'Genre: ';
                        foreach($collection['genres'] as $genrelist){
                            $itemLine4 .= '<a target="_blank" href="'.$genrelist['url'].'">'.$genrelist['name'].'</a>, '; 
                        }
                        $itemLine4 = '<div class="apptoday-rss-item-genres">' . substr($itemLine4, 0, -2) . '</div>'."\n";
                    }
                
                    $layoutStr .= '<div class="apptoday-rss-item-row;" style="clear:both;overflow:auto;padding:8px;'.$bgStr.'">'.$itemLine1.$itemLine2.$itemLine3.$itemLine4.'</div>'."\n";
                    
                    $count++;
                } // layout 3 foreach close
                break;
            
            // Layout 1 (default)
            default: 
                foreach($data['feed']['results'] as $collection){
                    $collectiontitle = $count.', '.$collection['name'].' by '.$collection['artistName'];
                    $layoutStr .= '<a target="_blank" title="'.$collectiontitle.'" href="'.$collection['url'].'"><img class="apptoday-squircle" alt="'.$collection['name'].'" src="'.$collection['artworkUrl100'].'" width="'.$iconpixel.'" height="'.$iconpixel.'" style="margin:2px;clip-path: url(#svg-shape-'.$this->id.');"></a>'."\n";
                    $count++;
                } // foreach layout 1
            
        } // layout switches
        
        echo '<div class="apptoday-rss-itemlist">'.$layoutStr.'</div>'."\n";
            
        // The clipping path is set at 200px X 200px (Squircle Mask Effect)
        echo '<svg width="0" height="0"><defs><clipPath id="svg-shape-'.$this->id.'" transform="scale('.$maskscale.')"><path d="M100,200c43.8,0,68.2,0,84.1-15.9C200,168.2,200,143.8,200,100s0-68.2-15.9-84.1C168.2,0,143.8,0,100,0S31.8,0,15.9,15.9C0,31.8,0,56.2,0,100s0,68.2,15.9,84.1C31.8,200,56.2,200,100,200z" /></clipPath></defs></svg>'."\n";
        
        // Squircle fix
        echo '
        <style type="text/css" scoped>
            .apptoday-squircle {  
                -webkit-clip-path: url(#svg-shape-'.$this->id.');
                -moz-clip-path: url(#svg-shape-'.$this->id.');
                -o-clip-path: url(#svg-shape-'.$this->id.');
                -ms-clip-path: url(#svg-shape-'.$this->id.');
                clip-path: url(#svg-shape-'.$this->id.');
            }
        </style>';

		echo '</div>';

		// WordPress core after_widget hook (always include )
		echo $after_widget;

	}

}

// Register the widget
function register_apptoday_rss_widget() {
	register_widget( 'Apptoday_RSS_Widget' );
}

add_action( 'widgets_init', 'register_apptoday_rss_widget' );

