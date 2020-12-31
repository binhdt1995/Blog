<?php


namespace Abit\Blog\Model;


class Tag extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Abit\Blog\Model\ResourceModel\Tag');
    }
}
