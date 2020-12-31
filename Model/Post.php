<?php

namespace Abit\Blog\Model;

use Abit\Blog\Api\Data\PostInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface as MagentoUrlInterface;
use Magento\Store\Model\StoreManagerInterface;

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

    public function __construct(
        Context $context,
        Registry $registry,
        ResourceModel\Post $postResource = null,
        AbstractDb $resourceCollection = null,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
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

    public function getUrl()
    {
        $route = $this->scopeConfig->getValue('abit/blog/route', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $this->getBaseUrl() . $route . '/' . $this->getIdentifier();
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
        return $this->getBaseImageUrl() . $this->getData('filename');
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