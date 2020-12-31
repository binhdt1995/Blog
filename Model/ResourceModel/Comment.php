<?php


namespace Abit\Blog\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Comment extends AbstractDb
{

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('aw_blog_comment', 'comment_id');
    }
}
