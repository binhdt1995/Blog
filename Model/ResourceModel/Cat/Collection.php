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

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
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
}
