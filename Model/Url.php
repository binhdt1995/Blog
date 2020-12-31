<?php

namespace Abit\Blog\Model;

use Abit\Blog\Api\Data\CategoryInterface;
use Abit\Blog\Api\Data\PostInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Url as UrlManager;
use Magento\Store\Model\StoreManagerInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Url
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var UrlManager
     */
    protected $urlManager;
    /**
     * @var CatFactory
     */
    protected $catFactory;
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        PostFactory $postFactory,
        CatFactory $catFactory,
        UrlManager $urlManager,
        Config $config
    ) {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->postFactory = $postFactory;
        $this->catFactory = $catFactory;
        $this->urlManager = $urlManager;
        $this->config = $config;
    }

    /**
     * @param $post
     * @param bool $useSid
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPostUrl($post, $useSid = true)
    {
        $storeCode = $this->storeManager->getStore($post->getStoreId())->getCode();

        return $this->getUrl(
            '/' . $post->getIdentifier(),
            'post',
            ['_nosid' => !$useSid, '_scope' => $storeCode]
        );
    }

    /**
     * @param string $route
     * @param string $type
     * @param array $urlParams
     *
     * @return string
     */
    protected function getUrl(string $route, string $type, $urlParams = [])
    {
        $url = $this->urlManager->getUrl($this->config->getBaseRoute() . $route, $urlParams);

        if ($type == 'post' && $this->config->getPostUrlSuffix()) {
            $url = $this->addSuffix($url, $this->config->getPostUrlSuffix());
        }

        if ($type == 'category' && $this->config->getCatUrlSuffix()) {
            $url = $this->addSuffix($url, $this->config->getCatUrlSuffix());
        }

        return $url;
    }

    /**
     * @param string $url
     * @param string $suffix
     *
     * @return string
     */
    private function addSuffix($url, $suffix)
    {
        $parts = explode('?', $url, 2);
        $parts[0] = rtrim($parts[0], '/') . $suffix;

        return implode('?', $parts);
    }

    /**
     * @param Cat $category
     * @param array $urlParams
     *
     * @return string
     */
    public function getCategoryUrl($category, $urlParams = [])
    {
        return $this->getUrl('/' . $category->getIdentifier(), 'category', $urlParams);
    }

    /**
     * @param string $pathInfo
     *
     * @return bool|DataObject
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function match(string $pathInfo)
    {
        $identifier = trim($pathInfo, '/');
        $parts = explode('/', $identifier);

        if ($parts[0] != $this->scopeConfig->getValue('abit/blog/route', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)) {
            return false;
        }

        if (count($parts) == 2) {
            unset($parts[0]);
            $parts = array_values($parts);
            $urlKey = implode('/', $parts);
            $urlKey = urldecode($urlKey);
        } elseif (count($parts) == 3) {
            unset($parts[0]);
            unset($parts[1]);
            $parts = array_values($parts);
            $urlKey = implode('/', $parts);
            $urlKey = urldecode($urlKey);
        } else {
            $urlKey = '';
        }

        if ($urlKey == '') {
            return new DataObject([
                'module_name' => 'abit_blog',
                'controller_name' => 'category',
                'action_name' => 'index',
                'params' => [],
            ]);
        }

        if ($parts[0] == 'search') {
            return new DataObject([
                'module_name' => 'abit_blog',
                'controller_name' => 'search',
                'action_name' => 'result',
                'params' => [],
            ]);
        }

        $post = $this->postFactory->create()->getCollection()
            ->addFieldToFilter('identifier', $urlKey)
            ->getFirstItem();

        if ($post->getId()) {
            return new DataObject([
                'module_name' => 'abit_blog',
                'controller_name' => 'post',
                'action_name' => 'view',
                'params' => [PostInterface::POST_ID => $post->getId()],
            ]);
        }

        $category = $this->catFactory->create()->getCollection()
            ->addFieldToFilter('identifier', $urlKey)
            ->getFirstItem();

        if ($category->getId()) {
            return new DataObject([
                'module_name' => 'abit_blog',
                'controller_name' => 'category',
                'action_name' => 'view',
                'params' => [CategoryInterface::CAT_ID => $category->getId()],
            ]);
        }

        return false;
    }

    /**
     * Return url without suffix
     *
     * @param string $key
     *
     * @return string
     */
    protected function trimSuffix($key)
    {
        $suffix = $this->config->getCategoryUrlSuffix();
        //user can enter .html or html suffix
        if ($suffix != '' && $suffix[0] != '.') {
            $suffix = '.' . $suffix;
        }

        $key = str_replace($suffix, '', $key);

        $suffix = $this->config->getPostUrlSuffix();
        //user can enter .html or html suffix
        if ($suffix != '' && $suffix[0] != '.') {
            $suffix = '.' . $suffix;
        }

        $key = str_replace($suffix, '', $key);

        return $key;
    }
}
