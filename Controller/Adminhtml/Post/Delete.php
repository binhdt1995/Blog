<?php


namespace Abit\Blog\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

class Delete extends Action
{

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($post_id) {
            try {
                $model = $this->_objectManager->create('Abit\Blog\Model\Post');
                $model->load($post_id);
                $model->delete();
                $this->messageManager->addSuccess(__('The post has been deleted'));
                return $resultRedirect->setPath('abit_blog/post/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('abit_blog/post/edit', ['post_id' => $post_id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a post to delete.'));
        return $resultRedirect->setPath('abit_blog/post/index');
    }


    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abit_Blog::delete_post');
    }
}
