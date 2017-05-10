<?php
namespace Magecomp\Imageclean\Controller\Adminhtml\Imageclean;

abstract class AbstractImageclean extends \Magento\Backend\App\Action {

    protected function _isAllowed() 
	{
        return $this->_authorization->isAllowed('Magecomp_Imageclean::imageclean');
    }






}
