<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Mail;

use TYPO3\CMS\Core\Mail\MailMessage as CoreMailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MailMessage
{
    protected CoreMailMessage $mailMessage;
    protected string $subject;
    protected string $body;
    protected array $from;
    protected array $to;

    public function __construct()
    {
        $this->mailMessage = GeneralUtility::makeInstance(CoreMailMessage::class);
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setFrom(array $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function getFrom(): array
    {
        return $this->from;
    }

    public function setTo(array $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function send(): bool
    {
        $this->mailMessage->setSubject($this->getSubject());
        $this->mailMessage->setFrom($this->getFrom());
        $this->mailMessage->setTo($this->getTo());
        $this->mailMessage->html($this->getBody());

        return (bool) $this->mailMessage->send();
    }
}
