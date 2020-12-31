<?php

namespace Abit\Blog\Block\Post;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;
use Abit\Blog\Model\Cat;
use Abit\Blog\Model\Post;

class Recent extends Template
{
    /**
     * @var string
     */
    protected $_template = 'Abit_Blog::post/recent.phtml';


    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Context
     */
    protected $context;
    /**
     * @var Post
     */
    protected $_post;


    /**
     * @param Registry $registry
     * @param Context $context
     * @param Post $post
     * @param array $data
     */
    public function __construct(
        Registry $registry,
        Context $context,
        Post $post,
        array $data = []
    ) {
        $this->registry    = $registry;
        $this->context     = $context;
        $this->_post = $post;
        parent::__construct($context, $data);
    }

    /**
     * @return Post[]
     * @throws NoSuchEntityException
     */
    public function getCollection()
    {
        return $this->_post->getCollection()
            ->addFieldToFilter('status', 1)
            ->addStoreFilter($this->context->getStoreManager()->getStore()->getId());
    }


    /**
     * @return Cat|false
     */
    public function getCurrentCategory()
    {
        return $this->registry->registry('current_blog_category');
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        if ($this->getData('page_size')) {
            return (int)$this->getData('page_size');
        }

        return 5;
    }
}
