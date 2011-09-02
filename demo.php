<?php

function sc_pricing($atts, $content = null, $code) {
	if(is_null($content)) return;
	
	preg_match_all('/\[price\b([^\]]*)\]((?:(?!\[\/price\]).)+)\[\/price\]/s', $content, $matches);
	
	$sub_atts = $matches[1];
	$sub_contents = $matches[2];

	$price_count = sizeof($sub_atts);
	
	ob_start();
?>
	<div class="pricing col-<?php echo $price_count?> clearfix">
		<?php for($i=0; $i<$price_count; $i++): ?>
			<?php $sub_atts[$i] = shortcode_parse_atts($sub_atts[$i]); ?>
			<div class="price <?php if($sub_atts[$i]['featured'] == 'true') echo 'featured'?>">
				<h2><?php echo $sub_atts[$i]['title'] ?></h2>
				<h3><?php echo $sub_atts[$i]['amount'] ?></h3>
				<div class="description"><?php echo $sub_contents[$i]?></div>
				<a href="<?php echo $sub_atts[$i]['button_link']?>" title="<?php echo $sub_atts[$i]['button_text']?>" class="button"><?php echo $sub_atts[$i]['button_text']?></a>
			</div>
		<?php endfor ?>
	</div>
<?php
	return ob_get_clean();
}
add_shortcode('pricing', 'sc_pricing');



include 'smart_meta_box/SmartMetaBox.php';
include 'shortcode_generator/ShortcodeGenerator.php';

function register_sh_gen() {
	
	$fields = array(
		array(
			'name' => 'Pricing options',
			'id' => 'pricing-options',
			'type' => 'select',
			'default' => 3,
			'options' => array(
				3=>3,4,5
			),
		)
	);
	
	for($i=1; $i<=5; $i++) {
		$prefix = "Price $i - ";
		
		$fields[] = array(
			'name' => $prefix.'Title',
			'id' => 'title-'.$i,
			'type' => 'text',
		);
		
		$fields[] = array(
			'name' => $prefix.'Amount',
			'id' => 'amount-'.$i,
			'type' => 'text',
		);
		
		$fields[] = array(
			'name' => $prefix.'Featured?',
			'id' => 'featured-'.$i,
			'type' => 'checkbox',
			'default' => false
		);
		
		$fields[] = array(
			'name' => $prefix.'Button link',
			'id' => 'button_link-'.$i,
			'type' => 'text',
		);
		
		$fields[] = array(
			'name' => $prefix.'Button text',
			'id' => 'button_text-'.$i,
			'type' => 'text',
		);
		
		$fields[] = array(
			'name' => $prefix.'Description',
			'id' => 'description-'.$i,
			'type' => 'textarea',
		);
	}
	
	add_shortcode_generator('pricing-shortcode', array(
		'title' => 'Pricing shortcode',
		'pages' => array('post', 'page'),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $fields
	));
	
}
add_action('admin_init', 'register_sh_gen');

