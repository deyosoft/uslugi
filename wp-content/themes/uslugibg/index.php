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
			//$slug = $service->slug.$getConnectionOperator.$slug;
			$name = $service->name.$optionConnectionOperator.$name;
		}
		
		$options[$slug] = $name;
	}
	
	array_multisort($options);
	
	foreach($options as $slug => $name) {
		$selected = ($_GET && $_GET["type"] == $slug) ? "selected" : "";

		echo '<option value="'.$slug.'" '.$selected.' >'.$name.'</option>';
	}
?> 
		 </select>
		 <span class="label">Локация: </span> 
		 <select name="location">		 
<?php 
	$locations = get_terms("locationTaxonomy", array('hide_empty' => false));
	foreach ($locations as $location) {
		$selected = ($_GET && $_GET["location"] == $location->slug) ? "selected" : "";
		
		echo '<option value="'.$location->slug.'" '.$selected.' >'.$location->name.'</option>';
	}
?>
		 </select>
	 </div>
	 <div>
		<input type="submit" class="button" value="Потърси услуга!" />
	 </div>
</form>
</div>

<?php 	
if($_GET):
?>

<div id="searchresults">
<?php 
	$type = htmlspecialchars($_GET['type']);
	$location = htmlspecialchars($_GET['location']);
	
	$query_args = array(
		'post_type' => array('usluga'),
		'tax_query' => array(
	       'relation' => 'AND',
		   array(
			'taxonomy' => 'serviceTypeTaxonomy',
			'terms' => $type,
			'field' => 'slug'
		   ),
		   array(
		     'taxonomy' => 'locationTaxonomy',
		     'terms' => $location,
		     'field' => 'slug'
		   ),
		));

	$query_list = new WP_Query($query_args);
	
	if($query_list->have_posts()):
		echo '<h2>Резултати от търсенето:</h2>';
	
		while($query_list->have_posts()) : 
			$query_list->the_post();
		
?>
	<div class="result">
		<a href="<?php echo the_permalink(); ?>"><?php echo the_title('','', false); ?></a>
		<br />
		<?php echo the_content();?>
	</div>
<?php 
		endwhile;
	else :
		echo "<h2>Няма намерени услуги!</h2>";
	endif;
?>

</div>
<?php 
	wp_reset_query();
endif;
?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>