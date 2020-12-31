<?php

namespace Abit\Blog\Block\Post;

use Abit\Blog\Model\Cat;
use Abit\Blog\Model\PostFactory;
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

    public function __construct(
        Template\Context $context,
        PostFactory $postFactory,
        ScopeConfigInterface $scopeConfig,
        Registry $registry,
        array $data = []
    ) {
        $this->postFacory = $postFactory;
        $this->scopeConfig = $scopeConfig;
        $this->registry = $registry;
        $this->context = $context;
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