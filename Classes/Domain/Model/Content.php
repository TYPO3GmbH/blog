<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class Content.
 *
 * The additional content for tags and categories.
 * This model is a representation of the tt_content table and
 * used to enrich the SEO rating of tag and category pages.
 * Content can be assigned to blog tags and blog categories.
 */
class Content extends AbstractEntity
{
}
