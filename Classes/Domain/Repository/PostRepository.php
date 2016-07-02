<?php
namespace T3G\AgencyPack\Blog\Domain\Repository;

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
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class PostRepository
 */
class PostRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultContraints = array();

    /**
     *
     */
    public function initializeObject() {
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        // don't add the pid constraint
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();
        $this->defaultContraints[] = $query->equals('doktype', Constants::DOKTYPE_BLOG_POST);

        $this->defaultOrderings = array(
            'crdate' => QueryInterface::ORDER_DESCENDING,
        );
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAll()
    {
        $query = $this->createQuery();
        return $query->matching($query->logicalAnd($this->defaultContraints))->execute();
    }

    /**
     * @param Category $category
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByCategory(Category $category)
    {
        $query = $this->createQuery();
        $contraints = $this->defaultContraints;
        $contraints[] = $query->contains('categories', $category);
        return $query->matching($query->logicalAnd($contraints))->execute();
    }

    /**
     * @return Post
     */
    public function findCurrentPost()
    {
        $pageId = (int)GeneralUtility::_GP('id');
        return $this->findByUid($pageId);
    }
}
