<?php

namespace Abit\Blog\Block\Post;

use Abit\Blog\Model\Cat;
use Abit\Blog\Model\PostFactory;
use Abit\Blog\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class PostList extends \Magento\Framework\View\Element\Template
{
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
        $collection = $this->postFacory->create()->getCollection()
            ->addFieldToFilter('status', 1)
            ->addStoreFilter($this->context->getStoreManager()->getStore()->getId());
        if ($category = $this->getCategory()) {
            $collection->addCatFilter($category->getId());
        }
        if ($this->config->getPostPerPage()) {
            $collection->setPageSize($this->config->getPostPerPage());
        }

        return $collection;
    }

    /**
     * Retrieve current category model object.
     * @return Cat
     */
    public function getCategory()
    {
        return $this->registry->registry('current_blog_cat');
    }
}
