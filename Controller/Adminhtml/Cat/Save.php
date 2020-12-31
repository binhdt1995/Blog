<?php

namespace Abit\Blog\Controller\Adminhtml\Cat;

use Abit\Blog\Controller\Adminhtml\Post;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends Post
{
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('abit_blog/cat/addcat');
            return false;
        }

        try {
            $PostData = $this->_postFactory->create();
            $PostData->setData($data);

            if (isset($data['id'])) {
                $PostData->setPostId($data['id']);
            }

            if (!isset($data['identifier']) || $data['identifier'] == '') {
                $identifier = $this->_objectManager->get('Magento\Catalog\Model\Product\Url')->formatUrlKey($data['title']);
                $existIdentifier = $this->_objectManager->create('Abit\Blog\Model\Cat')->getCollection()->addFieldToFilter('identifier', ['eq' => $identifier]);

                if (count($existIdentifier)) {
                    $data['identifier'] = $this->prepareUrlKey($identifier);
                } else {
                    $data['identifier'] = $identifier;
                }
            }

            $PostData->setData($data);
            $PostData->save();
            $this->messageManager->addSuccess(__('Category data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('abit_blog/cat/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abit_Blog::save');
    }

    /**
     * Prepare url key.
     *
     * @param string $urlKey
     * @return string
     */
    protected function prepareUrlKey(string $urlKey)
    {
        preg_match("~\d+$~", $urlKey, $matches);
        if (empty($matches)) {
            $urlKey = $urlKey . '-1';
        } else {
            $key = (int)$matches[0] + 1;
            $urlKey = str_replace($matches[0], $key, $urlKey);
        }
        return $urlKey;
    }
}
