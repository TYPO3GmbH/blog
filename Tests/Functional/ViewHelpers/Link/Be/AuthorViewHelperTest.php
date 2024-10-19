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
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\CMS\Fluid\View\TemplateView;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class AuthorViewHelperTest extends FunctionalTestCase
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
        $author = new Author();
        $author->_setProperty('uid', 123);
        $author->setEmail('info+test@typo3.com');
        $author->setName('Info');

        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);

        $view = (new TemplateView($context));
        $view->assign('author', $author);

        self::assertSame($expected, $view->render());
    }

    public static function renderDataProvider(): array
    {
        $expectedReturnUrl = '/';

        return [
            'simple' => [
                '<blogvh:link.be.author author="{author}" />',
                '<a href="/typo3/record/edit?token=dummyToken&amp;edit%5Btx_blog_domain_model_author%5D%5B123%5D=edit&amp;returnUrl=' . $expectedReturnUrl . '">Info</a>',
            ],
            'target' => [
                '<blogvh:link.be.author author="{author}" target="_blank" />',
                '<a target="_blank" href="/typo3/record/edit?token=dummyToken&amp;edit%5Btx_blog_domain_model_author%5D%5B123%5D=edit&amp;returnUrl=' . $expectedReturnUrl . '">Info</a>',
            ],
            'itemprop' => [
                '<blogvh:link.be.author author="{author}" itemprop="name" />',
                '<a itemprop="name" href="/typo3/record/edit?token=dummyToken&amp;edit%5Btx_blog_domain_model_author%5D%5B123%5D=edit&amp;returnUrl=' . $expectedReturnUrl . '">Info</a>',
            ],
            'rel' => [
                '<blogvh:link.be.author author="{author}" rel="noreferrer" />',
                '<a rel="noreferrer" href="/typo3/record/edit?token=dummyToken&amp;edit%5Btx_blog_domain_model_author%5D%5B123%5D=edit&amp;returnUrl=' . $expectedReturnUrl . '">Info</a>',
            ],
            'returnUri' => [
                '<blogvh:link.be.author author="{author}" returnUri="1" />',
                '/typo3/record/edit?token=dummyToken&amp;edit%5Btx_blog_domain_model_author%5D%5B123%5D=edit&amp;returnUrl=' . $expectedReturnUrl,
            ],
            'content' => [
                '<blogvh:link.be.author author="{author}">Hello</blogvh:link.be.author>',
                '<a href="/typo3/record/edit?token=dummyToken&amp;edit%5Btx_blog_domain_model_author%5D%5B123%5D=edit&amp;returnUrl=' . $expectedReturnUrl . '">Hello</a>',
            ],
            'class' => [
                '<blogvh:link.be.author author="{author}" class="class" />',
                '<a class="class" href="/typo3/record/edit?token=dummyToken&amp;edit%5Btx_blog_domain_model_author%5D%5B123%5D=edit&amp;returnUrl=' . $expectedReturnUrl . '">Info</a>',
            ],
        ];
    }
}
