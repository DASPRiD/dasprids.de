<?php
declare(strict_types=1);

namespace Staphp\Filter;

use Michelf\Markdown;

class MarkdownFilter
{
    /**
     * @var Markdown
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new Markdown();
    }

    public function __invoke($markdown) : string
    {
        return $this->parser->transform($markdown);
    }
}
