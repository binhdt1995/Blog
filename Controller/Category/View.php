<?php

namespace Abit\Blog\Controller\Category;

use Abit\Blog\Model\Cat;
use Abit\Blog\Model\Post;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Registry;
use Magento\Framework\Controller\ResultFactory;

class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Post
     */
    private $_postModel;
    /**
     * @var Registry
     */
    private $_coreRegistry;
    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;
    /**
     * @var Cat
     */
    protected $_catModel;

    public function __construct(
        Context $context,
        Post $postModel,
        Cat $catModel,
        Registry $coreRegistry,
        ForwardFactory $resultForwardFactory,
        ResultFactory $resultFactory
    ) {
        $this->_postModel = $postModel;
        $this->_catModel = $catModel;
        $this->_coreRegistry = $coreRegistry;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    public function initCategory()
    {
        $catId = (int)$this->getRequest()->getParam('cat_id', false);
        if (!$catId) {
            return false;
        }
        try {
            $category = $this->_catModel->load($catId);
        } catch (\Exception $e) {
            return false;
        }
        $this->_coreRegistry->register('current_blog_cat', $category);
        return $category;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $category= $this->initCategory();

        if ($category) {
            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            return $resultPage;
        } else {
            return $this->resultForwardFactory->create()->forward('noroute');
        }
    }
}
