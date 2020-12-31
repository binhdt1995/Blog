<?php


namespace Abit\Blog\Controller\Adminhtml\Post;


use Magento\Backend\Model\View\Result\Page;

class Edit extends \Abit\Blog\Controller\Adminhtml\Post
{
    public function execute()
    {
        $postId = (int) $this->getRequest()->getParam('post_id');

        $postData = $this->_postFactory->create();
        /** @var Page $resultPage */
        if ($postId) {
            $postData = $postData->load($postId);
            if (!$postData->getPostId()) {
                $this->messageManager->addError(__('Post data no longer exits'));
                return false;
            }
        }
        $this->_coreRegistry->register('post_data', $postData);
        $resultPage = $this->_resultPageFactory->create();
        $title = $postId ? __('Edit Post') : __('Add Post');

        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abit_Blog::post');
    }
}
