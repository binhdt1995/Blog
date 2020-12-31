<?php

namespace Abit\Blog\Model\Config\Source;

use Abit\Blog\Model\Tag;
use Magento\Framework\Data\OptionSourceInterface;

class Tags implements OptionSourceInterface
{


    /**
     * @var Tag
     */
    private $_tagModel;

    public function __construct(
        Tag $tagModel
    ) {
        $this->_tagModel = $tagModel;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $tags = $this->_tagModel->getCollection()->setOrder('tag', 'ASC');
        $options = [];

        foreach ($tags as $tag) {
            $options[] = [
                'value' => $tag->getId(),
                'label' => $tag->getTag()
            ];
        }
        return $options;
    }
}
