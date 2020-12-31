<?php

namespace Abit\Blog\Controller\Post;

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

    public function __construct(
        Context $context,
        Post $postModel,
        Registry $coreRegistry,
        ForwardFactory $resultForwardFactory,
        ResultFactory $resultFactory
    ) {
        $this->_postModel = $postModel;
        $this->_coreRegistry = $coreRegistry;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    public function initPost()
    {
        $postId = (int)$this->getRequest()->getParam('post_id', false);
        if (!$postId) {
            return false;
        }
        try {
            $post = $this->_postModel->load($postId);
        } catch (\Exception $e) {
            return false;
        }
        $this->_coreRegistry->register('current_post', $post);
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $post = $this->initPost();

        if ($post) {
            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            return $resultPage;
        } else {
            return $this->resultForwardFactory->create()->forward('noroute');
        }
    }
}
