<?php
/**
 * Abit_Blog Collection
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Model\ResourceModel\Tag;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * ID Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Abit\Blog\Model\Tag', 'Abit\Blog\Model\ResourceModel\Tag');
    }
}
