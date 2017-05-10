<?php
namespace Magecomp\Imageclean\Model;

use Magento\Framework\Model\AbstractModel;

class Imageclean extends AbstractModel implements \Magento\Framework\DataObject\IdentityInterface {

	const CACHE_TAG = 'iimageclean_id';
	
    protected function _construct()
	{
        $this->_init('Magecomp\Imageclean\Model\ResourceModel\Imageclean');
    }
	
	public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
