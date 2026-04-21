<?php

declare(strict_types=1);

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

    public function __construct(ContaoFramework $framework)
    {
        $framework->initialize();

        $config = $framework->getAdapter(Config::class);
        $this->httpHeaderNames = StringUtil::trimsplit(',', strtolower((string) $config->get('logging_header_names')));
    }

    public function __invoke(LogRecord $record): LogRecord
    {
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
