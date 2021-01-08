<?php


namespace Abit\Blog\Api\Data;

/**
 * Abit Blog Url interface.
 * @api
 * @since 100.0.2
 */

interface UrlInterface
{

    /**
     * Get Url
     *
     * @param array $urlParams
     * @return string
     */
    public function getUrl($urlParams = []);
}
