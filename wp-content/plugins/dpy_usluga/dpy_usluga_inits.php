<?php
/**
 * Plugin Name: Services posts.
 * Description: This plugin allows creating post type Service.
 * Author: Deyan Yosifov
 * Author URI: http://deyan-yosifov.com
 * Version: 1.0
 * License: GPLv2
 *
 */

/**
 * Copyright (C) 2015 Deyan Yosifov

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * */

/**
 * The main class for the travel routes plugin initializations.
 *
 * @author deyan-yosifov
 *
 */
 
class UslugiConstants {
	const Usluga_Post_Name = "usluga";
	const Plugin_Text_Domain = "uslugaPostPlugin";
	const ServiceType_Taxonomy_Name = "serviceTypeTaxonomy";
	const Location_Taxonomy_Name = "locationTaxonomy";
	
	static function init(){
		// TODO: Define static variables here!
	}
}
UslugiConstants::init();

class Uslugi_Plugin_Initializator {
	
	public function __construct() {
		// create custom posts
		add_action( 'init', array( $this, 'register_usluga_post' ) );
		add_action( 'init', array( $this, 'register_usluga_post_taxonomies' ) );
	}
	
	public function register_usluga_post() {
		register_post_type(UslugiConstants::Usluga_Post_Name, array(
			'labels' => array(
				'name' => __( 'Услуга', UslugiConstants::Plugin_Text_Domain ),
				'singular_name' => __( 'Услуга', UslugiConstants::Plugin_Text_Domain ),
				'add_new' => _x( 'Добави нова', 'pluginbase', UslugiConstants::Plugin_Text_Domain ),
				'add_new_item' => __( 'Добави нова услуга', UslugiConstants::Plugin_Text_Domain ),
				'edit_item' => __( 'Редактирай услуга', UslugiConstants::Plugin_Text_Domain ),
				'new_item' => __( 'Нова услуга', UslugiConstants::Plugin_Text_Domain ),
				'view_item' => __( 'Разгледай услуга', UslugiConstants::Plugin_Text_Domain ),
				'search_items' => __( 'Потърси услуги', UslugiConstants::Plugin_Text_Domain ),
				'not_found' =>  __( 'Няма открити услуги', UslugiConstants::Plugin_Text_Domain ),
				'not_found_in_trash' => __( 'Няма открити изтрити услуги.', UslugiConstants::Plugin_Text_Domain ),
				),
			'description' => __( 'Услуги.', UslugiConstants::Plugin_Text_Domain ),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 40, // probably have to change, many plugins use this
			'supports' => array(
				'title',
				'thumbnail',
				'author',
				'editor',
				'page-attributes',
				//'custom-fields',
				),
		));		
	}	
	
	public function register_usluga_post_taxonomies() {
		// Service -> Type
		register_taxonomy(UslugiConstants::ServiceType_Taxonomy_Name, 
		Array(UslugiConstants::Usluga_Post_Name), 
		Array(
			'labels' => array(
					'name'                       => _x( 'Вид услуга', 'taxonomy general name' ),
					'singular_name'              => _x( 'Вид услуга', 'taxonomy singular name' ),
					'add_new_item'               => __( 'Добави нов вид услуга' ),
			),
			'rewrite' => array( 'slug' => 'ServiceType' ),
			'hierarchical' => true,
		));
		
		// Service -> Location
		register_taxonomy(UslugiConstants::Location_Taxonomy_Name,
		Array(UslugiConstants::Usluga_Post_Name),
		Array(
			'label' => __( 'Локация на услугата', UslugiConstants::Plugin_Text_Domain ),
			'rewrite' => array( 'slug' => 'Location' ),
			'hierarchical' => true,
		));
	}
}

// init plugin
new Uslugi_Plugin_Initializator();
