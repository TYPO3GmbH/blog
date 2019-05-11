<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

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
use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class PostRepository.
 */
class PostRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultConstraints = [];

    /**
     * @throws \Exception
     */
    public function initializeObject(): void
    {
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        // don't add the pid constraint
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
        $query = $this->createQuery();

        $this->defaultConstraints[] = $query->equals('doktype', Constants::DOKTYPE_BLOG_POST);
        $this->defaultOrderings = [
            'publish_date' => QueryInterface::ORDER_DESCENDING,
        ];
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAll()
    {
        return $this->getFindAllQuery()->execute();
    }

    /**
     * @param int $blogSetup
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByPid(int $blogSetup = null)
    {
        $query = $this->getFindAllQuery();

        if ($blogSetup !== null) {
            $existingConstraint = $query->getConstraint();
            $additionalConstraint = $query->equals('pid', $blogSetup);
            $query->matching($query->logicalAnd([
                $existingConstraint,
                $additionalConstraint
            ]));
        }

        return $query->execute();
    }

    /**
     * @param int $limit
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException#
     */
    public function findAllWithLimit(int $limit)
    {
        $query = $this->getFindAllQuery();
        $query->setLimit($limit);

        return $query->execute();
    }

    /**
     * @return QueryInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    protected function getFindAllQuery(): QueryInterface
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }
        $constraints[] = $query->logicalOr([
            $query->equals('archiveDate', 0),
            $query->greaterThanOrEqual('archiveDate', time()),
        ]);

        if (GeneralUtility::makeInstance(Context::class)->getAspect('language')->getId() === 0) {
            $constraints[] = $query->logicalOr([
                $query->equals('l18n_cfg', 0),
                $query->equals('l18n_cfg', 2)
            ]);
        } else {
            $constraints[] = $query->lessThan('l18n_cfg', 2);
        }
        $query->matching($query->logicalAnd($constraints));

        return $query;
    }

    /**
     * @param Author $author
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByAuthor(Author $author)
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }
        $constraints[] = $query->contains('authors', $author);

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param Category $category
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByCategory(Category $category)
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $constraints[] = $query->contains('categories', $category);
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param Tag $tag
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByTag(Tag $tag)
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $constraints[] = $query->contains('tags', $tag);
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param int $year
     * @param int $month
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \Exception
     */
    public function findByMonthAndYear(int $year, int $month = null)
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

        if ($month !== null) {
            $startDate = new \DateTimeImmutable(sprintf('%d-%d-1 00:00:00', $year, $month));
            $endDate = new \DateTimeImmutable(sprintf('%d-%d-%d 23:59:59', $year, $month, (int)$startDate->format('t')));
        } else {
            $startDate = new \DateTimeImmutable(sprintf('%d-1-1 00:00:00', $month));
            $endDate = new \DateTimeImmutable(sprintf('%d-12-31 23:59:59', $year));
        }
        $constraints[] = $query->greaterThanOrEqual('publish_date', $startDate->getTimestamp());
        $constraints[] = $query->lessThanOrEqual('publish_date', $endDate->getTimestamp());

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @return Post
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findCurrentPost(): ?Post
    {
        $typoScriptFrontendController = $this->getTypoScriptFrontendController();
        $pageId = $typoScriptFrontendController
            ? (int)$typoScriptFrontendController->id
            : (int)GeneralUtility::_GP('id');
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        if ((int)GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('language', 'id', 0) > 0) {
            $constraints[] = $query->equals('l10n_parent', $pageId);
        } else {
            $constraints[] = $query->equals('uid', $pageId);
        }

        /** @var Post $post */
        $post = $query
            ->matching($query->logicalAnd($constraints))
            ->execute()
            ->getFirst();

        return $post;
    }

    /**
     * Get month and years with posts.
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function findMonthsAndYearsWithPosts(): array
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }
        $constraints[] = $query->greaterThan('crdateMonth', 0);
        $constraints[] = $query->greaterThan('crdateYear', 0);
        $query->matching($query->logicalAnd($constraints));
        $posts = $query->execute(true);

        $result = [];
        $currentIndex = -1;
        $currentYear = null;
        $currentMonth = null;
        foreach ($posts as $post) {
            $year = $post['crdate_year'];
            $month = $post['crdate_month'];
            if ($currentYear !== $year || $currentMonth !== $month) {
                $currentIndex++;
                $currentYear = $year;
                $currentMonth = $month;
                $result[$currentIndex] = [
                    'year' => $currentYear,
                    'month' => $currentMonth,
                    'count' => 1
                ];
            } else {
                $result[$currentIndex]['count']++;
            }
        }

        return $result;
    }

    /**
     * @param int $categoryMultiplier
     * @param int $tagMultiplier
     * @param int $limit
     * @return ObjectStorage
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findRelatedPosts(int $categoryMultiplier = 1, int $tagMultiplier = 1, int $limit = 5): ObjectStorage
    {
        if ($categoryMultiplier === 0 && $tagMultiplier === 0) {
            $categoryMultiplier = 1;
        }

        $selectedPosts = [];
        $posts = GeneralUtility::makeInstance(ObjectStorage::class);

        $currentPost = $this->findCurrentPost();
        if ($currentPost instanceof Post) {
            foreach ($currentPost->getCategories() as $category) {
                $postsOfCategory = $this->findAllByCategory($category);
                /** @var Post $postOfCategory */
                foreach ($postsOfCategory as $postOfCategory) {
                    if ($postOfCategory->getUid() === $currentPost->getUid()) {
                        continue;
                    }

                    if (!array_key_exists($postOfCategory->getUid(), $selectedPosts)) {
                        $selectedPosts[$postOfCategory->getUid()] = $categoryMultiplier;
                    } else {
                        $selectedPosts[$postOfCategory->getUid()] += $categoryMultiplier;
                    }
                }
            }

            foreach ($currentPost->getTags() as $tag) {
                $postsOfTag = $this->findAllByTag($tag);
                /** @var Post $postOfTag */
                foreach ($postsOfTag as $postOfTag) {
                    if ($postOfTag->getUid() === $currentPost->getUid()) {
                        continue;
                    }

                    if (!array_key_exists($postOfTag->getUid(), $selectedPosts)) {
                        $selectedPosts[$postOfTag->getUid()] = $tagMultiplier;
                    } else {
                        $selectedPosts[$postOfTag->getUid()] += $tagMultiplier;
                    }
                }
            }
        }

        arsort($selectedPosts);
        $i = 0;
        foreach ($selectedPosts as $selectedPost => $count) {
            if ($i === $limit) {
                break;
            }
            $posts->attach($this->findByUid($selectedPost));
            $i++;
        }

        return $posts;
    }

    /**
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getStoragePidsFromTypoScript(): array
    {
        $configurationManager = $this->objectManager->get(ConfigurationManager::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        return GeneralUtility::intExplode(',', $settings['persistence']['storagePid']);
    }

    /**
     * @return null|ComparisonInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    protected function getStoragePidConstraint(): ?ComparisonInterface
    {
        if (TYPO3_MODE === 'FE') {
            $pids = $this->getPidsForConstraints();
            $query = $this->createQuery();
            return $query->in('pid', $pids);
        }
        return null;
    }

    /**
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getPidsForConstraints(): array
    {
        // only add non empty pids (pid 0 will be removed as well
        $pids = array_filter($this->getStoragePidsFromTypoScript(), function ($v) {
            return !empty($v);
        });

        if (\count($pids) === 0) {
            $rootLine = GeneralUtility::makeInstance(RootlineUtility::class, $this->getTypoScriptFrontendController()->id)->get();
            foreach ($rootLine as $value) {
                $pids[] = $value['uid'];
            }
        }

        return $pids;
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'] ?? null;
    }
}
