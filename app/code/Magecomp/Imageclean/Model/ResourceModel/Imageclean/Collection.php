<?php
namespace Magecomp\Imageclean\Model\ResourceModel\Imageclean;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Psr\Log\LoggerInterface;

class Collection extends AbstractCollection 
{
	protected $_idFieldName = 'imageclean_id';
	protected $total;
    public function __construct(EntityFactoryInterface $entityFactory, 
        LoggerInterface $logger, 
        FetchStrategyInterface $fetchStrategy, 
        ManagerInterface $eventManager, 
        AdapterInterface $connection = null, 
        AbstractDb $resource = null)
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    public function _construct()
    {
        $this->_init('Magecomp\Imageclean\Model\Imageclean','Magecomp\Imageclean\Model\ResourceModel\Imageclean');
    }

    public function getImages() 
	{
		$array = [];
        try {
            $this->setConnection($this->getResource()->getConnection());
            $this->getSelect()->from(['main_table' => $this->getTable('catalog_product_entity_media_gallery')], '*')
                ->group(['value_id']);

            foreach ($this->getData() as $item) {
                $array[] = $item['value'];
            }
        } 
		catch (\Exception $e) 
		{
			$om = \Magento\Framework\App\ObjectManager::getInstance();
			$storeManager = $om->get('Psr\Log\LoggerInterface');
			$storeManager->info($e->getMessage());
        }
        return $array;
    }

}
