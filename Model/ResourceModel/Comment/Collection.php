<?php
/**
 * Abit_Blog Collection
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Model\ResourceModel\Comment;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * ID Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'comment_id';

    protected function _construct()
    {
        $this->_init('Abit\Blog\Model\Comment', 'Abit\Blog\Model\ResourceModel\Comment');
    }
}
