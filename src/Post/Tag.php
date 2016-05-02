<?php
declare(strict_types=1);

namespace Staphp\Post;

class Tag
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $url;

    /**
     * @var PostCollection
     */
    private $posts;

    public function __construct(
        string $label,
        string $url
    ) {
        $this->label = $label;
        $this->url = $url;
        $this->posts = new PostCollection();
    }

    public function getLabel() : string
    {
        return $this->label;
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
