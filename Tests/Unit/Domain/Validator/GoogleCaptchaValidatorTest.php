<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Domain\Validator;

use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use T3G\AgencyPack\Blog\Domain\Validator\GoogleCaptchaValidator;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Error\Result;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class GoogleCaptchaValidatorTest extends UnitTestCase
{
    protected bool $resetSingletonInstances = true;

    protected function setUp(): void
    {
        parent::setUp();
        unset($GLOBALS['google_recaptcha']);
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['google_recaptcha'], $GLOBALS['TYPO3_REQUEST']);
        parent::tearDown();
    }

    #[Test]
    public function tokenRejectedByGoogleIsAnError(): void
    {
        $this->registerSettings(1);
        $this->registerResponse(200, '{"success":false}');

        self::assertTrue($this->validate()->hasErrors());
    }

    #[Test]
    public function tokenAcceptedByGooglePasses(): void
    {
        $this->registerSettings(1);
        $this->registerResponse(200, '{"success":true}');

        self::assertFalse($this->validate()->hasErrors());
    }

    #[Test]
    public function unreachableVerificationServiceIsAnError(): void
    {
        $this->registerSettings(1);
        $this->registerResponse(500, '');

        self::assertTrue($this->validate()->hasErrors());
    }

    #[Test]
    public function unparsableVerificationResponseIsAnError(): void
    {
        $this->registerSettings(1);
        $this->registerResponse(200, 'not json');

        self::assertTrue($this->validate()->hasErrors());
    }

    #[Test]
    public function verificationResponseWithoutSuccessKeyIsAnError(): void
    {
        $this->registerSettings(1);
        $this->registerResponse(200, '{"error-codes":["timeout-or-duplicate"]}');

        self::assertTrue($this->validate()->hasErrors());
    }

    #[Test]
    public function disabledCaptchaIsNotVerifiedAtAll(): void
    {
        $this->registerSettings(0);
        // No RequestFactory is registered: reaching the HTTP call would fail the test.

        self::assertFalse($this->validate()->hasErrors());
    }

    #[Test]
    public function verdictAlreadyObtainedIsNotReasked(): void
    {
        $this->registerSettings(1);
        $GLOBALS['google_recaptcha'] = true;
        // No RequestFactory is registered: asking Google twice would fail the test.

        self::assertFalse($this->validate()->hasErrors());
    }

    #[Test]
    public function enabledCaptchaIsVerifiedEvenWithoutExtbaseParameters(): void
    {
        // The validator is attached exclusively to the comment form's captcha
        // field and is only invoked while that submission is validated. The
        // form framework does not expose the resolved controller/action to it,
        // so verification must not depend on those being present on the
        // request — an empty token still has to be rejected.
        $this->registerSettings(1);
        $this->registerResponse(200, '{"success":false}');

        $validator = new GoogleCaptchaValidator();
        $validator->setRequest(
            (new ServerRequest('https://example.com/', 'POST'))
                ->withParsedBody(['g-recaptcha-response' => ''])
        );

        self::assertTrue($validator->validate('')->hasErrors());
    }

    protected function validate(): Result
    {
        $validator = new GoogleCaptchaValidator();
        $validator->setRequest(
            (new ServerRequest('https://example.com/', 'POST'))
                ->withParsedBody(['g-recaptcha-response' => 'a-token'])
        );

        return $validator->validate('a-token');
    }

    protected function registerSettings(int $enable): void
    {
        $configurationManager = self::createStub(ConfigurationManagerInterface::class);
        $configurationManager->method('getConfiguration')->willReturn([
            'comments' => [
                'google_recaptcha' => [
                    'enable' => $enable,
                    'website_key' => 'site-key',
                    'secret_key' => 'secret-key',
                ],
            ],
        ]);
        GeneralUtility::setSingletonInstance(ConfigurationManagerInterface::class, $configurationManager);
    }

    protected function registerResponse(int $status, string $body): void
    {
        $stream = self::createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn($body);

        $response = self::createStub(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn($status);
        $response->method('getBody')->willReturn($stream);

        $requestFactory = self::createStub(RequestFactory::class);
        $requestFactory->method('request')->willReturn($response);
        GeneralUtility::addInstance(RequestFactory::class, $requestFactory);
    }
}
