<?php
/**
 * Abit_Blog
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Controller\Adminhtml\Post;


class Index extends \Abit\Blog\Controller\Adminhtml\Post
{
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Abit_Blog::post');
        $resultPage->getConfig()->getTitle()->prepend(__('Posts'));
        $resultPage->addBreadcrumb(__('Blog'), __('Blog'));
        $resultPage->addBreadcrumb(__('Manage Posts'), __('Manage Posts'));
        $this->_dataPersistor->clear('post');

        return $resultPage;
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abit_Blog::post');
    }
}
