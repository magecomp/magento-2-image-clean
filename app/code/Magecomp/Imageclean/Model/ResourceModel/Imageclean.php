<?php
namespace Magecomp\Imageclean\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Imageclean extends AbstractDb {

    protected function _construct() 
	{
        $this->_init('imageclean', 'imageclean_id');
    }

}
