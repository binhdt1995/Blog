<?php

namespace Abit\Blog\Block\Post;

use Abit\Blog\Model\Cat;
use Abit\Blog\Model\Config;
use Abit\Blog\Model\PostFactory;
use Abit\Blog\Model\ResourceModel\Post\Collection;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use function GuzzleHttp\Promise\queue;

class PostList extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $defaultToolbarBlock = 'Abit\Blog\Block\Post\PostList\Toolbar';

    /**
     * @var PostFactory
     */
    protected $postFacory;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var Registry
     */
    protected $registry;
    /**
     * @var Template\Context
     */
    protected $context;
    /**
     * @var Config
     */
    protected $config;

    public function __construct(
        Template\Context $context,
        PostFactory $postFactory,
        Config $config,
        ScopeConfigInterface $scopeConfig,
        Registry $registry,
        array $data = []
    ) {
        $this->postFacory = $postFactory;
        $this->scopeConfig = $scopeConfig;
        $this->registry = $registry;
        $this->context = $context;
        $this->config = $config;
        parent::__construct($context, $data);
    }

    public function getPosts()
    {
        $toolbar = $this->getToolbarBlock();

        $collection = $this->postFacory->create()->getCollection()
            ->addFieldToFilter('status', 1)
            ->addStoreFilter($this->context->getStoreManager()->getStore()->getId());
        if ($category = $this->getCategory()) {
            $collection->addCatFilter($category->getId());
        }
        $collection->setCurPage($this->getCurrentPage());

//        if ($this->config->getPostPerPage()) {
//            $collection->setPageSize($this->config->getPostPerPage());
//        }

        return $collection;
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout(); // TODO: Change the autogenerated stub
    }

    /**
     * Retrieve current category model object.
     * @return Cat
     */
    public function getCategory()
    {
        return $this->registry->registry('current_blog_cat');
    }

    /**
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    /**
     * @return PostList\Toolbar
     * @throws LocalizedException
     */
    public function getToolbarBlock()
    {
        $blockName = $this->getToolbarBlockName();

        if ($blockName) {
            $block = $this->getLayout()->getBlock($blockName);
            if ($block) {
                return $block;
            }
        }

        $block = $this->getLayout()->createBlock($this->defaultToolbarBlock, uniqid(microtime()));

        return $block;
    }

    protected function _beforeToHtml()
    {
        $toolbar = $this->getToolbarBlock();

        $collection = $this->getPosts();

        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);

        $this->setCollection($toolbar->getCollection());

        $this->getPosts()->load();

        return parent::_beforeToHtml(); // TODO: Change the autogenerated stub
    }

    /**
     * @param Collection $collection
     *
     * @return $this
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }
}
