<?php declare(strict_types=1);

namespace Bref\Event\Sqs;

use Bref\Context\Context;
use Bref\Event\ExceptionHandler;
use Bref\Event\Handler;

/**
 * Handles SQS events.
 */
abstract class SqsHandler implements Handler, ExceptionHandler
{
    abstract public function handleSqs(SqsEvent $event, Context $context): void;

    /** {@inheritDoc} */
    public function handle($event, Context $context): void
    {
        $this->handleSqs(new SqsEvent($event), $context);
    }

    public function error(\Throwable $error)
    {
        if ($error instanceof \Exception) {
            $errorMessage = 'Uncaught ' . get_class($error) . ': ' . $error->getMessage();
        } else {
            $errorMessage = $error->getMessage();
        }

        // Log the exception in CloudWatch
        printf(
            "Fatal error: %s in %s:%d\nStack trace:\n%s",
            $errorMessage,
            $error->getFile(),
            $error->getLine(),
            $error->getTraceAsString()
        );
    }
}
