<?php

namespace Magecomp\Imageclean\Controller\Adminhtml\Imageclean;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
	
	public function __construct(\Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
	
	public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magecomp_Imageclean::imageclean');
        $resultPage->addBreadcrumb(__('Magecomp'), __('Magecomp'));
        $resultPage->addBreadcrumb(__('Imageclean'), __('Imageclean'));
        $resultPage->getConfig()->getTitle()->prepend(__('Images Manager'));
		
		$dataPersistor = $this->_objectManager->get('Magento\Framework\App\Request\DataPersistorInterface');
        $dataPersistor->clear('imageclean_data');
		
        return $resultPage;
    }
	
	protected function _isAllowed()
    {
		return $this->_authorization->isAllowed('Magecomp_Imageclean::imageclean');
    }
}
