<?php
/**
 * Abit_Blog Post Collection
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Model\ResourceModel\Post;

use Abit\Blog\Api\Data\PostInterface;
use Abit\Blog\Model\ResourceModel\PostCollection;
use Magento\Store\Model\Store;

class Collection extends PostCollection
{
    /**
     * ID Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'post_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'abit_blog_post_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'abit_post_collection';

    protected function _construct()
    {
        $this->_init('Abit\Blog\Model\Post', 'Abit\Blog\Model\ResourceModel\Post');
        $this->_map['fields']['post_id'] = 'main_table.post_id';
        $this->_map['fields']['store_id'] = 'store_table.store_id';
    }

    /**
     * Set first store flag
     *
     * @param bool $flag
     * @return Collection
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }
    public function addCatFilter($catId)
    {
        $this->getSelect()->join(
            ['cat_table' => $this->getTable('aw_blog_post_cat')],
            'main_table.post_id = cat_table.post_id',
            []
        )
            ->where('cat_table.cat_id = ?', $catId);

        return $this;
    }

    /**
     * Add filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
            $this->setFlag('store_filter_added', true);
        }

        return $this;
    }

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $this->performAfterLoad('aw_blog_store', 'post_id');
        $this->_previewFlag = false;

        return parent::_afterLoad();
    }

    protected function _renderFiltersBefore()
    {
        $this->joinStoreRelationTable('aw_blog_store', 'post_id');
    }

    /**
     * Returns pairs block_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('post_id', 'title');
    }
}
