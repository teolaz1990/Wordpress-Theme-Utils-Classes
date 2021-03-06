<?php 
/**
 * Maintains the code for DefaultAssetsCDN class
 */

/**
 * Registers some assets from public available CDNs:
 * ajax.googleapis.com
 * cdnjs.cloudflare.com
 * cdn.jsdelivr.net
 * 
 * @author etessore
 * @since 1.0
 * @package classes
 * 
 */
class DefaultAssetsCDN extends DefaultAssets{
	/**
	 * (non-PHPdoc)
	 * @see DefaultAssets::register_standard()
	 */
	public function register_standard(){
		
		// some js libraries
		$this->assets_manager->add_js('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', null, '1.9.1', true);
		
		$this->assets_manager->add_js('jquery.imagesloaded', 'http://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/2.1.0/jquery.imagesloaded.min.js', array('jquery'), '2.1.0', true);
		$this->assets_manager->add_js('jquery.cycle', 'http://cdnjs.cloudflare.com/ajax/libs/jquery.cycle/2.9999.8/jquery.cycle.all.min.js', array('jquery'), '2.9999.8', true);
		$this->assets_manager->add_js('jquery.cycle2', 'http://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20130409/jquery.cycle2.min.js', array('jquery'), '20130409', true);
		$this->assets_manager->add_js('jquery.scrollto', 'http://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.3/jquery.scrollTo.min.js', array('jquery'), '1.4.3', true);
		$this->assets_manager->add_js('jquery-tinyscrollbar', 'http://cdnjs.cloudflare.com/ajax/libs/tinyscrollbar/1.66/jquery.tinyscrollbar.min.js', array('jquery'), '1.66', true);
		$this->assets_manager->add_js('jquery-fancybox', 'http://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.4/jquery.fancybox.pack.js', array('jquery'), '2.1.4', true);
		$this->assets_manager->add_js('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js', array('jquery'), '1.10.1', true);
		
		//Fblib, remember to fill the fbcallback.js in your child theme!
		$this->assets_manager->add_js('fbqs', 'http://static.fbwebprogram.com/fbcdn/fastqs/fastbooking_loader.php?v=1&callbackScriptURL='
				.get_stylesheet_directory_uri().'/js/fbcallback.js', array('jquery', 'jquery-ui'), '1', true);
		
		// Add This javascript
		$this->assets_manager->add_js('addthis', 'http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-5142f4961c6fb998', null, null, true);
		
		// some useful css
		$this->assets_manager->add_css('reset', 'http://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css', null, '2.0', 'screen');
		$this->assets_manager->add_css('grid-960', 'http://cdnjs.cloudflare.com/ajax/libs/960gs/0/960.css', null, '0.1', 'screen');
		
		$this->assets_manager->add_css('jquery-fancybox', '/css/jquery.fancybox_cdn.css', null, '2.1.0', 'screen');
		
		$this->register_jqueryui_themes()->register_webfonts();
		
		return $this;
	}
	
	/**
	 * Register some jQuery UI themes from code.jquery.com CDN
	 * @param array $themes list of theme names
	 * @return DefaultAssetsCDN $this for chainability
	 */
	protected function register_jqueryui_themes($themes=null){
		$themes = empty($themes) ? array('blitzer', 'smoothness', 'ui-darkness') : $themes;
		$version = '1.10.2';
		$min = '.min';
		
		foreach($themes as $theme){
			$this->assets_manager->add_css("jquery-ui-$theme", "http://code.jquery.com/ui/$version/themes/$theme/jquery-ui$min.css", null, $version, 'screen');
		}
		
		return $this;
	}
	
	/**
	 * Registers some Google Webfonts
	 * @param array $fonts list of font names
	 * @return DefaultAssetsCDN $this for chainability
	 */
	protected function register_webfonts($fonts=null){
		$fonts = empty($fonts) ? array('Marcellus') : $fonts;
		$version = '1.0.0';
		
		foreach($fonts as $font){
			$this->assets_manager->add_css("webfonts-$font", "http://fonts.googleapis.com/css?family=$font", null, $version, 'screen');
		}
		
		return $this;
	}
}