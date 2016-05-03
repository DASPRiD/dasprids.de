<?php
declare(strict_types=1);

namespace Staphp\Filter;

use Parsedown;

class MarkdownFilter
{
    /**
     * @var Parsedown
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new Parsedown();
    }

    public function __invoke($markdown) : string
    {
        return $this->parser->text($markdown);
    }
}
