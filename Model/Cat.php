<?php


namespace Abit\Blog\Model;


class Cat extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Abit\Blog\Model\ResourceModel\Cat');
    }
}
