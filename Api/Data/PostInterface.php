<?php


namespace Abit\Blog\Api\Data;

/**
 * Abit Blog Post interface.
 * @api
 * @since 100.0.2
 */

interface PostInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const POST_ID                  = 'post_id';
    const IDENTIFIER               = 'identifier';
    const TITLE                    = 'title';
    const META_KEYWORDS            = 'meta_keywords';
    const META_DESCRIPTION         = 'meta_description';
    const CONTENT                  = 'content';
    const SHORT_CONTENT            = 'short_content';
    /**#@-*/

    /**
     * Get Post ID
     *
     * @return int|null
     */
    public function getPostId();

    /**
     * Get Identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get Title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get Content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get Short Content
     *
     * @return string|null
     */
    public function getShortContent();

    /**
     * Get Meta Keywords
     *
     * @return string|null
     */
    public function getMetaKeywords();

    /**
     * Get meta description
     *
     * @return string|null
     */
    public function getMetaDescription();

    /**
     * Set Post ID
     *
     * @param int $post_id
     * @return PostInterface
     */
    public function setPostId(int $post_id);

    /**
     * Set Identifier
     *
     * @param string $identifier
     * @return PostInterface
     */
    public function setIdentifier(string $identifier);

    /**
     * Set Title
     *
     * @param string $title
     * @return PostInterface
     */
    public function setTitle(string $title);

    /**
     * Set Content
     *
     * @param string $content
     * @return PostInterface
     */
    public function setContent(string $content);

    /**
     * Set Short Content
     *
     * @param string $shortContent
     * @return PostInterface
     */
    public function setShortContent(string $shortContent);

    /**
     * Set meta keywords
     *
     * @param string $metaKeywords
     * @return PostInterface
     */
    public function setMetaKeywords(string $metaKeywords);

    /**
     * Set meta description
     *
     * @param string $metaDescription
     * @return PostInterface
     */
    public function setMetaDescription(string $metaDescription);

}
