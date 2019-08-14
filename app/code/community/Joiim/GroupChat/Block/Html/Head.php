<?php

class Joiim_GroupChat_Block_Html_Head extends Mage_Page_Block_Html_Head
{
    /**
     * Initialize template
     *
     */
    protected function _construct()
    {
        $this->setTemplate('page/html/head.phtml');
    }


    /**
     * Add HEAD External Item
     *
     * Allowed types:
     *  - js
     *  - js_css
     *  - skin_js
     *  - skin_css
     *  - rss
     *
     * @param string $type
     * @param string $name
     * @param string $params
     * @param string $if
     * @param string $cond
     * @return Mage_Page_Block_Html_Head
     */
    public function addExternalItem($type, $name, $params=null, $if=null, $cond=null)
    {
    	parent::addItem($type, $name, $params, $if, $cond);
    }

    /**
     * Remove External Item from HEAD entity
     *
     * @param string $type
     * @param string $name
     * @return Mage_Page_Block_Html_Head
     */
    public function removeExternalItem($type, $name)
    {
    	parent::removeItem($type, $name);
    }
    
    /**
     * Add Joiim Meta tags for Head entity
     *
     */
    public function addJoiimMetaTags()
    {
		$enabled = Mage::getStoreConfig('joiimsettings/joiimstorevalues/enabled');
	 	$this->addItem('meta', 'joiim:enabled', $enabled);
	 	
	 	$debugged = Mage::getStoreConfig('joiimsettings/joiimstorevalues/debug');
	 	$this->addItem('meta', 'joiim:debug', $debugged);
	 	
        $siteId = Mage::getStoreConfig('joiimsettings/joiimstorevalues/site_id');
        $this->addItem('meta', 'joiim:site_id', $siteId);
    }
    
    /**
     * Classify HTML head item and queue it into "lines" array
     *
     * @see self::getCssJsHtml()
     * @param array &$lines
     * @param string $itemIf
     * @param string $itemType
     * @param string $itemParams
     * @param string $itemName
     * @param array $itemThe
     */
    protected function _separateOtherHtmlHeadElements(&$lines, $itemIf, $itemType, $itemParams, $itemName, $itemThe)
    {
        $params = $itemParams ? $itemParams : '';
        $href   = $itemName;
        switch ($itemType) {
            case 'rss':
                $lines[$itemIf]['other'][] = sprintf('<link href="%s" %s rel="alternate" type="application/rss+xml" />',
                    $href, $params
                );
                break;
            case 'link_rel':
                $lines[$itemIf]['other'][] = sprintf('<link %s href="%s" />', $params, $href);
                break;
            
            case 'external_js':
                $lines[$itemIf]['other'][] = sprintf('<script type="text/javascript" src="%s" %s></script>', $href, $params);
                break;
                            
            case 'external_css':
                $lines[$itemIf]['other'][] = sprintf('<link rel="stylesheet" type="text/css" href="%s" %s/>', $href, $params);
                break;

            case 'meta':
                $lines[$itemIf]['other'][] = sprintf('<meta name="%s" content="%s" />', $href, $params);
                break;
        }
    }

}
