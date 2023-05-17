<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Routing\Aspect;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Routing\Aspect\StaticMappableAspectInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class StaticDatabaseMapper implements StaticMappableAspectInterface, \Countable
{
    /**
     * @var array
     */
    protected $settings;

    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $groupBy;

    /**
     * @var array
     */
    protected $where;

    /**
     * @var array
     */
    protected $values;

    /**
     * @param array $settings
     * @throws \InvalidArgumentException
     */
    public function __construct(array $settings)
    {
        $field = $settings['field'] ?? null;
        $table = $settings['table'] ?? null;
        $where = $settings['where'] ?? [];
        $groupBy = $settings['groupBy'] ?? '';

        if (!is_string($field)) {
            throw new \InvalidArgumentException('field must be string', 1550156808);
        }
        if (!is_string($table)) {
            throw new \InvalidArgumentException('table must be string', 1550156812);
        }
        if (!is_string($groupBy)) {
            throw new \InvalidArgumentException('groupBy must be string', 1550158149);
        }
        if (!is_array($where)) {
            throw new \InvalidArgumentException('where must be an array', 1550157442);
        }

        $this->settings = $settings;
        $this->field = $field;
        $this->table = $table;
        $this->where = $where;
        $this->groupBy = $groupBy;
        $this->values = $this->buildValues();
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function generate(string $value): ?string
    {
        return $this->respondWhenInValues($value);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(string $value): ?string
    {
        return $this->respondWhenInValues($value);
    }

    /**
     * @param string $value
     * @return string|null
     */
    protected function respondWhenInValues(string $value): ?string
    {
        if (in_array($value, $this->values, true)) {
            return $value;
        }
        return null;
    }

    /**
     * Builds range based on given settings and ensures each item is string.
     * The amount of items is limited to 1000 in order to avoid brute-force
     * scenarios and the risk of cache-flooding.
     *
     * In case that is not enough, creating a custom and more specific mapper
     * is encouraged. Using high values that are not distinct exposes the site
     * to the risk of cache-flooding.
     *
     * @return string[]
     * @throws \LengthException
     */
    protected function buildValues(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($this->table);

        $queryBuilder
            ->select($this->field)
            ->from($this->table);

        if ($this->groupBy !== '') {
            $queryBuilder->groupBy($this->groupBy);
        }

        if (count($this->where) > 0) {
            foreach ($this->where as $key => $value) {
                $queryBuilder->andWhere($key, $queryBuilder->createNamedParameter($value));
            }
        }

        return array_map('strval', array_column($queryBuilder->execute()->fetchAll(), $this->field));
    }
}
