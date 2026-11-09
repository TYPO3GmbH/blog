<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use T3G\AgencyPack\Blog\Constants;

/**
 * BlogFunctionsProvider
 */
class BlogFunctionsProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions(): array
    {
        return [
            $this->getIsBlogPageFunction(),
            $this->getIsBlogPostFunction(),
        ];
    }

    protected function getIsBlogPageFunction(): ExpressionFunction
    {
        return new ExpressionFunction(
            'isBlogPage',
            static fn () => null, // Not implemented, we only use the evaluator
            static function ($arguments) {
                return ($arguments['page']['doktype'] ?? false) === Constants::DOKTYPE_BLOG_PAGE;
            }
        );
    }

    protected function getIsBlogPostFunction(): ExpressionFunction
    {
        return new ExpressionFunction(
            'isBlogPost',
            static fn () => null, // Not implemented, we only use the evaluator
            static function ($arguments) {
                return ($arguments['page']['doktype'] ?? false) === Constants::DOKTYPE_BLOG_POST;
            }
        );
    }
}
