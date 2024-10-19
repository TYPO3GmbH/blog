<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ViewHelpers\Data;

use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;

final class ContentListOptionsViewHelperTest extends SiteBasedTestCase
{
    protected array $coreExtensionsToLoad = [
        'form'
    ];

    #[Test]
    public function render(): void
    {
        $this->createTestSite();

        $template = '<blogvh:data.contentListOptions listType="blog_header" />{contentObjectData -> f:format.json() -> f:format.raw()}';
        $expected = json_encode(
            [
                'uid' => Constants::LISTTYPE_TO_FAKE_UID_MAPPING['blog_header'],
                'CType' => 'blog_header',
                'layout' => '0',
                'frame_class' => 'default',
            ],
            JSON_HEX_TAG
        );

        self::assertSame(
            $expected,
            $this->renderFluidTemplateInTestSite($template)
        );
    }

    #[Test]
    public function renderWithOverwrite(): void
    {
        $this->createTestSite();
        $this->addTypoScriptToTemplateRecord(
            self::ROOT_UID,
            implode("\n", [
                'plugin.tx_blog.settings.contentListOptions.blog_header {',
                '   space_before_class = small',
                '   frame_class = secondary',
                '}',
            ])
        );

        $template = '<blogvh:data.contentListOptions listType="blog_header" />{contentObjectData -> f:format.json() -> f:format.raw()}';
        $expected = json_encode(
            [
                'space_before_class' => 'small',
                'frame_class' => 'secondary',
                'uid' => Constants::LISTTYPE_TO_FAKE_UID_MAPPING['blog_header'],
                'CType' => 'blog_header',
                'layout' => '0',
            ],
            JSON_HEX_TAG
        );

        self::assertSame(
            $expected,
            $this->renderFluidTemplateInTestSite($template)
        );
    }
}
