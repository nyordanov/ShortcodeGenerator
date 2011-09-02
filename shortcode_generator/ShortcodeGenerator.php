<?php
/**
 * A really basic shortcode generator which uses parts of SmartMetaBox
 *
 * @author: Nikolay Yordanov <me@nyordanov.com> http://nyordanov.com
 * @version: 1.0
 *
 */

class ShortcodeGenerator extends SmartMetaBox {
	// create meta box based on given data
	
	public function __construct($id, $opts) {
		if (!is_admin()) return;
		$this->meta_box = $opts;
		$this->id = $id;
		add_action('add_meta_boxes', array(&$this,
			'add'
		));
	}

	// Callback function to show fields in meta box
	
	public function show($post) {
		echo '<table class="form-table">';
		foreach ($this->meta_box['fields'] as $field) {
			extract($field);
			$id = $this->id .'-'. $id;
			
			$value = isset($field['default']) ? $default : '';
			
			echo '<tr>', '<th style="width:20%"><label for="'.$id.'">'.$name.'</label></th>', '<td>';
			
			include dirname(__FILE__)."/../smart_meta_box/smart_meta_fields/$type.php"; // in my example this is where the field templates are
			
			if (isset($desc)) {
				echo '&nbsp;<span class="description">' . $desc . '</span>';
			}
			echo '</td></tr>';
		}
		echo '</table>';
		
		echo '<a href="#" class="generate-shortcode button">'.__('Generate').'</a>';
	}
};

function add_shortcode_generator($id, $opts) {
	wp_enqueue_style('shortcode-generator', get_bloginfo('template_directory').'/shortcode_generator/generator.css');
	wp_enqueue_script('shortcode-generator', get_bloginfo('template_directory').'/shortcode_generator/generator.js', array('jquery'), false, true);

	new ShortcodeGenerator($id, $opts);
}
