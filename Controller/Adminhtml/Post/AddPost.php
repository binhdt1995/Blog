<?php

namespace Abit\Blog\Controller\Adminhtml\Post;

use Abit\Blog\Controller\Adminhtml\Post;

class AddPost extends Post
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultForward = $this->_forwardFactory->create();
        $resultForward->forward('edit');

        return $resultForward;
    }
}
