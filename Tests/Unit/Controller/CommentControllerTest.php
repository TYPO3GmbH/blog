<?php
namespace T3G\AgencyPack\Blog\Tests\Unit\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use Prophecy\Argument;
use T3G\AgencyPack\Blog\Controller\CommentController;
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Lang\LanguageService;

/**
 * Test case
 *
 */
class CommentControllerTest extends UnitTestCase
{
    /**
     * @test
     */
    public function commentsDeactivatedGlobalByTypoScriptWillNotAcceptNewComments()
    {
        $languageService = $this->prophesize(LanguageService::class);
        $languageService->includeLLFile(Argument::any())->shouldBeCalled();
        $languageService->getLL(Argument::any())->willReturn('string');
        $GLOBALS['LANG'] = $languageService->reveal();

        $commentProphecy = $this->prophesize(Comment::class);
        $comment = $commentProphecy->reveal();
        $postProphecy = $this->prophesize(Post::class);
        $postProphecy->addComment($comment)->shouldBeCalled();
        $post = $postProphecy->reveal();

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $controller = $objectManager->get(CommentController::class);
        $controller->addCommentAction($post, $comment);
    }
}
