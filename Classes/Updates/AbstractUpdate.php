<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use T3G\AgencyPack\Blog\Updates\Criteria\CriteriaInterface;
use T3G\AgencyPack\Blog\Updates\Criteria\EqualIntCriteria;
use T3G\AgencyPack\Blog\Updates\Criteria\EqualStringCriteria;
use T3G\AgencyPack\Blog\Updates\Criteria\InCriteria;
use T3G\AgencyPack\Blog\Updates\Criteria\IsNullCriteria;
use T3G\AgencyPack\Blog\Updates\Criteria\NotEqualIntCriteria;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;

abstract class AbstractUpdate
{
    const CONDITION_AND = 'AND';
    const CONDITION_OR = 'OR';

    protected string $title = '';
    protected string $description = '';

    /**
     * @var Connection[]
     */
    protected array $connection = [];

    public function getIdentifier(): string
    {
        return get_class($this);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }

    protected function getConnection(string $table): Connection
    {
        if (!isset($this->connection[$table])) {
            $this->connection[$table] = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($table);
        }

        return $this->connection[$table];
    }

    protected function createQueryBuilder(string $table): QueryBuilder
    {
        $queryBuilder = $this->getConnection($table)->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();

        return $queryBuilder;
    }

    protected function tableHasColumn(string $table, string $column): bool
    {
        $schemaManager = $this->getConnection($table)->createSchemaManager();
        $tableColumns = $schemaManager->listTableColumns($table);

        if (array_key_exists($column, $tableColumns)) {
            return true;
        }

        return false;
    }

    protected function createEqualIntCriteria(QueryBuilder $queryBuilder, string $field, int $value): EqualIntCriteria
    {
        return (new EqualIntCriteria($queryBuilder, $field))
            ->setValue($value);
    }

    protected function createNotEqualIntCriteria(QueryBuilder $queryBuilder, string $field, int $value): NotEqualIntCriteria
    {
        return (new NotEqualIntCriteria($queryBuilder, $field))
            ->setValue($value);
    }

    protected function createEqualStringCriteria(QueryBuilder $queryBuilder, string $field, string $value): EqualStringCriteria
    {
        return (new EqualStringCriteria($queryBuilder, $field))
            ->setValue($value);
    }

    protected function createInCriteria(QueryBuilder $queryBuilder, string $field, array $values): InCriteria
    {
        return (new InCriteria($queryBuilder, $field))
            ->setValues($values);
    }

    protected function createIsNullCriteria(QueryBuilder $queryBuilder, string $field): IsNullCriteria
    {
        return new IsNullCriteria($queryBuilder, $field);
    }

    protected function getRecordsByCriteria(QueryBuilder $queryBuilder, string $table, array $criteria, string $condition = self::CONDITION_AND): array
    {
        $queryBuilder->select('*');
        $queryBuilder->from($table);
        if ($condition === self::CONDITION_AND) {
            $queryBuilder->where(...array_map(static fn (CriteriaInterface $criterion): string => (string)$criterion, $criteria));
        } else {
            $queryBuilder->orWhere(...array_map(static fn (CriteriaInterface $criterion): string => (string)$criterion, $criteria));
        }

        $result = $queryBuilder->executeQuery();

        return $result->fetchAllAssociative();
    }

    protected function updateRecord(string $table, int $uid, array $values): void
    {
        $queryBuilder = $this->createQueryBuilder($table);
        $queryBuilder->update($table)
            ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)));

        foreach ($values as $field => $value) {
            $queryBuilder->set($field, $value);
        }

        $queryBuilder->executeStatement();
    }

    protected function getBlogStorageFolders(): array
    {
        $pageQueryBuilder = $this->createQueryBuilder('pages');
        $pageCriteria = [
            $this->createEqualIntCriteria($pageQueryBuilder, 'doktype', 254),
            $this->createEqualStringCriteria($pageQueryBuilder, 'module', 'blog'),
        ];
        return $this->getRecordsByCriteria($pageQueryBuilder, 'pages', $pageCriteria);
    }
}
