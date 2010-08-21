<?php
/**
 * Tera_WURFL - PHP MySQL driven WURFL
 * 
 * Tera-WURFL was written by Steve Kamerman, and is based on the
 * Java WURFL Evolution package by Luca Passani and WURFL PHP Tools by Andrea Trassati.
 * This version uses a MySQL database to store the entire WURFL file, multiple patch
 * files, and a persistent caching mechanism to provide extreme performance increases.
 * 
 * @package TeraWurflUserAgentMatchers
 * @author Steve Kamerman <stevekamerman AT gmail.com>
 * @version Stable 2.1.2 $Date: 2010/05/14 15:53:02
 * @license http://www.mozilla.org/MPL/ MPL Vesion 1.1
 */
/**
 * Provides a specific user agent matching technique
 * @package TeraWurflUserAgentMatchers
 */
class OperaMiniUserAgentMatcher extends UserAgentMatcher {
	public function __construct(TeraWurfl $wurfl){
		parent::__construct($wurfl);
	}
	public function applyConclusiveMatch($ua) {
		$tolerance = UserAgentUtils::firstSlash($ua);
		$this->wurfl->toLog("Applying ".get_class($this)." Conclusive Match: RIS with threshold $tolerance",LOG_INFO);
		return $this->risMatch($ua, $tolerance);
	}
	public function recoveryMatch($ua){
       $this->wurfl->toLog("Applying ".get_class($this)." recovery match ($ua)",LOG_INFO);
    	if(self::contains($ua,"Opera Mini/1")){
    		return "opera_mini_ver1";
    	}
		if(self::contains($ua,"Opera Mini/2")){
    		return "opera_mini_ver2";
    	}
		if(self::contains($ua,"Opera Mini/3")){
    		return "opera_mini_ver3";
    	}
		if(self::contains($ua,"Opera Mini/4")){
    		return "opera_mini_ver4";
    	}
		if(self::contains($ua,"Opera Mobi")){
    		return "opera_mobi_ver4";
    	}
		return "opera_mini_ver1";
	}
}
