<?php
declare(strict_types=1);

namespace Staphp\Filter;

class ServerUrlFilter
{
    /**
     * @var string
     */
    private $url;

    public function __construct(string $url)
    {
        $this->url = rtrim($url, '/');
    }

    public function __invoke($url)
    {
        return $this->url . '/' . ltrim($url, '/');
    }
}
