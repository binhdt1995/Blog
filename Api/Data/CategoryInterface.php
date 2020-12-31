<?php


namespace Abit\Blog\Api\Data;

/**
 * Abit Blog Post interface.
 * @api
 * @since 100.0.2
 */

interface CategoryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const CAT_ID                   = 'cat_id';
    const IDENTIFIER               = 'identifier';
    const TITLE                    = 'title';
    const META_KEYWORDS            = 'meta_keywords';
    const META_DESCRIPTION         = 'meta_description';
    /**#@-*/

    /**
     * Get Cat ID
     *
     * @return int|null
     */
    public function getCatId();

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
     * @param int $cat_id
     * @return CategoryInterface
     */
    public function setCatId(int $cat_id);

    /**
     * Set Identifier
     *
     * @param string $identifier
     * @return CategoryInterface
     */
    public function setIdentifier(string $identifier);

    /**
     * Set Title
     *
     * @param string $title
     * @return CategoryInterface
     */
    public function setTitle(string $title);


    /**
     * Set meta keywords
     *
     * @param string $metaKeywords
     * @return CategoryInterface
     */
    public function setMetaKeywords(string $metaKeywords);

    /**
     * Set meta description
     *
     * @param string $metaDescription
     * @return CategoryInterface
     */
    public function setMetaDescription(string $metaDescription);

}
