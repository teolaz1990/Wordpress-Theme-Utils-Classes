<?php 
/**
 * Contains ImageProgressiveLoading class definition
 */



/**
 * Takes care of image sequential loading with jQuery Cycle 2
 * @author etessore
 * @version 1.0.0
 * @package classes
 * @subpackage image manager
 */
class ImageProgressiveLoading extends GalleryHelper{
	
	public $cycle_attrs = array();
	
	/**
	 * Adds an attribute for the cycle div
	 * 
	 * Useful if you vant to customize jQuery.cycle 2 behavior
	 * 
	 * @param string $key the key
	 * @param string $value the value
	 * @return ImagePreload $this for chainability
	 */
	public function set_cycle_attr($key, $value){
		$this->cycle_attrs[$key] = $value;
		return $this;
	}
	
	/**
	 * Renders a single element of the slideshow
	 * @param int $k the index of the element in $this->images array
	 * @return string html markup for the given element
	 */
	private function render_element($k){
		$toret = HtmlHelper::image(
			$this->get_image_src($k), 
			array(
				'alt'			=>	$this->get_image_alt($k),
				'data-desc'		=>	$this->get_image_description($k),
				'data-caption'	=>	$this->get_image_caption($k),
				'id'			=>	$this->get_image_id($k),
				'width'			=>	$this->get_image_width($k),
				'height'		=>	$this->get_image_height($k)
			)
		);
		
		return $toret;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FeatureWithAssets::load_assets()
	 */
	public function load_assets(){
		ThemeHelpers::load_js('jquery.cycle2');
		//ThemeHelpers::load_js('slideshow2');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see GalleryHelper::get_markup()
	 */
	public function get_markup(){
		if(empty($this->images)){ return ''; }
		
		if(empty($this->unid)) $this->calculate_unique();
		
		$this->load_assets();		
		
		$list = array();
		
		foreach($this->images as $k => $image){
			$list[]	= $this->render_element($k);
		}
		
		$first_image = array_shift($list);
		
		/*$src = '/images/ajax-loader.gif';
		if(file_exists(get_stylesheet_directory().$src))
			$src = get_stylesheet_directory_uri().$src;
		
		if(file_exists(get_template_directory().$src))
			$src = get_template_directory_uri().$src;
		
		$first_image = HtmlHelper::image($src, array('id'=>'loading-gif'));*/
		
		$script = HtmlHelper::script(json_encode($list), array('id'=>'script_'.$this->unid));
		
		$defaults = array(
			'id'						=>	$this->unid, 
			'class'						=>	'cycle-slideshow', 
			'data-cycle-loader'			=>	'true',
			'data-cycle-progressive'	=>	'#script_'.$this->unid
		);
		
		return HtmlHelper::div(
				$first_image.$script, 
				wp_parse_args($this->cycle_attrs, $defaults)
			);
		
	}
}