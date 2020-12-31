<?php

namespace Abit\Blog\Model\ResourceModel;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

abstract class CatCollection extends AbstractCollection
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        MetadataPool $metadataPool,
        StoreManagerInterface $storeManager,
        AbstractDb $resource = null
    ) {
        $this->metadataPool = $metadataPool;
        $this->_storeManager = $storeManager;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    public function addFieldToFilter($field, $condition = null)
    {
        if ($field === 'store_id') {
            return $this->addStoreFilter($condition, false);
        }
        return parent::addFieldToFilter($field, $condition);
    }

    abstract public function addStoreFilter($store, $withAdmin = true);

    /**
     * Perform adding filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return void
     */
    protected function performAddStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Store) {
            $store = [$store->getId()];
        }

        if (!is_array($store)) {
            $store = [$store];
        }

        if ($withAdmin) {
            $store[] = Store::DEFAULT_STORE_ID;
        }

        $this->addFilter('store_id', ['in' => $store], 'public');
    }

    protected function joinStoreRelationTable($tableName, $columnName)
    {
        if ($this->getFilter('store_id')) {
            $this->getSelect()->join(
                ['store_table' => $this->getTable($tableName)],
                'main_table.' . $columnName . ' = store_table.' . $columnName,
                []
            )->group(
                'main_table.' . $columnName
            );
        }
        parent::_renderFiltersBefore();
    }

    /**
     * Perform operations after collection load
     *
     * @param string $tableName
     * @param string|null $linkField
     * @return void
     * @throws NoSuchEntityException
     */
    protected function performAfterLoad(string $tableName, ?string $linkField)
    {
        $linkedIds = $this->getColumnValues($linkField);

        if (count($linkedIds)) {
            $connection = $this->getConnection();
            $select = $connection->select()->from(['store_id' => $this->getTable($tableName)])
                ->where('store_id.' . $linkField . ' IN (?)', $linkedIds);

            $result = $connection->fetchAll($select);
            if ($result) {
                $storesData = [];
                foreach ($result as $storeData) {
                    $storesData[$storeData[$linkField]][] = $storeData['store_id'];
                }

                foreach ($this as $item) {
                    $linkedId = $item->getData($linkField);
                    if (!isset($storesData[$linkedId])) {
                        continue;
                    }
                    $storeIdKey = array_search(Store::DEFAULT_STORE_ID, $storesData[$linkedId], true);
                    if ($storeIdKey !== false) {
                        $stores = $this->_storeManager->getStores(false, true);
                        $storeId = current($stores)->getId();
                        $storeCode = key($stores);
                    } else {
                        $storeId = current($storesData[$linkedId]);
                        $storeCode = $this->_storeManager->getStore($storeId)->getCode();
                    }

                    $item->setData('store_code', $storeCode);
                    $item->setData('store_id', $storeId);
                }
            }
        }
    }

    /**
     * Perform operations after collection load
     *
     * @param string $tableName
     * @param string|null $linkField
     * @return void
     * @throws NoSuchEntityException
     */
    protected function performPostAfterLoad(string $tableName, ?string $linkField)
    {
        $linkedIds = $this->getColumnValues($linkField);

        if (count($linkedIds)) {
            $connection = $this->getConnection();
            $postsData = [];
            foreach ($linkedIds as $cat_id) {
                $select = $connection->select()->from(['pc' => $this->getTable($tableName)])
                    ->where('pc.' . $linkField . ' = (?)', $cat_id);
                $select->columns(['count' =>'COUNT(*)']);
                $result = $connection->fetchRow($select);
                $postsData[$cat_id] = $result['count'];
            }

            if (count($postsData)) {
                foreach ($this as $item) {
                    $item->setData('post_count', $postsData[$item->getCatId()]);
                }
            }
        }
    }
}
