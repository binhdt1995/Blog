<?php

namespace Abit\Blog\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface as MagentoUrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var MagentoUrlInterface
     */
    protected $_urlManager;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param MagentoUrlInterface $urlManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        MagentoUrlInterface $urlManager
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_urlManager = $urlManager;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->_urlManager->getBaseUrl($this->getBaseRoute());
    }

    /**
     * @return string
     */
    public function getBaseRoute()
    {
        return $this->_scopeConfig->getValue('abit/blog/route');
    }

    /**
     * @return string
     */
    public function getPostUrlSuffix()
    {
        return $this->_scopeConfig->getValue('abit/blog/url_post_suffix');
    }

    /**
     * @return string
     */
    public function getCatUrlSuffix()
    {
        return $this->_scopeConfig->getValue('abit/blog/url_cat_suffix');
    }

    /**
     * @return int
     */
    public function getPostPerPage()
    {
        return $this->_scopeConfig->getValue('abit/blog/post_per_page');
    }
}
