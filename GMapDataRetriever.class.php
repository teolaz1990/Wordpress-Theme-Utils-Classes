<?php 
/**
 * Stores the GMapDataRetriever class definition
 */

/**
 * Retrieves GMaps data for the gmap.js integration
 * @author etessore
 * @version 1.0
 * @package classes
 */
class GMapDataRetriever {
	/**
	 * @var array stores some map data
	 */
	private $map_data;
	
	
	/**
	 * Set the map data to the given set
	 * @param array $map_data the map data
	 * @return GMapDataRetriever $this for chainability
	 */
	public function set_map_data($map_data){
		$this->map_data = $map_data;
		return $this;
	}
	
	/**
	 * Set the class to get map datas from the Simple fields plugin
	 * Checks if the plugin is enabled.
	 * @return GMapDataRetriever $this for chainability
	 */
	public function use_simple_fields(){
		if(!function_exists('simple_fields_get_post_group_values')){
			wp_die('You need Simple Fields to be Up And Running!');
		}
		
		$default = array(
				'Map'			=>	array(
					array(
						'lat'	=>	0, 
						'lng'	=>	0		
					)
				),
				'Title'			=>	array(''),
				'Description'	=>	array(''),
				'Balloon Text'	=>	array('')
		);
		
		$map_data = simple_fields_get_post_group_values(get_the_ID(),'Map Data');
		
		if(!empty($map_data)) ThemeHelpers::load_js('map');
		
		$map_data = wp_parse_args($map_data, $default);
		
		if(function_exists('simple_fields_field_googlemaps_register')){
			//vd($map_data);
			$data = array(
				'center'	=>	array(
						'lat' 		=>	floatval($map_data['Map'][0]['lat']),
						'lng'		=>	floatval($map_data['Map'][0]['lng'])
				),
				'point'		=>	array(
						'lat'		=>	floatval($map_data['Map'][0]['lat']),
						'lng'		=>	floatval($map_data['Map'][0]['lng'])
				),
				'zoom'		=>	intval($map_data['Map'][0]['preferred_zoom']),
				'type'		=>	$map_data['Map Type'][0],
				'title'		=>	$map_data['Title'][0],
				'content'	=>	str_replace(
						array('%book%'),
						array('<a class="book-action" href="javascript:;">'.__('book','theme').'</a>'),
						$map_data['Balloon Text'][0]
				),
				'book_trans'	=>	__('book','theme')
			);
		} else {
			$data = array(
				'center'	=>	array(
					'lat' 		=>	floatval(
						empty($map_data['Center Latitude'][0])
						? $map_data['Latitude'][0]
						: $map_data['Center Latitude'][0]
					),
					'lng'		=>	floatval(
						empty($map_data['Center Longitude'][0])
						? $map_data['Longitude'][0]
						: $map_data['Center Longitude'][0]
					)
				),
				'point'		=>	array(
					'lat'		=>	floatval($map_data['Latitude'][0]),
					'lng'		=>	floatval($map_data['Longitude'][0])
				),
				'zoom'		=>	intval($map_data['Zoom'][0]),
				'type'		=>	$map_data['Map Type'][0],
				'title'		=>	$map_data['Balloon Title'][0],
				'content'	=>	str_replace(
					array('%book%'),
					array('<a class="book-action" href="javascript:;">'.__('book','theme').'</a>'),
					$map_data['Balloon Text'][0]
				),
				'book_trans'	=>	__('book','theme')
			);
		}
		
		return $this->set_map_data($data);
	}
	
	/*
	public function use_shared_datastore(){
		
	}*/
	
	
	/**
	 * Get a <script> tag with a JSON variable in it.
	 * @example GMapDataRetriever.example.json
	 * @return string
	 */
	function get_script_content(){
		return HtmlHelper::script('var map_info = ' . json_encode($this->map_data));
	}
	
	/**
	 * Prints the <scrpt> tag generated by get_script_content to the DOM
	 */
	function the_script(){
		echo $this->get_script_content();
	}
}


