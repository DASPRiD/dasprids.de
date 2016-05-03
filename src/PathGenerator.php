<?php
declare(strict_types=1);

namespace Staphp;

class PathGenerator
{
    /**
     * @var string
     */
    private $distPath;

    public function __construct(string $distPath)
    {
        $this->distPath = $distPath;
    }

    public function generatePath(string $url) : string
    {
        if (preg_match('(/$)', $url)) {
            $url .= 'index.html';
        }

        return $this->distPath . '/' . trim($url, '/');
    }
}
