<?php
	$defaults = array(

		'show_option_all' => '', 'show_option_none' => '',

		'orderby' => 'ID', 'order' => 'ASC',

		'show_last_update' => 0, 'show_count' => 0,

		'hide_empty' => 1, 'child_of' => 0,

		'exclude' => '', 'echo' => 1,

		'selected' => 0, 'hierarchical' => 0,

		'name' => 'cat[]', 'class' => 'postform'

	);

$r = wp_parse_args( $args, $defaults );
$r['include_last_update_time'] = $r['show_last_update'];
extract( $r );
$categories = get_categories($r);

$output = '';

	if ( ! empty($categories) ) {

		$output = "<select name='$name' multiple id='$name' style='height:100px' class='$class'>\n";



		if ( $show_option_all ) {

			$show_option_all = apply_filters('list_cats', $show_option_all);

			$output .= "\t<option value='0'>$show_option_all</option>\n";

		}



		if ( $show_option_none) {

			$show_option_none = apply_filters('list_cats', $show_option_none);

			$output .= "\t<option value='-1'>$show_option_none</option>\n";

		}



		if ( $hierarchical )

			$depth = 0; 

		else

			$depth = -1;

		

		$output .= walk_category_dropdown_tree($categories, $depth, $r);

		$output .= "</select>\n";

	}



	

	$output = apply_filters('wp_dropdown_cats', $output);



	if($r["selected"]){

		$selects=explode(",",$r["selected"]);

		foreach($selects as $select){

			$output = str_replace('value="'.$select.'"','value="'.$select.'" selected',$output);

		}

	}



	if ( $echo )

		echo $output;



	return $output;
?>