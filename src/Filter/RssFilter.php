<?php
declare(strict_types=1);

namespace Staphp\Filter;

use Staphp\Post\PostCollection;
use Zend\Feed\Writer\Feed;

class RssFilter
{
    /**
     * @var ServerUrlFilter
     */
    private $serverUrlFilter;

    /**
     * @var array
     */
    private $author;

    /**
     * @param ServerUrlFilter $serverUrlFilter
     * @param array $author
     */
    function __construct(ServerUrlFilter $serverUrlFilter, array $author)
    {
        $this->serverUrlFilter = $serverUrlFilter;
        $this->author = $author;
    }

    public function __invoke(
        PostCollection $posts,
        string $title,
        string $description,
        string $link,
        string $feedLink
    ) : string {
        $feed = new Feed();
        $feed->setTitle($title);
        $feed->setLink($link);
        $feed->setFeedLink($feedLink, 'rss');
        $feed->addAuthor($this->author);
        $feed->setDescription($description);
        $feed->setDateModified(time());

        foreach ($posts as $post) {
            $entry = $feed->createEntry();
            $entry->setTitle($post->getTitle());
            $entry->setLink($this->serverUrlFilter->__invoke($post->getUrl()));
            $entry->addAuthor($this->author);
            $entry->setDateCreated($post->getDate()->getTimestamp());
            $entry->setContent($post->getContent());
            $entry->setDescription($post->getDescription());

            $feed->addEntry($entry);
        }

        return $feed->export('rss');
    }
}
