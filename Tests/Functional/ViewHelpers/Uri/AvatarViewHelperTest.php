<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ViewHelpers\Uri;

use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\CMS\Fluid\View\TemplateView;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class AvatarViewHelperTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'form'
    ];

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/blog'
    ];

    /**
     * @test
     * @dataProvider renderDataProvider
     */
    public function render(string $template, string $expected): void
    {
        $author = new Author();
        $author->setEmail('info+gravatar@typo3.com');
        $author->setName('Info Gravatar');
        $author->setAvatarProvider('T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider');

        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);
        $view = (new TemplateView($context));
        $view->assign('author', $author);

        self::assertSame($expected, $view->render());
    }

    public static function renderDataProvider(): array
    {
        return [
            'simple' => [
                '{blogvh:uri.avatar(author: author)}',
                'https://www.gravatar.com/avatar/edce5ecb76b1dcb9f9d7647a13e7fc97?s=64',
            ],
            'size' => [
                '{blogvh:uri.avatar(author: author, size: 32)}',
                'https://www.gravatar.com/avatar/edce5ecb76b1dcb9f9d7647a13e7fc97?s=32',
            ]
        ];
    }
}
