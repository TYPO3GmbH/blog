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
