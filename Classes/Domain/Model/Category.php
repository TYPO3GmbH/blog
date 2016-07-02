<?php
namespace T3G\AgencyPack\Blog\Domain\Model;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class Category
 *
 * This model is a representation of the sys_category table.
 * Categories can be assigned to blog posts.
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{

    /**
     * The additional content of the category. Used to enrich the SEO rating of category pages.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Content>
     */
    protected $content;

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentElementUidList()
    {
        $uidList = array();
        $contentElements = $this->getContent();
        if ($contentElements) {
            foreach ($contentElements as $contentElement) {
                $uidList[] = $contentElement->getUid();
            }
        }
        return implode(',', $uidList);
    }
}