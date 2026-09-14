<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-additional-header-logging-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

namespace Cgoit\AdditionalHeaderLoggingBundle\Monolog;

use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\StringUtil;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AdditionalHeadersProcessor implements ProcessorInterface, EventSubscriberInterface
{
    private Request|null $request = null;

    /**
     * @var array<string>|null
     */
    private array|null $httpHeaderNames = null;

    /**
     * The framework must not be initialized here: the processor is already built
     * while the kernel boots, before a request exists, and an early initialization
     * runs all initializeSystem hooks without request context (e.g. back end assets
     * of other bundles would not be registered).
     */
    public function __construct(private readonly ContaoFramework $framework)
    {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        if ($this->request && null === $this->httpHeaderNames && $this->framework->isInitialized()) {
            $config = $this->framework->getAdapter(Config::class);
            $this->httpHeaderNames = StringUtil::trimsplit(',', strtolower((string) $config->get('logging_header_names')));
        }

        if ($this->request && !empty($this->httpHeaderNames)) {
            foreach ($this->httpHeaderNames as $httpHeaderName) {
                if ($this->request->headers->has($httpHeaderName)) {
                    $record->extra[$httpHeaderName] = $this->request->headers->get($httpHeaderName);
                }
            }
        }

        return $record;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($event->isMainRequest()) {
            $this->request = $event->getRequest();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 4096],
        ];
    }
}
