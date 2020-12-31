<?php


namespace Abit\Blog\Controller\Adminhtml\Cat;


use Magento\Backend\Model\View\Result\Page;

class Edit extends \Abit\Blog\Controller\Adminhtml\Cat
{
    public function execute()
    {
        $catId = (int) $this->getRequest()->getParam('cat_id');

        $CategoryData = $this->_catFactory->create();
        /** @var Page $resultPage */
        if ($catId) {
            $CategoryData = $CategoryData->load($catId);
            if (!$CategoryData->getCatId()) {
                $this->messageManager->addError(__('Cat data no longer exits'));
                return false;
            }
        }
        $this->_coreRegistry->register('cat_data', $CategoryData);
        $resultPage = $this->_resultPageFactory->create();
        $title = $catId ? __('Edit Category') : __('Add Category');

        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abit_Blog::cat');
    }
}
