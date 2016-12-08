<?php
declare(strict_types=1);

namespace Staphp\Filter;

use ParsedownExtra;

class MarkdownFilter
{
    /**
     * @var ParsedownExtra
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new ParsedownExtra();
    }

    public function __invoke($markdown) : string
    {
        return $this->parser->text($markdown);
    }
}
