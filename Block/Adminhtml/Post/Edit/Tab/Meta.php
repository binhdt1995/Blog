<?php

namespace Abit\Blog\Block\Adminhtml\Post\Edit\Tab;

use Abit\Blog\Model\Config\Source\Status;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Form\Renderer\Fieldset;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;

class Meta extends Generic implements TabInterface
{
    /**
     * @var Fieldset
     */
    private $_rendererFieldset;
    /**
     * @var Status
     */
    private $_status;
    /**
     * @var Config
     */
    private $_wysiwygConfig;
    /**
     * @var Store
     */
    private $_systemStore;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Fieldset $rendererFieldset
     * @param Status $status
     * @param Store $systemStore
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Fieldset $rendererFieldset,
        Status $status,
        Store $systemStore,
        array $data = []
    ) {
        $this->_rendererFieldset = $rendererFieldset;
        $this->_status = $status;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @inheritDoc
     */
    public function getTabLabel()
    {
        return __('General');
    }

    /**
     * @inheritDoc
     */
    public function getTabTitle()
    {
        return __('General');
    }

    /**
     * @inheritDoc
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('post_data');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('post_');
        $fieldset = $form->addFieldset(
            'blog_form',
            ['legend' => __('Meta Data')]
        );
        $wysiwygConfig = $this->_wysiwygConfig->getConfig();
        $fieldset->addField(
            'meta_keywords',
            'editor',
            [
                'name' => 'meta_keywords',
                'label' => __('Meta Keywords'),
                'title' => __('Meta Keywords'),
                'required' => false,
                'config' => $wysiwygConfig]
        );
        $fieldset->addField(
            'meta_description',
            'editor',
            [
                'name' => 'meta_description',
                'label' => __('Meta Description'),
                'title' => __('Meta Description'),
                'required' => false,
                'config' => $wysiwygConfig]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
