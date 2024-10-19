<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ViewHelpers\Link\Be;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\CMS\Fluid\View\TemplateView;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class PostViewHelperTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'form'
    ];

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/blog'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $GLOBALS['TYPO3_REQUEST'] = (new ServerRequest('https://test.typo3.com/'))
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_BE)
            ->withAttribute('normalizedParams', new NormalizedParams([], [], '', ''));
    }

    #[Test]
    #[DataProvider('renderDataProvider')]
    public function render(string $template, string $expected): void
    {
        $post = new Post();
        $post->_setProperty('uid', 123);
        $post->setTitle('Demo');

        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);

        $view = (new TemplateView($context));
        $view->assign('post', $post);

        self::assertSame($expected, $view->render());
    }

    public static function renderDataProvider(): array
    {
        $expectedReturnUrl = '/';

        return [
            'simple' => [
                '<blogvh:link.be.post post="{post}" />',
                '<a href="/typo3/module/web/layout?token=dummyToken&amp;id=123">Demo</a>',
            ],
            'action edit' => [
                '<blogvh:link.be.post post="{post}" action="edit" />',
                '<a href="/typo3/record/edit?token=dummyToken&amp;edit%5Bpages%5D%5B123%5D=edit&amp;returnUrl=' . $expectedReturnUrl . '">Demo</a>',
            ],
            'target' => [
                '<blogvh:link.be.post post="{post}" target="_blank" />',
                '<a target="_blank" href="/typo3/module/web/layout?token=dummyToken&amp;id=123">Demo</a>',
            ],
            'itemprop' => [
                '<blogvh:link.be.post post="{post}" itemprop="name" />',
                '<a itemprop="name" href="/typo3/module/web/layout?token=dummyToken&amp;id=123">Demo</a>',
            ],
            'rel' => [
                '<blogvh:link.be.post post="{post}" rel="noreferrer" />',
                '<a rel="noreferrer" href="/typo3/module/web/layout?token=dummyToken&amp;id=123">Demo</a>',
            ],
            'returnUri' => [
                '<blogvh:link.be.post post="{post}" returnUri="1" />',
                '/typo3/module/web/layout?token=dummyToken&amp;id=123',
            ],
            'content' => [
                '<blogvh:link.be.post post="{post}">Hello</blogvh:link.be.post>',
                '<a href="/typo3/module/web/layout?token=dummyToken&amp;id=123">Hello</a>',
            ],
            'class' => [
                '<blogvh:link.be.post post="{post}" class="class" />',
                '<a class="class" href="/typo3/module/web/layout?token=dummyToken&amp;id=123">Demo</a>',
            ],
        ];
    }
}
