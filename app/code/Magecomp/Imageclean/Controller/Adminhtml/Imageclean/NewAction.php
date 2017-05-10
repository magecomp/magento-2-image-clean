<?php

namespace Magecomp\Imageclean\Controller\Adminhtml\Imageclean;

use Magecomp\Imageclean\Helper\Data as HelperData;
use Magento\Backend\App\Action\Context;

class NewAction extends AbstractImageclean
{
    /**
     * @var HelperData
     */
    protected $_helperData;

    public function __construct(Context $context, 
        HelperData $helperData)
    {
        $this->_helperData = $helperData;

        parent::__construct($context);
    }

    public function execute() {
        $this->_helperData->compareList();
        $this->_redirect('*/*/');
    }
}
