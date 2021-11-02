<?php
namespace Magecomp\Imageclean\Controller\Adminhtml\Imageclean;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magecomp\Imageclean\Model\ResourceModel\Imageclean\CollectionFactory;
use Magecomp\Imageclean\Model\ImagecleanFactory;
use Magento\Framework\Filesystem\DirectoryList;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    /**
     * @var ImagecleanFactory
     */
    protected $_modelImagecleanFactory;
    protected $directoryList;

    public function __construct(Context $context, 
        Filter $filter, 
        CollectionFactory $collectionFactory,
         ImagecleanFactory $modelImagecleanFactory,
        DirectoryList $directoryList)
    {
        
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_modelImagecleanFactory = $modelImagecleanFactory;
        $this->directoryList = $directoryList;
        parent::__construct($context);
    }

    public function execute() 
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $rootPath  =  $this->directoryList->getRoot();
        $mediaPath = $rootPath.DIRECTORY_SEPARATOR.'pub'.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR.'product';
        foreach ($collection as $item) 
        {
            try {
                $model = $this->_modelImagecleanFactory->create();
                $model->load($item->getImagecleanId());
                $filename = $model->getFilename();
                $item->delete();
                unlink($mediaPath . $filename);
            }
            catch (\Exception $e)
            {
                //$this->messageManager->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $item->getImagecleanId()]);
            }
        }

        $this->messageManager->addSuccess(__('A total of %1 image(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');

    }
}