<?php
/**
 * Abit_Blog
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Block\Adminhtml\Post;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @var Registry
     */
    protected $_coreRegistry;

    public function __construct(
        Registry $coreRegistry,
        Context $context,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'post_id';
        $this->_blockGroup= 'Abit_Blog';
        $this->_controller = 'adminhtml_post';

        parent::_construct();
        if ($this->_isAllowedAction('Abit_Blog::post')) {
            $this->buttonList->update('save', 'label', __('Save'));
        } else {
            $this->buttonList->remove('save');
        }
        $this->buttonList->remove('reset');
    }

    /**
     * Check permission for passed action.
     *
     * @param string $resourceId
     *
     * @return bool
     */
    protected function _isAllowedAction(string $resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }

        return $this->getUrl('*/*/save');
    }
}
