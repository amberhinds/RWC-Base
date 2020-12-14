<?php

/**
 *
 * @author       Road Warrior Creative
 * @subpackage   Customizations
 * @link         http://roadwarriorcreative.com
 */

//* Modify the admin footer text
add_filter('admin_footer_text', 'roadwarriorwp_modify_footer_admin');
function roadwarriorwp_modify_footer_admin () {

  echo '<span id="footer-thankyou">Theme Development by <a href="https://roadwarriorcreative.com" target="_blank">Road Warrior Creative</a></span>';

}

//* Change the login logo
add_action('login_head', 'custom_loginlogo');
function custom_loginlogo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	echo '<style type="text/css">
		.login h1 a {
			background-image: url('.$image[0].') !important; 
			background-size: contain;
	    	width: 100%;
	    	height: 100px;
		}
	</style>';
}

//* Chance login logo URL & name
add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
function my_login_logo_url_title() {
    return get_bloginfo('name');
}


//* Add dashboard widget
add_action( 'wp_dashboard_setup', 'roadwarriorwp_add_dashboard_widgets' );
function roadwarriorwp_add_dashboard_widgets() {

    add_meta_box( 'rwc_dashboard_widget', 'Welcome to the '.get_bloginfo('name').' Website', 'roadwarriorwp_dashboard_widget_function', 'dashboard', 'side', 'high' );
    add_meta_box( 'rwc_dashboard_rss', 'Road Warrior Creative News', 'roadwarriorwp_dashboard_rss', 'dashboard', 'side', 'high' );

}

function roadwarriorwp_dashboard_widget_function() {

	echo '<style> .roadwarriorwp-widget strong { 
					display: inline-block; 
					min-width: 100px; 
					margin-left: 5px; 
				} 
				.roadwarriorwp-widget li { 
					margin-bottom: 10px; 
				} 
				.fa {
					font-size: 18px;
    				padding: 10px;
    				border-radius: 50%;
				    background: #9bc93b;
				    width: 20px;
				    text-align: center;
				    color: #fff;
				}
				.fa:hover {
					background: #cade72;
				}
		</style>
		<script src="https://use.fontawesome.com/accb49702d.js"></script>';
	echo '<div class="roadwarriorwp-widget">';
	echo '<p>This website was designed with great care by Road Warrior Creative. 
		If you have any questions at all while working with it, please don&#39;t hesitate to ask! We are happy to help.</p>'; 
	echo '<p>Enjoy!<br/>
		Amber & Chris Hinds<br/>
		and the Road Warrior Creative team</p>';
	echo '<a href="https://roadwarriorcreative.com" target="_blank"><img src="http://roadwarriorcreative.com/wp-content/uploads/2015/10/RWC-Logo-360w.png"></a>';
	echo '<h2>HOW TO GET HELP</h2>';
	echo '<ul>';
	echo '<li><span class="dashicons dashicons-admin-site"></span><strong>Website</strong> <a href="https://roadwarriorcreative.com/contact/customer-support/?utm_source=WPadmin" target="_blank">roadwarriorcreative.com</a></li>';
	echo '<li><span class="dashicons dashicons-email"></span><strong>Email</strong> <a href="mailto:support@roadwarriorcreative.com?body='.get_bloginfo('url').'" target="_blank">support@roadwarriorcreative.com</a></li>';
	echo '<li><span class="dashicons dashicons-phone"></span><strong>Phone</strong> <a href="tel:5129425858" target="_blank">512-942-5858</a></li>';
	echo '<li><span class="dashicons dashicons-editor-help"></span><strong><a href="https://roadwarriorcreative.com/contact/customer-support/#faq" target="_blank">Support FAQ & Hours</a></strong></li>';
	echo'</ul>';
	echo '<h3>FOLLOW US</h3>';
	echo '<a href="https://www.facebook.com/roadwarriorwp" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
		<a href="https://instagram.com/roadwarriorwp" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		<a href="https://www.linkedin.com/company/road-warrior-creative" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
		<a href="https://pinterest.com/roadwarriorwp" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
		<a href="https://twitter.com/roadwarriorwp" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>';

	echo '</div>';

}

function roadwarriorwp_dashboard_rss() {
	echo '<div class="roadwarriorwp-widget">';

	$rss = fetch_feed( "https://roadwarriorcreative.com/feed/" );

    if ( is_wp_error($rss) ) {
      	if ( is_admin() || current_user_can( 'manage_options' ) ) {
           echo '<p>';
           printf( __( '<strong>RSS Error</strong>: %s' ), $rss->get_error_message() );
           echo '</p>';
      	}
     	return;
	}

	if ( !$rss->get_item_quantity() ) {
	     echo '<p>Apparently, there are no updates to show!</p>';
	     $rss->__destruct();
	     unset($rss);
	     return;
	}

	echo "<ul>\n";

	if ( !isset($items) )
	     $items = 5;

	     foreach ( $rss->get_items( 0, $items ) as $item ) {
	          $publisher = '';
	          $site_link = '';
	          $link = '';
	          $content = '';
	          $date = '';
	          $link = esc_url( strip_tags( $item->get_link() ) );
	          $title = esc_html( $item->get_title() );
	          $content = $item->get_content();
	          $content = wp_html_excerpt( $content, 200 ) . ' ...<a target="_blank" href="' . $link . '">Keep Reading</a>';

	         echo "<li><a class='rsswidget' href='$link' target='_blank'>$title</a>\n<div class='rssSummary'>$content</div>\n";
	}

	echo "</ul>\n";
	$rss->__destruct();
	unset($rss);

	echo '</div>';
}