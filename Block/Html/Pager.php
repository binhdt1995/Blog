<?php

namespace Abit\Blog\Block\Html;

use Magento\Framework\App\ObjectManager;

class Pager extends \Magento\Theme\Block\Html\Pager
{
    protected $_entity;

    /**
     * Retrieve page URL by defined parameters
     *
     * @param array $params
     *
     * @return string
     */
    public function getPagerUrl($params = [])
    {
        $urlParams = [];
        $urlParams['_current'] = false;
        $urlParams['_escape'] = true;
        $urlParams['_query'] = $params;

        $path = $this->getUrl($this->getPath(), $urlParams);

        if ($this->getEntity()) {
            $path = $this->getEntity()->getUrl($urlParams);
        }

        return $path;
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        $config = ObjectManager::getInstance()->get('Abit\Blog\Model\Config');

        return $config->getBaseRoute();
    }

    public function getEntity()
    {
        return $this->_entity;
    }

    public function setEntity($entity)
    {
        $this->_entity = $entity;
        return $this;
    }
}
