<?php

namespace Abit\Blog\Controller\Adminhtml\Cat;

use Abit\Blog\Controller\Adminhtml\Cat;

class AddCat extends Cat
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
