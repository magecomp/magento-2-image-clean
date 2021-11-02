<?php

namespace Magecomp\Imageclean\Controller\Adminhtml\Imageclean;

use Magecomp\Imageclean\Model\ImagecleanFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem\DirectoryList;

class Delete extends AbstractImageclean
{
    /**
     * @var ImagecleanFactory
     */
    protected $_modelImagecleanFactory;
    protected $directoryList;

    public function __construct(Context $context, 
        ImagecleanFactory $modelImagecleanFactory,
        DirectoryList $directoryList)
    {
        $this->_modelImagecleanFactory = $modelImagecleanFactory;
        $this->directoryList = $directoryList;
        parent::__construct($context);
    }

    public function execute() {
        if ($this->getRequest()->getParam('id') > 0) 
        {
            try 
            {
                $rootPath  =  $this->directoryList->getRoot();
                $mediaPath =  $rootPath.DIRECTORY_SEPARATOR.'pub'.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR.'product';
                $model = $this->_modelImagecleanFactory->create();
                $model->load($this->getRequest()->getParam('id'));
                $filename=$model->getFilename();
                $model->setId($this->getRequest()->getParam('id'))->delete();
                $this->messageManager->addSuccess(__('Image was successfully deleted'));
                unlink($mediaPath.$filename);
               
                $this->_redirect('*/*/');
            } 
            catch (\Exception $e) 
            {
               // $this->messageManager->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }
        $this->_redirect('*/*/');
    }
}