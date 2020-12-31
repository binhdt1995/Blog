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

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /** Url path*/
    const POST_EDIT_URL = 'abit_blog/cat/addcat';
    /**
     * @var mixed|string
     */
    private $_editUrl;
    /**
     * @var UrlInterface
     */
    private $_urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::POST_EDIT_URL
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->_editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $actions = $this->getData('action_list');
                foreach ($actions as $key => $action) {
                    $params = $action['params'];
                    foreach ($params as $field => $param) {
                        $params[$field] = $item[$param];
                    }
                    $parameters = [];
                    if (isset($action['params']['id']) && isset($item[$action['params']['id']])) {
                        $parameters['id'] = $item[$action['params']['id']];
                    }
                    if (isset($action['params']['cat_id']) && isset($item[$action['params']['cat_id']])) {
                        $parameters['cat_id'] = $item[$action['params']['cat_id']];
                    }
                    $item[$this->getData('name')][$key] = [
                        'href'   => $this->_urlBuilder->getUrl($action['path'], $parameters),
                        'label'  => $action['label'],
                        'hidden' => false,
                    ];
                }
            }
        }
        return $dataSource;
    }
}
