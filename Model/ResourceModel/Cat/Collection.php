<?php
/**
 * Abit_Blog Collection
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Model\ResourceModel\Cat;


class Collection extends \Abit\Blog\Model\ResourceModel\CatCollection
{
    /**
     * ID Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'cat_id';

    protected function _construct()
    {
        $this->_init('Abit\Blog\Model\Cat', 'Abit\Blog\Model\ResourceModel\Cat');
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
    public function addPostFilter($postId)
    {
        $this->getSelect()->join(
            ['cat_table' => $this->getTable('aw_blog_post_cat')],
            'main_table.cat_id = cat_table.cat_id',
            []
        )
            ->where('cat_table.post_id = ?', $postId);

        return $this;
    }

    /**
     * @param $store
     * @param bool $withAdmin
     * @return mixed
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
     * Convert items array to array for select options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('cat_id', 'title');
    }

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $this->performAfterLoad('aw_blog_cat_store', 'cat_id');
        $this->performPostAfterLoad('aw_blog_post_cat', 'cat_id');
        $this->_previewFlag = false;

        return parent::_afterLoad();
    }
}
