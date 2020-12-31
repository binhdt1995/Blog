<?php
/**
 * Abit_Blog
 *
 * @category    Abit
 * @package     Abit_Blog
 * @author      Binhdt
 *
 */

namespace Abit\Blog\Controller\Adminhtml;

use Abit\Blog\Model\PostFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

class Post extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    /**
     * @var PostFactory
     */
    protected $_postFactory;
    /**
     * @var Registry
     */
    protected $_coreRegistry;
    /**
     * @var FileFactory
     */
    protected $_fileFactory;
    /**
     * @var ForwardFactory
     */
    protected $_forwardFactory;
    /**
     * @var DataPersistorInterface|null
     */
    protected $_dataPersistor;


    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        PostFactory $postFactory,
        FileFactory $fileFactory,
        Registry $coreRegistry,
        ForwardFactory $forwardFactory,
        DataPersistorInterface $dataPersistor = null
    ) {
        $this->_resultPageFactory = $pageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_postFactory = $postFactory;
        $this->_fileFactory = $fileFactory;
        $this->_forwardFactory = $forwardFactory;
        $this->_dataPersistor = $dataPersistor ?: ObjectManager::getInstance()->get(DataPersistorInterface::class);

        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Post'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abit_Blog::post');
    }
}
