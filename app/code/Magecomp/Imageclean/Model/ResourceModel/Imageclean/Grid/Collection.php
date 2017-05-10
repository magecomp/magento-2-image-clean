<?php
namespace Magecomp\Imageclean\Model\ResourceModel\Imageclean\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Collection extends \Magecomp\Imageclean\Model\ResourceModel\Imageclean\Collection implements SearchResultInterface
{
	protected $aggregations;
	/**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
	protected $curstoreid;
	 
	public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
		ScopeConfigInterface $configScopeConfigInterface,
		\Magento\Framework\App\Request\Http $request,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }
	
	public function getAggregations()
    {
        return $this->aggregations;
    }
	
	public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }
	
	public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }
	
	public function getSearchCriteria()
    {
        return null;
    }
	
	public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }
	
	public function getTotalCount()
    {
        return $this->getSize();
    }
	
	public function setTotalCount($totalCount)
    {
        return $this;
    }
	
	public function setItems(array $items = null)
    {
        return $this;
    }
}