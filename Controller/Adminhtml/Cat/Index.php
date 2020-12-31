<?php
/**
 * Abit_Blog
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Controller\Adminhtml\Cat;


class Index extends \Abit\Blog\Controller\Adminhtml\Cat
{
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Abit_Blog::cat');
        $resultPage->getConfig()->getTitle()->prepend(__('Category'));
        $resultPage->addBreadcrumb(__('Blog'), __('Blog'));
        $resultPage->addBreadcrumb(__('Manage Category'), __('Manage Category'));
        $this->_dataPersistor->clear('cat');

        return $resultPage;
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abit_Blog::cat');
    }
}
