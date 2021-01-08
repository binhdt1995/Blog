<?php

namespace Abit\Blog\Block\Post\PostList;

use Abit\Blog\Api\Data\UrlInterface;
use Abit\Blog\Block\Html\Pager;
use Abit\Blog\Model\Post\PostList\Toolbar as ToolbarModel;
use Magento\Catalog\Model\Session;
use Magento\Framework\Data\Collection;
use Magento\Framework\Registry;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\Element\Template;

class Toolbar extends Template
{
    /**
     * @var Collection
     */
    protected $_collection;
    /**
     * @var ToolbarModel
     */
    protected $_toolbarModel;

    /**
     * @var EncoderInterface
     */
    protected $urlEncoder;

    /**
     * @var bool $_paramsMemorizeAllowed
     */
    protected $_paramsMemorizeAllowed = true;

    /**
     * @var string
     */
    protected $_template = 'Abit_Blog::post/list/toolbar.phtml';

    /**
     * List of available order fields
     *
     * @var array
     */
    protected $_availableOrder = null;

    /**
     * Default Order field
     *
     * @var string
     */
    protected $_orderField = null;

    /**
     * Default direction.
     * @var string
     */
    protected $direction = 'desc';
    /**
     * @var Registry
     */
    protected $_registry;

    public function __construct(
        Template\Context $context,
        Session $session,
        ToolbarModel $toolbarModel,
        EncoderInterface $urlEncoder,
        Registry $registry,
        array $data = []
    ) {
        $this->_session = $session;
        $this->_toolbarModel = $toolbarModel;
        $this->urlEncoder = $urlEncoder;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Disable list state params memorizing
     *
     * @return $this
     * @deprecated 103.0.1
     */
    public function disableParamsMemorizing()
    {
        $this->_paramsMemorizeAllowed = false;
        return $this;
    }

    /**
     * Memorize parameter value for session
     *
     * @param string $param parameter name
     * @param mixed $value parameter value
     * @return $this
     */
    protected function _memorizeParam(string $param, $value)
    {
        if ($this->_paramsMemorizeAllowed && !$this->_session->getParamsMemorizeDisabled()) {
            $this->_session->setData($param, $value);
        }
        return $this;
    }

    /**
     * Set collection to pager
     *
     * @param \Abit\Blog\Model\ResourceModel\Post\Collection $collection
     * @return $this
     */
    public function setCollection($collection)
    {
        $this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

        // we need to set pagination only if passed value integer and more that 0
        $limit = (int)$this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }
        if ($this->getCurrentOrder()) {
            if (($this->getCurrentOrder()) == 'position') {
                $this->_collection->addAttributeToSort(
                    $this->getCurrentOrder(),
                    $this->getCurrentDirection()
                );
            } else {
                $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
            }
        }
        return $this;
    }

    /**
     * Return products collection instance
     *
     * @return \Abit\Blog\Model\ResourceModel\Post\Collection
     */
    public function getCollection()
    {
        return $this->_collection;
    }

    /**
     * Return current page from request
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->_toolbarModel->getCurrentPage();
    }

    /**
     * Get grit products sort order field
     *
     * @return string
     */
    public function getCurrentOrder()
    {
        $order = $this->_getData('blog_current_order');

        if ($order) {
            return $order;
        }

        $orders       = $this->getAvailableOrders();
        $defaultOrder = $this->getOrderField();

        if (!isset($orders[$defaultOrder])) {
            $keys         = array_keys($orders);
            $defaultOrder = $keys[0];
        }

        $order = $this->_toolbarModel->getOrder();
        if (!$order || !isset($orders[$order])) {
            $order = $defaultOrder;
        }

        if ($order != $defaultOrder) {
            $this->_memorizeParam('sort_order', $order);
        }

        $this->setData('blog_current_order', $order);

        return $order;
    }

    /**
     * Retrieve available Order fields list.
     * @return array
     */
    public function getAvailableOrders()
    {
        $this->loadAvailableOrders();

        return $this->_availableOrder;
    }

    /**
     * @return string
     */
    protected function getOrderField()
    {
        if ($this->_orderField === null) {
            $this->_orderField = 'created_time';
        }

        return $this->_orderField;
    }

    /**
     * Retrieve current direction.
     * @return string
     */
    public function getCurrentDirection()
    {
        $dir = $this->_getData('blog_current_direction');
        if ($dir) {
            return $dir;
        }

        $directions = ['asc', 'desc'];
        $dir        = strtolower($this->_toolbarModel->getDirection());
        if (!$dir || !in_array($dir, $directions)) {
            $dir = $this->direction;
        }

        if ($dir != $this->direction) {
            $this->_memorizeParam('sort_direction', $dir);
        }

        $this->setData('blog_current_direction', $dir);

        return $dir;
    }

    /**
     * @return int
     */
    public function getLastNum()
    {
        $collection = $this->getCollection();

        return $collection->getPageSize() * ($collection->getCurPage() - 1) + $collection->count();
    }

    /**
     * @return int
     */
    public function getTotalNum()
    {
        return $this->getCollection()->getSize();
    }

    /**
     * @return bool
     */
    public function isFirstPage()
    {
        return $this->getCollection()->getCurPage() == 1;
    }

    /**
     * @return int
     */
    public function getLastPageNum()
    {
        return $this->getCollection()->getLastPageNumber();
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        $limit = $this->_getData('blog_current_limit');
        if ($limit) {
            return $limit;
        }

        $limits       = $this->getAvailableLimit();
        $defaultLimit = $this->getDefaultPerPageValue();
        if (!$defaultLimit || !isset($limits[$defaultLimit])) {
            $keys         = array_keys($limits);
            $defaultLimit = $keys[0];
        }

        $limit = $this->_toolbarModel->getLimit();
        if (!$limit || !isset($limits[$limit])) {
            $limit = $defaultLimit;
        }

        if ($limit != $defaultLimit) {
            $this->_memorizeParam('limit_page', $limit);
        }

        $this->setData('blog_current_limit', $limit);

        return $limit;
    }

    /**
     * @return array
     */
    public function getAvailableLimit()
    {
        return [10 => 10, 20 => 20, 50 => 50];
    }

    /**
     * Retrieve default per page values.
     * @return string (comma separated)
     */
    public function getDefaultPerPageValue()
    {
        if ($default = $this->getDefaultListPerPage()) {
            return $default;
        }

        return 10;
    }

    /**
     * Render pagination HTML
     *
     * @return string
     */
    public function getPagerHtml()
    {
        $pagerBlock = $this->getChildBlock('post_pager');

        if ($pagerBlock instanceof \Magento\Framework\DataObject) {
            /* @var $pagerBlock Pager */
            $pagerBlock->setAvailableLimit($this->getAvailableLimit());
            if ($this->getEntity()) {
                $pagerBlock->setEntity($this->getEntity());
            }
            $pagerBlock->setUseContainer(
                false
            )->setShowPerPage(
                false
            )->setShowAmounts(
                false
            )->setFrameLength(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setJump(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame_skip',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setLimit(
                $this->getLimit()
            )->setCollection(
                $this->getCollection()
            );

            return $pagerBlock->toHtml();
        }

        return '';
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public function getPagerEncodedUrl($params = [])
    {
        return $this->urlEncoder->encode($this->getPagerUrl($params));
    }

    /**
     * Return current URL with rewrites and additional parameters.
     *
     * @param array $params Query parameters.
     *
     * @return string
     */
    public function getPagerUrl($params = [])
    {
        $urlParams                 = [];
        $urlParams['_current']     = true;
        $urlParams['_escape']      = true;
        $urlParams['_use_rewrite'] = true;
        $urlParams['_query']       = $params;
        return $this->getUrl('*/*/*', $urlParams);
    }

    /**
     * Set default Order field
     *
     * @param string $field
     * @return $this
     */
    public function setDefaultOrder($field)
    {
        $this->loadAvailableOrders();
        if (isset($this->_availableOrder[$field])) {
            $this->_orderField = $field;
        }
        return $this;
    }

    /**
     * @return $this
     */
    private function loadAvailableOrders()
    {
        if ($this->_availableOrder === null) {
            $this->_availableOrder = [
                'created_time' => __('Date'),
                'title'       => __('Title'),
            ];
        }

        return $this;
    }

    /**
     * @return UrlInterface|null
     */
    public function getEntity()
    {
        $entity = null;

        if ($this->getCategory()) {
            $entity = $this->getCategory();
        }
        return $entity;
    }

    public function getCategory()
    {
        return $this->_registry->registry('current_blog_cat');
    }
}
