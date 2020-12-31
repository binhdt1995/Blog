<?php
/**
 * Abit_Blog Post Ui Action
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Ui\Component\Listing\Cat\Column;

use Abit\Blog\Model\ResourceModel\Cat;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class PostCount extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Column name
     */
    const NAME = 'count';
    /**
     * @var Cat
     */
    protected $_category;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Cat $cat,
        array $components = [],
        array $data = []
    ) {
        $this->_category = $cat;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        foreach ($this->getData('options') as $category) {
            $Categories[$category->getCatId()] = $category->getPostCount();
        }

        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');

            foreach ($dataSource['data']['items'] as & $item) {
                var_dump($item);
                var_dump($item[$fieldName]);
                die();
                $item[$fieldName] = implode(', ', $postCount);
            }

        }
        return $dataSource;
    }
}
