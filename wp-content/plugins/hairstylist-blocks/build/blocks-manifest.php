<?php
// This file is generated. Do not modify it manually.
return array(
	'test-block' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'frizer/test-block',
		'version' => '0.1.0',
		'title' => 'Test Block',
		'category' => 'frizer-custom-blocks',
		'icon' => 'table-col-after',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'test-block',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'top-header' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'frizer/top-header',
		'version' => '0.1.0',
		'title' => 'Top Header',
		'category' => 'frizer-custom-blocks',
		'icon' => 'table-col-after',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'wide'
			)
		),
		'attributes' => array(
			'location_text' => array(
				'type' => 'object'
			),
			'working_hours' => array(
				'type' => 'string'
			),
			'social_links' => array(
				'type' => 'object'
			),
			'cta_phone' => array(
				'type' => 'object'
			)
		),
		'textdomain' => 'top-header',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	)
);
