<?php
/**
 *
 * @category    Abit
 * @package     Abit_Blog
 * @copyright   Copyright (c) Abit (https://abit.vn/)
 * @author      Binhdt
 */

namespace Abit\Blog\Block\Adminhtml\Post\Edit;

/**
 * Class Tabs
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('post_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Post'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'main_info',
            [
                'label' => __('General Information'),
                'title' => __('General Information'),
                'content' => $this->getLayout()->createBlock(
                    \Abit\Blog\Block\Adminhtml\Post\Edit\Tab\Main::class,
                    'main_info_post'
                )->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'meta_info',
            [
                'label' => __('Meta Information'),
                'title' => __('General Information'),
                'content' => $this->getLayout()->createBlock(
                    'Abit\Blog\Block\Adminhtml\Post\Edit\Tab\Meta'
                )->toHtml(),
            ]
        );

        return parent::_beforeToHtml();
    }
}
