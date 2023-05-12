<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace TYPO3\CMS\Fluid\Tests\Functional\ViewHelpers\Format;

use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\CMS\Fluid\View\TemplateView;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class GravatarViewHelperTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/blog'
    ];

    /**
     * @test
     * @dataProvider renderDataProvider
     */
    public function render(string $template, string $expected): void
    {
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);
        $view = (new TemplateView($context));

        self::assertSame($expected, $view->render());
    }

    public static function renderDataProvider(): array
    {
        return [
            'simple' => [
                '<blogvh:gravatar email="info@typo3.com" />',
                '<img src="https://www.gravatar.com/avatar/b5f1f6bc63530e28de4ce7ce16896f45?s=64" width="64" height="64" />',
            ],
            'alt' => [
                '<blogvh:gravatar email="info@typo3.com" alt="DEMO" />',
                '<img alt="DEMO" src="https://www.gravatar.com/avatar/b5f1f6bc63530e28de4ce7ce16896f45?s=64" width="64" height="64" />',
            ],
            'size' => [
                '<blogvh:gravatar email="info@typo3.com" size="128" />',
                '<img src="https://www.gravatar.com/avatar/b5f1f6bc63530e28de4ce7ce16896f45?s=128" width="128" height="128" />',
            ],
        ];
    }
}
