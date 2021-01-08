<?php

namespace Abit\Blog\Model\Post\PostList;

use Magento\Framework\App\Request\Http;

class Toolbar
{
    /**
     * GET parameter page variable name
     */
    const PAGE_PARM_NAME = 'p';

    /**
     * Sort order cookie name
     */
    const ORDER_PARAM_NAME = 'article_list_order';

    /**
     * Sort direction cookie name
     */
    const DIRECTION_PARAM_NAME = 'article_list_dir';

    /**
     * Sort mode cookie name
     */
    const MODE_PARAM_NAME = 'article_list_mode';

    /**
     * Products per page limit order cookie name
     */
    const LIMIT_PARAM_NAME = 'article_list_limit';

    /**
     * @var Http
     */
    protected $_request;

    /**
     * @param Http $request
     */
    public function __construct(
        Http $request
    ) {
        $this->_request = $request;
    }

    /**
     * Get sort order
     *
     * @return string|bool
     */
    public function getOrder()
    {
        return $this->_request->getParam(self::ORDER_PARAM_NAME);
    }

    /**
     * Get sort direction
     *
     * @return string|bool
     */
    public function getDirection()
    {
        return $this->_request->getParam(self::DIRECTION_PARAM_NAME);
    }

    /**
     * Get sort mode
     *
     * @return string|bool
     */
    public function getMode()
    {
        return $this->_request->getParam(self::MODE_PARAM_NAME);
    }

    /**
     * Get products per page limit
     *
     * @return string|bool
     */
    public function getLimit()
    {
        return $this->_request->getParam(self::LIMIT_PARAM_NAME);
    }

    /**
     * Return current page from request
     *
     * @return int
     */
    public function getCurrentPage()
    {
        $page = (int)$this->_request->getParam(self::PAGE_PARM_NAME);
        return $page ?: 1;
    }
}
