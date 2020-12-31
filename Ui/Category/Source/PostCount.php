<?php

namespace Abit\Blog\Ui\Category\Source;

use Magento\Framework\Data\ValueSourceInterface;

class PostCount implements ValueSourceInterface
{
    public function __construct()
    {
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
