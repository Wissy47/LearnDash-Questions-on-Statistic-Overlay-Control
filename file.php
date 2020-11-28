<?php
/* This snippet should go to the functions.php of your child theme or any plugin that allow adding of snippet
*/

// LearnDash statistic page question control start here.
//
add_action( 'admin_menu', 'extra_post_info_menu' );  function extra_post_info_menu(){    
	$page_title = 'WordPress Extra Post Info';  
	$menu_title = 'LearnDash Question Control'; 
	$capability = 'manage_options';  
	$menu_slug  = 'extra-post-info';  
	$function   = 'extra_post_info_page';  
	$icon_url   = 'dashicons-media-code';  
	$position   = 4;   
	add_menu_page( $page_title,
				  $menu_title, 
				  $capability,
				  $menu_slug, 
				  $function,  
				  $icon_url, 
				  $position ); }


if( !function_exists('extra_post_info_menu') ) 
{ function extra_post_info_menu(){ add_menu_page( $page_title,                  
												 $menu_title,                  
												 $capability,                  
												 $menu_slug,                  
												 $function,                  
												 $icon_url,                  
												 $position ); } }
 
if( !function_exists("extra_post_info_page") ) { function extra_post_info_page(){ ?>   <h1>LearnDash Question Control</h1> <?php } }

function extra_post_info_page(){ ?><h1>LearnDash Question Control</h1>
<form method="post" action="options.php">
<?php settings_fields( 'extra-post-info-settings' ); ?>
<?php do_settings_sections( 'extra-post-info-settings' ); ?>
	<p>
		Type the word "hide" without quote in the text and save to hide questions on Student Statistic page 
	</p>
    <table class="form-table"><tr valign="top"><th scope="row">LearnDash Question Control:</th>
    <td><input type="text" name="extra_post_info" value="<?php echo get_option( 'extra_post_info' ); ?>"/></td></tr></table>
<?php submit_button(); ?>
</form>
<?php }

add_menu_page( $page_title,                  $menu_title, $capability, $menu_slug, $function,                   $icon_url, $position );
add_action( 'admin_init', 'update_extra_post_info' ); 

if( !function_exists("update_extra_post_info") ) { 
function update_extra_post_info() {   register_setting( 'extra-post-info-settings', 'extra_post_info' ); } }





add_filter(
	'learndash_question_statistics_data',
	function( $question_data, $quiz, $http_post_data ) {
		// May add any custom logic using $question_data, $quiz, $http_post_data.
	$extra_info = get_option( 'extra_post_info' );
		if (  $extra_info == "hide" || $extra_info == "Hide" || $extra_info == "HIDE" ) {
			 if( current_user_can('subscriber')) {
			$question_data['questionName'] = null;
                 
  //Below is a custom style echo for a specific website it not needed
//==================================================================================
                 
/*			echo '<style> ul.wpProQuiz_questionList {display: none;}
					
					.wpProQuiz_modal_window {top: 187px !important; bottom: 20px !important;}
                    input#wpProQuiz_overlay_close{top: 214px !important;}
                   footer#footer {z-index: 0;}  
			       </style>';
			
			 }
                 
  */ 
 //=========================================================================
		}
		// Always return $question_data.
		return $question_data;
	},
	10,
	3
);
  