<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Fractor\V14;

use a9f\FractorTypoScript\AbstractTypoScriptFractor;
use Helmich\TypoScriptParser\Parser\AST\ConditionalStatement;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class MigrateTypoScriptBlogIsPageExpressionFractor extends AbstractTypoScriptFractor
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Migrate TypoScript expressions \"blog.isPage()\"', [new CodeSample(
            <<<'CODE_SAMPLE'
[blog.isPage()]
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
[isBlogPage()]
CODE_SAMPLE
        )]);
    }

    public function refactor(Statement $statement): ?Statement
    {
        if (!$statement instanceof ConditionalStatement) {
            return null;
        }

        if (!str_contains($statement->condition, 'blog.isPage()')) {
            return null;
        }

        if (preg_match('/[\s|&\[]blog.isPage\(\)[\s|&\]]/', $statement->condition) > 0) {
            $statement->condition = (string)preg_replace('/([\s|&\[])blog.isPage\(\)([\s|&\]])/', '$1isBlogPage()$2', $statement->condition);
            return $statement;
        }

        return null;
    }
}
