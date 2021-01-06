<?php

namespace Abit\Blog\Model;

use Abit\Blog\Api\Data\PostInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface as MagentoUrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Post extends \Magento\Framework\Model\AbstractModel implements PostInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Url
     */
    protected $url;

    /**
     * @var WriteInterface
     */
    private $_mediaDirectory;

    public function __construct(
        Context $context,
        Registry $registry,
        ResourceModel\Post $postResource = null,
        AbstractDb $resourceCollection = null,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        Url $url,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->url = $url;
        parent::__construct($context, $registry, $postResource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Abit\Blog\Model\ResourceModel\Post');
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    public function getUrl($useSid = true)
    {
        return $this->url->getPostUrl($this, $useSid);
    }

    protected function getBaseImageUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(MagentoUrlInterface::URL_TYPE_MEDIA);
    }

    public function setCreatedTime($value)
    {
        return $this->setData('created_time', $value);
    }

    public function setUpdateTime($value)
    {
        return $this->setData('update_time', $value);
    }

    public function getFeaturedImageUrl()
    {
        if ($this->_mediaDirectory->isFile($this->getData('filename'))) {
            return $this->getBaseImageUrl() . $this->getData('filename');
        } else {
            return $this->getPlaceHolderImage();
        }
    }

    public function getPlaceHolderImage()
    {
        return $this->getBaseImageUrl() . 'catalog/product/placeholder/' . $this->scopeConfig->getValue('catalog/placeholder/small_image_placeholder');
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return parent::getData(self::POST_ID);
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return parent::getData(self::IDENTIFIER);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return parent::getData(self::TITLE);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return parent::getData(self::CONTENT);
    }

    /**
     * @return mixed
     */
    public function getShortContent()
    {
        return parent::getData(self::SHORT_CONTENT);
    }

    /**
     * @return mixed
     */
    public function getMetaKeywords()
    {
        return parent::getData(self::META_KEYWORDS);
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return parent::getData(self::META_DESCRIPTION);
    }

    /**
     * @param int $post_id
     * @return mixed
     */
    public function setPostId(int $post_id)
    {
        return parent::setData(self::POST_ID);
    }

    /**
     * @param string $identifier
     * @return mixed
     */
    public function setIdentifier(string $identifier)
    {
        return parent::setData(self::IDENTIFIER);
    }

    /**
     * @param string $title
     * @return mixed
     */
    public function setTitle(string $title)
    {
        return parent::setData(self::TITLE);
    }

    /**
     * @param string $content
     * @return mixed
     */
    public function setContent(string $content)
    {
        return parent::setData(self::CONTENT);
    }

    /**
     * @param string $shortContent
     * @return mixed
     */
    public function setShortContent(string $shortContent)
    {
        return parent::setData(self::SHORT_CONTENT);
    }

    /**
     * @param string $metaKeywords
     * @return mixed
     */
    public function setMetaKeywords(string $metaKeywords)
    {
        return parent::setData(self::META_KEYWORDS);
    }

    /**
     * @param string $metaDescription
     * @return mixed
     */
    public function setMetaDescription(string $metaDescription)
    {
        return parent::setData(self::META_DESCRIPTION);
    }
}
