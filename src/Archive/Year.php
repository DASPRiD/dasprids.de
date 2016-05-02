<?php
declare(strict_types=1);

namespace Staphp\Archive;

use Staphp\Post\PostCollection;

class Year
{
    /**
     * @var int
     */
    private $year;

    /**
     * @var string
     */
    private $url;

    /**
     * @var PostCollection
     */
    private $posts;

    public function __construct(
        int $year,
        string $url
    ) {
        $this->year = $year;
        $this->url = $url;
        $this->posts = new PostCollection();
    }

    public function getYear() : int
    {
        return $this->year;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getPosts() : PostCollection
    {
        return $this->posts;
    }
}
