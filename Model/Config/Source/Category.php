<?php

namespace Abit\Blog\Model\Config\Source;

use Abit\Blog\Model\Cat;
use Magento\Framework\Data\OptionSourceInterface;

class Category implements OptionSourceInterface
{

    /**
     * @var Cat
     */
    private $_catModel;

    public function __construct(
        Cat $catModel
    ) {
        $this->_catModel = $catModel;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $categories = $this->_catModel->getCollection()->setOrder('sort_order', 'asc');
        $options = [];

        foreach ($categories as $category) {
            $options[] = [
                'value' => $category->getCatId(),
                'label' => $category->getTitle()
            ];
        }
        return $options;
    }
}
