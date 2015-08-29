<?php get_header(); ?>
<?php 
$getConnectionOperator = '_';
$optionConnectionOperator = "/";
?>

<div id="content">
 <h2>Изберете услуга и локация:</h2>
 
<form role="search" method="get" action="<?php echo home_url( '/' ); ?>"> 
	 <div>
		 <span class="label">Услуга: </span> 
		 <select name="type">
<?php 
	$services = get_terms("serviceTypeTaxonomy", array(
		'hide_empty' => false,
		'childless' => true,
	));
	
	$options = array();
	
	foreach ($services as $service) {
		$slug = ''.$service->slug;
		$name = ''.$service->name;
		while($service->parent != "0"){
			$service = get_term($service->parent, serviceTypeTaxonomy);
			$slug = $service->slug.$getConnectionOperator.$slug;
			$name = $service->name.$optionConnectionOperator.$name;
		}
		
		$options[$slug] = $name;
	}
	array_multisort($options);
	foreach($options as $slug => $name) {
		echo '<option value="'.$slug.'" >'.$name.'</option>';
	}
?> 
		 </select>
		 <span class="label">Локация: </span> 
		 <select name="location">		 
<?php 
	$locations = get_terms("locationTaxonomy", array('hide_empty' => false));
	foreach ($locations as $location) {
		echo '<option value="'.$location->slug.'" >'.$location->name.'</option>';
	}
?>
		 </select>
	 </div>
	 <div>
		<input type="submit" class="button" value="Потърси услуга!" />
	 </div>
</form>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>