<?php

namespace Abit\Blog\Block\Adminhtml\Post\Edit\Tab;

use Abit\Blog\Model\Config\Source\Category;
use Abit\Blog\Model\Config\Source\Status;
use Abit\Blog\Model\Config\Source\Tags;
use Abit\Blog\Model\Post;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Form\Renderer\Fieldset;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Magento\Config\Model\Config\Source\Yesno;

class Main extends Generic implements TabInterface
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
     * @var Category
     */
    private $_categories;
    /**
     * @var Tags
     */
    private $_tags;
    /**
     * @var Yesno
     */
    private $_yesNo;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Fieldset $rendererFieldset
     * @param Status $status
     * @param Yesno $yesNo
     * @param Category $category
     * @param Tags $tags
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
        Yesno $yesNo,
        Category $category,
        Tags $tags,
        Store $systemStore,
        array $data = []
    ) {
        $this->_rendererFieldset = $rendererFieldset;
        $this->_status = $status;
        $this->_yesNo = $yesNo;
        $this->_categories = $category;
        $this->_tags = $tags;
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

    /**
     * Prepare form fields
     *
     * @return Form
     */
    protected function _prepareForm()
    {
        /** @var $model Post */
        $model = $this->_coreRegistry->registry('post_data');

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('post_');
        $wysiwygConfig = $this->_wysiwygConfig->getConfig();
        if ($model->getPostId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Post'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('post_id', 'hidden', ['name' => 'post_id']);
            $fieldset->addField('created_time', 'hidden', ['name' => 'created_time']);
            $fieldset->addField('user', 'hidden', ['name' => 'user']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Post'), 'class' => 'fieldset-wide']
            );
        }
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'id' => 'title',
                'title' => __('Title'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'identifier',
            'text',
            [
                'name' => 'identifier',
                'label' => __('Identifier'),
                'title' => __('Identifier'),
                'required' => false,
                'class' => 'validate-identifier',
                'note' => 'eg: domain.com/blog/identifier',
            ]
        );
        $fieldset->addField(
            'featured',
            'select',
            [
                'name' => 'Featured',
                'label' => __('Featured'),
                'title' => __('Featured'),
                'values' => $this->_yesNo->toOptionArray()
            ]
        );
        $fieldset->addField(
            'filename',
            'image',
            [
                'name' => 'filename',
                'label' => __('Featured Image'),
                'title' => __('Featured Image'),
                'class' => 'abit_blog_image',
                'required' => false,
            ]
        );
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'store[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true)
                ]
            );
            $renderer = $this->getLayout()->createBlock('Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element');
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                [
                    'name' => 'store[]',
                    'values' => $this->_storeManager->getStore(true)->getId()
                ]
            );
        }
        $fieldset->addField(
            'cat_id',
            'multiselect',
            [
                'name' => 'cats[]',
                'label' => __('Categories'),
                'title' => __('Categories'),
                'required' => false,
                'style' => 'width: 30em;',
                'values' => $this->_categories->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'tags',
            'text',
            [
                'name' => 'tags',
                'label' => __('Tags'),
                'title' => __('Tags'),
                'required' => false,
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'id' => 'status',
                'title' => __('Status'),
                'values' => $this->_status->toOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'short_content',
            'editor',
            ['name' => 'short_content', 'label' => __('Short Content'), 'title' => __('Short Content'), 'required' => false, 'config' => $wysiwygConfig]
        );
        $fieldset->addField(
            'post_content',
            'editor',
            ['name' => 'post_content', 'label' => __('Content'), 'title' => __('Content'), 'required' => false, 'config' => $wysiwygConfig]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
