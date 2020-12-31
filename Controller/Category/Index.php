<?php

namespace Abit\Blog\Controller\Category;

use Abit\Blog\Model\CatFactory;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;

class Index extends Action
{
    /**
     * @var CatFactory
     */
    protected $catFactory;
    /**
     * @var Registry
     */
    protected $registry;

    public function __construct(
        Context $context,
        Registry $registry,
        CatFactory $catFactory
    ) {
        $this->catFactory = $catFactory;
        $this->registry = $registry;
        parent::__construct($context);
    }

    public function initCategory()
    {
        if ($id = $this->getRequest()->getParam('cat_id')) {
            $post = $this->catFactory->create()->load($id);
            if ($post->getId() > 0) {
                $this->registry->register('current_blog_cat', $post);

                return $post;
            }
        }
    }
    /**
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $resultPage;
    }
}
