<?php

namespace Abit\Blog\Ui\Post\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Enabled')],
            ['value' => 2, 'label' => __('Disabled')],
            ['value' => 3, 'label' => __('Hidden')]
        ];
    }
}
