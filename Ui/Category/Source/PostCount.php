<?php

namespace Abit\Blog\Ui\Category\Source;

use Abit\Blog\Model\ResourceModel\Cat;
use Magento\Framework\Data\ValueSourceInterface;

class PostCount implements ValueSourceInterface
{
    /**
     * @var Cat
     */
    private $_category;

    public function __construct(
        Cat $cat
    ) {
        $this->_category = $cat;
    }

    /**
     * Get count post in category
     *
     * @return int
     */
    public function getValue($name)
    {
        return 1;
    }
}
