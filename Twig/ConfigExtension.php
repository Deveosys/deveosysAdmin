<?php 

namespace Deveosys\AdminBundle\Twig;

class ConfigExtension extends \Twig_Extension
{
	protected $configManager;

    public function __construct($configManager)
    {
        $this->configManager = $configManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
        	new \Twig_SimpleFunction('deveosys_admin_getConfig', array($this, 'getConfig')),
        );
    }

    public function getConfig()
    {
    	return $this->configManager->getConfig();
    }
}
