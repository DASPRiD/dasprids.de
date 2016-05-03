<?php
declare(strict_types=1);

namespace Staphp\Post;

use DateTimeImmutable;

class Post
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var DateTimeImmutable
     */
    private $date;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $content;

    /**
     * @var TagCollection|Tag[]
     */
    private $tags;

    /**
     * @var array
     */
    private $metaData;

    public function __construct(
        string $title,
        DateTimeImmutable $date,
        string $url,
        string $description,
        string $content,
        TagCollection $tags,
        array $metaData
    ) {
        $this->title = $title;
        $this->date = $date;
        $this->url = $url;
        $this->description = $description;
        $this->content = $content;
        $this->tags = $tags;
        $this->metaData = $metaData;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getDate() : DateTimeImmutable
    {
        return $this->date;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * @return TagCollection|Tag[]
     */
    public function getTags() : TagCollection
    {
        return $this->tags;
    }

    public function getMetaData() : array
    {
        return $this->metaData;
    }
}
