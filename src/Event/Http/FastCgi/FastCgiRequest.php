<?php declare(strict_types=1);

namespace Bref\Event\Http\FastCgi;

use hollodotme\FastCGI\Requests\AbstractRequest;

/**
 * @internal
 */
final class FastCgiRequest extends AbstractRequest
{
    /** @var string */
    private $method;

    public static function fromLambdaContext(string $method, string $scriptFilename, string $content): self
    {
        $request = new self($scriptFilename, $content);

        $request->method = $method;

        return $request;
    }

    public function getRequestMethod(): string
    {
        return $this->method;
    }

    public function getServerSoftware(): string
    {
        return 'bref';
    }
}
