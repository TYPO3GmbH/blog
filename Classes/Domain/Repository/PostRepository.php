<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Repository;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\DataTransferObject\PostRepositoryDemand;
use T3G\AgencyPack\Blog\Domain\Filter\PostFilter;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class PostRepository extends Repository
{
    protected array $settings = [];
    protected array $defaultConstraints = [];

    public function initializeObject(): void
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $this->settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'blog');

        $querySettings = GeneralUtility::makeInstance(
            Typo3QuerySettings::class,
            GeneralUtility::makeInstance(Context::class),
            $configurationManager
        );
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();
        $this->defaultConstraints[] = $query->equals('doktype', Constants::DOKTYPE_BLOG_POST);
        if (GeneralUtility::makeInstance(Context::class)->getAspect('language')->getId() === 0) {
            $this->defaultConstraints[] = $query->logicalOr(
                $query->equals('l18n_cfg', 0),
                $query->equals('l18n_cfg', 2)
            );
        } else {
            $this->defaultConstraints[] = $query->lessThan('l18n_cfg', 2);
        }

        $this->defaultOrderings = [
            'publish_date' => QueryInterface::ORDER_DESCENDING,
        ];
    }

    public function findByUidRespectQuerySettings(int $uid): ?Post
    {
        $query = $this->createQuery();
        $query->matching($query->equals('uid', $uid));
        /** @var null|Post */
        $result = $query->execute()->getFirst();

        return $result;
    }

    /**
     * @return Post[]
     */
    public function findByRepositoryDemand(PostRepositoryDemand $repositoryDemand): array
    {
        $query = $this->createQuery();

        $constraints = [
            $query->equals('doktype', Constants::DOKTYPE_BLOG_POST)
        ];

        if ($repositoryDemand->getPosts() !== []) {
            $constraints[] = $query->in('uid', $repositoryDemand->getPosts());
        } else {
            if ($repositoryDemand->getCategories() !== []) {
                $categoriesConstraints = [];
                foreach ($repositoryDemand->getCategories() as $category) {
                    $categoriesConstraints[] = $query->equals('categories.uid', $category->getUid());
                }
                if ($repositoryDemand->getCategoriesConjunction() === Constants::REPOSITORY_CONJUNCTION_AND) {
                    $constraints[] = $query->logicalAnd(...$categoriesConstraints);
                } else {
                    $constraints[] = $query->logicalOr(...$categoriesConstraints);
                }
            }
            if ($repositoryDemand->getTags() !== []) {
                $tagsConstraints = [];
                foreach ($repositoryDemand->getTags() as $tag) {
                    $tagsConstraints[] = $query->equals('tags.uid', $tag->getUid());
                }
                if ($repositoryDemand->getTagsConjunction() === Constants::REPOSITORY_CONJUNCTION_AND) {
                    $constraints[] = $query->logicalAnd(...$tagsConstraints);
                } else {
                    $constraints[] = $query->logicalOr(...$tagsConstraints);
                }
            }
            if (($ordering = $repositoryDemand->getOrdering()) !== []) {
                $query->setOrderings([$ordering['field'] => $ordering['direction']]);
            }
        }

        $query->matching($query->logicalAnd(...$constraints));

        if (($limit = $repositoryDemand->getLimit()) > 0) {
            $query->setLimit($limit);
        }

        /** @var Post[] $result */
        $result = $query->execute()->toArray();

        if ($repositoryDemand->getPosts() !== []) {
            // Sort manually selected posts by defined order in group field
            $sortedPosts = array_flip($repositoryDemand->getPosts());
            foreach ($result as $post) {
                $sortedPosts[$post->getUid()] = $post;
            }
            $result = array_values(array_filter($sortedPosts, function ($value) {
                return $value instanceof Post;
            }));
        }

        return $result;
    }

    public function findAll(): QueryResultInterface
    {
        return $this->getFindAllQuery()->execute();
    }

    public function findAllByPid(?int $blogSetup = null): QueryResultInterface
    {
        $query = $this->getFindAllQuery();

        if ($blogSetup !== null) {
            $constraints = [];
            if ($query->getConstraint() !== null) {
                $constraints[] = $query->getConstraint();
            }
            $constraints[] = $query->equals('pid', $blogSetup);
            $query->matching($query->logicalAnd(...$constraints));
        }

        return $query->execute();
    }

    public function findAllWithLimit(int $limit): QueryResultInterface
    {
        $query = $this->getFindAllQuery();
        $query->setLimit($limit);

        return $query->execute();
    }

    protected function getFindAllQuery(): QueryInterface
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }
        $constraints[] = $query->logicalOr(
            $query->equals('archiveDate', 0),
            $query->greaterThanOrEqual('archiveDate', time())
        );

        $query->matching($query->logicalAnd(...$constraints));

        return $query;
    }

    public function findAllByAuthor(Author $author): QueryResultInterface
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }
        $constraints[] = $query->contains('authors', $author);

        return $query->matching($query->logicalAnd(...$constraints))->execute();
    }

    public function findAllByCategory(Category $category): QueryResultInterface
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $constraints[] = $query->contains('categories', $category);
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

        return $query->matching($query->logicalAnd(...$constraints))->execute();
    }

    public function findAllByTag(Tag $tag): QueryResultInterface
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $constraints[] = $query->contains('tags', $tag);
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

        return $query->matching($query->logicalAnd(...$constraints))->execute();
    }

    public function findAllByFilter(PostFilter $filter): QueryResultInterface
    {
        $query = $this->createQuery();
        $constraints = array_merge($this->defaultConstraints, $filter->getConstraints($query));
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

        return $query->matching($query->logicalAnd(...$constraints))->execute();
    }

    public function findByMonthAndYear(int $year, int $month = null): QueryResultInterface
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
            $startDate = new \DateTimeImmutable(sprintf('%d-1-1 00:00:00', $year));
            $endDate = new \DateTimeImmutable(sprintf('%d-12-31 23:59:59', $year));
        }
        $constraints[] = $query->greaterThanOrEqual('publish_date', $startDate->getTimestamp());
        $constraints[] = $query->lessThanOrEqual('publish_date', $endDate->getTimestamp());

        return $query->matching($query->logicalAnd(...$constraints))->execute();
    }

    public function findCurrentPost(): ?Post
    {
        $typoScriptFrontendController = $this->getTypoScriptFrontendController();
        if ($typoScriptFrontendController === null) {
            return null;
        }

        $pageId = (int) $typoScriptFrontendController->id;
        $currentLanguageId = GeneralUtility::makeInstance(Context::class)
            ->getPropertyFromAspect('language', 'id', 0);

        $post = $this->getPostWithLanguage($pageId, $currentLanguageId);
        if ($post !== null) {
            return $post;
        }

        return $this->applyLanguageFallback($pageId, $currentLanguageId);
    }

    protected function getPostWithLanguage(int $pageId, int $languageId): ?Post
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;

        if ($languageId > 0) {
            $constraints[] = $query->equals('l10n_parent', $pageId);
            $constraints[] = $query->equals('sys_language_uid', $languageId);
        } else {
            $constraints[] = $query->equals('uid', $pageId);
        }

        /** @var null|Post */
        $result = $query
            ->matching($query->logicalAnd(...$constraints))
            ->execute()
            ->getFirst();

        return $result;
    }

    protected function applyLanguageFallback(int $pageId, int $currentLanguageId): ?Post
    {
        $currentSite = $this->getCurrentSite();
        if ($currentSite !== null) {
            /** @var SiteLanguage $languageConfiguration */
            $languageConfiguration = $currentSite->getAllLanguages()[$currentLanguageId];
            // check the whole language-fallback chain
            $fallbacks = $languageConfiguration->getFallbackLanguageIds();
            foreach ($fallbacks as $fallbackLanguageId) {
                $post = $this->getPostWithLanguage($pageId, $fallbackLanguageId);
                if ($post !== null) {
                    return $post;
                }
            }
        }
        return null;
    }

    protected function getCurrentSite(): ?Site
    {
        if ($GLOBALS['TYPO3_REQUEST'] instanceof ServerRequestInterface
            && $GLOBALS['TYPO3_REQUEST']->getAttribute('site') instanceof Site) {
            return $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
        }
        return null;
    }

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
        $query->matching($query->logicalAnd(...$constraints));
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
     * @return ObjectStorage<Post>
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

                    if (!array_key_exists((int) $postOfCategory->getUid(), $selectedPosts)) {
                        $selectedPosts[(int) $postOfCategory->getUid()] = $categoryMultiplier;
                    } else {
                        $selectedPosts[(int) $postOfCategory->getUid()] += $categoryMultiplier;
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

                    if (!array_key_exists((int) $postOfTag->getUid(), $selectedPosts)) {
                        $selectedPosts[(int) $postOfTag->getUid()] = $tagMultiplier;
                    } else {
                        $selectedPosts[(int) $postOfTag->getUid()] += $tagMultiplier;
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
            $post = $this->findByUid($selectedPost);
            if ($post === null) {
                continue;
            }
            $posts->attach($post);
            $i++;
        }

        return $posts;
    }

    protected function getStoragePidsFromTypoScript(): array
    {
        return GeneralUtility::intExplode(',', $this->settings['persistence']['storagePid']);
    }

    /**
     * @return null|ComparisonInterface
     */
    protected function getStoragePidConstraint(): ?ComparisonInterface
    {
        if (ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend()) {
            $pids = $this->getPidsForConstraints();
            $query = $this->createQuery();
            return $query->in('pid', $pids);
        }
        return null;
    }

    protected function getPidsForConstraints(): array
    {
        // only add non empty pids (pid 0 will be removed as well
        $pids = array_filter($this->getStoragePidsFromTypoScript(), function ($value) {
            return $value !== '' && (int) $value !== 0;
        });

        if (count($pids) === 0 && $this->getTypoScriptFrontendController() !== null) {
            $rootLine = GeneralUtility::makeInstance(RootlineUtility::class, $this->getTypoScriptFrontendController()->id)->get();
            foreach ($rootLine as $value) {
                $pids[] = (int) $value['uid'];
            }
        }

        return $pids;
    }

    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'] ?? null;
    }
}
