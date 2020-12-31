<?php

namespace Abit\Blog\Controller\Adminhtml\Post;

use Abit\Blog\Controller\Adminhtml\Post;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends Post
{
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('abit_blog/post/addpost');
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
                $existIdentifier = $this->_objectManager->create('Abit\Blog\Model\Post')->getCollection()->addFieldToFilter('identifier', ['eq' => $identifier]);

                if (count($existIdentifier)) {
                    $data['identifier'] = $this->prepareUrlKey($identifier);
                } else {
                    $data['identifier'] = $identifier;
                }
            }

            if (isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
                $uploader = $this->_objectManager->create(
                    \Magento\MediaStorage\Model\File\Uploader::class,
                    ['fileId' => 'filename']
                );
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'svg']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setAllowCreateFolders(true);
                $uploader->setFilesDispersion(true);
                $ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);

                if ($uploader->checkAllowedExtension($ext)) {
                    $path = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('blog/');

                    $uploader->save($path);
                    $fileName = $uploader->getUploadedFileName();
                    if ($fileName) {
                        $data['filename'] = 'blog' . $fileName;
                    }
                } else {
                    $this->messageManager->addError(__('Disallowed file type.'));
                    return $this->redirectToEdit($PostData, $data);
                }
            } else {
                if (isset($data['filename']['delete']) && $data['filename']['delete'] == 1) {
                    $data['filename'] = '';
                } else {
                    unset($data['filename']);
                }
            }


            if (isset($data['created_time']) && $data['created_time']) {
                $data['update_time'] = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate();
            } else {
                $data['created_time'] = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate();
                $data['update_time'] = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate();
            }

            $userData = $this->_objectManager->get('Magento\Backend\Model\Auth\Session')->getUser()->getData();
            if (isset($data['user']) && $data['user']) {
                $data['update_user'] = $userData['firstname'] . ' ' . $userData['lastname'];
            } else {
                $data['user'] = $userData['firstname'] . ' ' . $userData['lastname'];
            }

            $PostData->setData($data);
            $PostData->save();
            $this->messageManager->addSuccess(__('Post data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('abit_blog/post/index');
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
