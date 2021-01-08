<?php

namespace Abit\Blog\Model;

use Abit\Blog\Api\Data\CategoryInterface;
use Abit\Blog\Api\Data\UrlInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class Cat extends \Magento\Framework\Model\AbstractModel implements \Abit\Blog\Api\Data\CategoryInterface, UrlInterface
{
    /**
     * @var Url
     */
    protected $url;

    public function __construct(
        Context $context,
        Registry $registry,
        ResourceModel\Cat $catResource = null,
        AbstractDb $resourceCollection = null,
        Url $url,
        array $data = []
    ) {
        $this->url = $url;
        parent::__construct($context, $registry, $catResource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Abit\Blog\Model\ResourceModel\Cat');
    }

    /**
     * @param array $urlParams
     *
     * @return string
     */
    public function getUrl($urlParams = [])
    {
        return $this->url->getCategoryUrl($this, $urlParams);
    }

    /**
     * @return int|null
     */
    public function getCatId()
    {
        return $this->getData(self::CAT_ID);
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @return string|null
     */
    public function getMetaKeywords()
    {
        return $this->getData(self::META_KEYWORDS);
    }

    /**
     * @return string|null
     */
    public function getMetaDescription()
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * @param int $cat_id
     * @return CategoryInterface
     */
    public function setCatId(int $cat_id)
    {
        return $this->setData(self::CAT_ID);
    }

    /**
     * @param string $identifier
     * @return CategoryInterface
     */
    public function setIdentifier(string $identifier)
    {
        return $this->setData(self::IDENTIFIER);
    }

    /**
     * @param string $title
     * @return CategoryInterface
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::TITLE);
    }

    /**
     * @param string $metaKeywords
     * @return CategoryInterface
     */
    public function setMetaKeywords(string $metaKeywords)
    {
        return $this->setData(self::META_KEYWORDS);
    }

    /**
     * @param string $metaDescription
     * @return CategoryInterface
     */
    public function setMetaDescription(string $metaDescription)
    {
        return $this->setData(self::META_DESCRIPTION);
    }
}
