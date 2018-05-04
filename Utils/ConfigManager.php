<?php 

namespace Deveosys\AdminBundle\Utils;

/**
* 
*/
class ConfigManager
{
	protected $configs;

	function __construct($configs)
	{
		$this->configs = $configs;
	}

	public function getConfig()
	{
		return $this->configs;
	}
}