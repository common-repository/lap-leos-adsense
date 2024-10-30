<?php
/*
Plugin Name: LAP - Leos AdSense
Plugin URI: http://www.radime.cz/wordpress/plugins/lap-leos-adsense/
Description: This plugin allows assigning different adsense master IDs and channel/slot IDs to each post and alows to show ads in posts older than defined number of days.
Version: 0.5
Author: Leos Silny
Author URI: http://www.radime.cz/wordpress/plugins/lap-leos-adsense/
*/

//return option set for adsense channel id
function lap_get_adsensechannel_id($post_id){
	$adsensechannel_id = get_option("lap_adsensechannel_id_".$post_id);
	return $adsensechannel_id;
}

//return option set for adsense id
function lap_get_adsense_id($post_id){
	$adsense_id = get_option("lap_adsense_id_".$post_id);
	return $adsense_id;
}

//form for adsense IDs - editing POST
function lap_insert_input_field($post_id){
	$lap_adsenseid = htmlspecialchars(stripcslashes(lap_get_adsense_id($_REQUEST['post'])));
	$lap_adsensechannelid = htmlspecialchars(stripcslashes(lap_get_adsensechannel_id($_REQUEST['post'])));

	?>	
		<div id="postlap" class="postbox closed">
			<h3>LAP - Leos AdSense</h3>
			<div class="inside">
				<div id="postlap">

					<input value="lap_edit" type="hidden" name="lap_edit" />
					<table style="margin-bottom:40px">
						<tr>
							<th style="text-align:left;" colspan="2"></th>
						</tr>
						<tr>
							<th scope="row" style="text-align:right;">AdSense ID pub-</th>
							<td><input value="<?php echo $lap_adsenseid ?>" type="text" name="lap_adsenseid" size="62"/></td>
						</tr>
						<tr>
							<th scope="row" style="text-align:right;">AdSense channel ID / ad-slot ID</th>
							<td><input value="<?php echo $lap_adsensechannelid ?>" type="text" name="lap_adsensechannelid" size="62"/></td>
						</tr>
					</table>
				</div>
			</div>
		</div>	
	<?php
}

//updating IDs
function post_lap_tags($id){
	$awmp_edit = $_POST["lap_edit"];
	if (isset($awmp_edit) && !empty($awmp_edit)) {
		$lap_adsenseid = $_POST["lap_adsenseid"];
		$lap_adsensechannelid = $_POST["lap_adsensechannelid"];
		
		delete_post_lap($_REQUEST['post_ID'],'lap_adsense_id', $lap_adsenseid);
		delete_post_lap($_REQUEST['post_ID'],'lap_adsensechannel_id', $lap_adsensechannelid);
	
		if (isset($lap_adsenseid) && !empty($lap_adsenseid)) {
			add_post_lap($_REQUEST['post_ID'], 'lap_adsense_id', $lap_adsenseid);
		}
		
		if (isset($lap_adsensechannelid) && !empty($lap_adsensechannelid)) {
			add_post_lap($_REQUEST['post_ID'], 'lap_adsensechannel_id', $lap_adsensechannelid);
		}
	}
		
}

//deleting option
function delete_post_lap($id, $key, $value){
	delete_option($key."_".$id);
}

//adding option
function add_post_lap($id, $key, $value){
	add_option($key."_".$id, $value, '', 'yes');
}
	
//admin menu - placeholder
function lap_admin_actions(){
	add_options_page("LAP", "LAP", 1, "lap", "lap_menu");
}
	
//admin menu
function lap_menu(){
	global $wpdb;

	if($_POST['save']){
		delete_option('lap_code_1');
		delete_option('lap_code_2');
		delete_option('lap_code_3');
		delete_option('lap_code_4');
		delete_option('lap_code_5');
		delete_option('lap_post_older_than');
		
		add_option('lap_code_1', $_POST['lap_code_1'], '', 'yes');
		add_option('lap_code_2', $_POST['lap_code_2'], '', 'yes');
		add_option('lap_code_3', $_POST['lap_code_3'], '', 'yes');
		add_option('lap_code_4', $_POST['lap_code_4'], '', 'yes');
		add_option('lap_code_5', $_POST['lap_code_5'], '', 'yes');
		add_option('lap_post_older_than', $_POST['lap_post_older_than'], '', 'yes');
		
	}
		
	?>
	<div class="wrap">
		<h2><?php echo "LAP - Leos AdSense Settings"; ?></h2>
		<p>
		<form name="dofollow" action="" method="post">
			<table class="form-table">
				<tr>
					<th scope="row" style="text-align:right; vertical-align:top;">
					Code 1 [LAP-plugin1]:
					</td>
					<td>
					<textarea cols="57" rows="6" name="lap_code_1"><?php echo stripcslashes(get_option('lap_code_1')); ?></textarea>
					(Replace channel/slot ID with YYYYY and pub-ID with XXXXX - real numbers must be set up at each post separately, script will replace them while showing post.)
					</td>
				</tr>
				<tr>
					<th scope="row" style="text-align:right; vertical-align:top;">
					Code 2 [LAP-plugin2]:
					</td>
					<td>
					<textarea cols="57" rows="6" name="lap_code_2"><?php echo stripcslashes(get_option('lap_code_2')); ?></textarea>
					(Replace channel/slot ID with YYYYY and pub-ID with XXXXX - real numbers must be set up at each post separately, script will replace them while showing post.)
					</td>
				</tr>
				<tr>
					<th scope="row" style="text-align:right; vertical-align:top;">
					Code 3 [LAP-plugin3]:
					</td>
					<td>
					<textarea cols="57" rows="6" name="lap_code_3"><?php echo stripcslashes(get_option('lap_code_3')); ?></textarea>
					(Replace channel/slot ID with YYYYY and pub-ID with XXXXX - real numbers must be set up at each post separately, script will replace them while showing post.)
					</td>
				</tr>
				<tr>
					<th scope="row" style="text-align:right; vertical-align:top;">
					Code 4 [LAP-plugin4]:
					</td>
					<td>
					<textarea cols="57" rows="6" name="lap_code_4"><?php echo stripcslashes(get_option('lap_code_4')); ?></textarea>
					(Replace channel/slot ID with YYYYY and pub-ID with XXXXX - real numbers must be set up at each post separately, script will replace them while showing post.)
					</td>
				</tr>
				<tr>
					<th scope="row" style="text-align:right; vertical-align:top;">
					Code 5 [LAP-plugin5]:
					</td>
					<td>
					<textarea cols="57" rows="6" name="lap_code_5"><?php echo stripcslashes(get_option('lap_code_5')); ?></textarea>
					(Replace channel/slot ID with YYYYY and pub-ID with XXXXX - real numbers must be set up at each post separately, script will replace them while showing post.)
					</td>
				</tr>
				<tr>
					<th scope="row" style="text-align:right; vertical-align:top;">
					Show ads for posts older than:
					</td>
					<td>
					<input type='text' name='lap_post_older_than' value='<?php echo stripcslashes(get_option('lap_post_older_than')); ?>'> days.
					</div>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
					<input type='submit' name='save' value='save'>
					</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
}
	
//outputting post content
function lap_filter_content($content){
	$exclude = FALSE;
	if (ereg('<!-no-adsense-->',$content)) $exclude = TRUE;
	
	if(!$exclude){
		$day_offset = get_option('lap_post_older_than');
		$expire = time() - $day_offset*24*60*60;
		if (get_the_time('U') < $expire){
			if(is_single()){
				$content = lap_filter_inject_code($content);  // Single Post - Old day
				return $content;
			}else{
				return $content;
			}
		}else{
			return $content;
		}
	}else{
		return $content;
	}
}

//injecting code and replacing masks with real IDs
function lap_filter_inject_code($content){
	global $wp_query;
	$post_id = $wp_query->post->ID;
		
	$code1 = stripslashes(get_option('lap_code_1'));
	$code2 = stripslashes(get_option('lap_code_2'));
	$code3 = stripslashes(get_option('lap_code_3'));
	$code4 = stripslashes(get_option('lap_code_4'));
	$code5 = stripslashes(get_option('lap_code_5'));
		
	//replacing XXXXX AND YYYYY
	$adsensechannel_id = get_option("lap_adsensechannel_id_".$post_id);
	$adsense_id = get_option("lap_adsense_id_".$post_id);

	$ads_paragraphs = array_unique($ads_paragraphs);
		
	$code1 = str_replace("YYYYY",$adsensechannel_id,$code1);
	$code1 = str_replace("XXXXX",$adsense_id,$code1);
	$code2 = str_replace("YYYYY",$adsensechannel_id,$code2);
	$code2 = str_replace("XXXXX",$adsense_id,$code2);
	$code3 = str_replace("YYYYY",$adsensechannel_id,$code3);
	$code3 = str_replace("XXXXX",$adsense_id,$code3);
	$code4 = str_replace("YYYYY",$adsensechannel_id,$code4);
	$code4 = str_replace("XXXXX",$adsense_id,$code4);
	$code5 = str_replace("YYYYY",$adsensechannel_id,$code5);
	$code5 = str_replace("XXXXX",$adsense_id,$code5);
	
	$output = str_replace("[LAP-plugin1]",$code1, $content);
	$output = str_replace("[LAP-plugin2]",$code2, $output);
	$output = str_replace("[LAP-plugin3]",$code3, $output);
	$output = str_replace("[LAP-plugin4]",$code4, $output);
	$output = str_replace("[LAP-plugin5]",$code5, $output);
		
	return $output;
}//end function

add_action('edit_form_advanced','lap_insert_input_field');	//inserting fileds into post edit form
add_action('edit_post','post_lap_tags');					//saving settings for different IDs
add_action('admin_menu', 'lap_admin_actions');				//inserting admin menu
add_filter('the_content', 'lap_filter_content', 25);		//filtering and outputing post content
?>