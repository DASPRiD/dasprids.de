<?php
declare(strict_types=1);

namespace Staphp\Post;

use BaconStringUtils\Slugifier;
use DateTimeImmutable;
use DateTimeZone;
use DirectoryIterator;
use DomainException;
use Mni\FrontYAML\Parser;
use Parsedown;

class PostCollector
{
    /**
     * @var string
     */
    private $blogUrl;

    /**
     * @var string
     */
    private $sitePath;

    /**
     * @var DateTimeZone
     */
    private $timeZone;

    public function __construct(string $blogUrl, string $sitePath, DateTimeZone $timeZone)
    {
        $this->blogUrl = rtrim($blogUrl, '/');
        $this->sitePath = rtrim($sitePath, '/');
        $this->timeZone = $timeZone;
    }

    /**
     * @return PostCollection|Post[]
     */
    public function collect() : PostCollection
    {
        $iterator = new DirectoryIterator($this->sitePath . '/posts');
        $parser = new Parser();
        $parsedown = new Parsedown();
        $slugifier = new Slugifier();
        $posts = new PostCollection();
        $tags = [];

        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isFile() || 'md' !== $fileInfo->getExtension()) {
                continue;
            }

            $document = $parser->parse(file_get_contents($fileInfo->getPathname()));
            $postData = $document->getYAML();
            $content = $parsedown->text($document->getContent());

            if (array_key_exists('id', $postData)) {
                $id = $postData['id'];
            } else {
                $id = $fileInfo->getBasename('.md');
            }

            if (!array_key_exists('title', $postData)) {
                throw new DomainException(sprintf('Missing "title" front matter in "%s"', $fileInfo->getPathname()));
            }

            if (!array_key_exists('date', $postData)) {
                throw new DomainException(sprintf('Missing "date" front matter in "%s"', $fileInfo->getPathname()));
            }

            if (!array_key_exists('tags', $postData)) {
                $postData['tags'] = [];
            } elseif (!is_array($postData['tags'])) {
                throw new DomainException(sprintf('Not an array "tags" front matter in "%s"', $fileInfo->getPathname()));
            }

            $postTags = new TagCollection();

            foreach ($postData['tags'] as $tag) {
                $tagSlug = $slugifier->slugify($tag);

                if (!array_key_exists($tagSlug, $tags)) {
                    $tags[$tagSlug] = new Tag(
                        $tag,
                        $this->blogUrl . '/tag/' . $slugifier->slugify($tag) . '/'
                    );
                }

                $postTags->addItem($tags[$tagSlug]);
            }

            $title = $postData['title'];

            if (array_key_exists('description', $postData)) {
                $description = $postData['description'];
            } else {
                $description = substr(strip_tags($content), 0, 50) . '…';
            }

            if (array_key_exists('slug', $postData)) {
                $slug = $postData['slug'];
            } else {
                $slug = $slugifier->slugify($title);
            }

            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s O', $postData['date']);
            $date->setTimezone($this->timeZone);

            if (array_key_exists('metaData', $postData)) {
                $metaData = (array) $postData['metaData'];
            } else {
                $metaData = [];
            }

            $post = new Post(
                $id,
                $title,
                $date,
                $this->blogUrl . '/' . $date->format('Y/m/d') . '/' . $slug . '/',
                $description,
                $content,
                $postTags,
                $metaData
            );

            $posts->addItem($post);

            foreach ($postTags as $postTag) {
                $postTag->getPosts()->addItem($post);
            }
        }

        $posts->sortByDate();

        foreach ($tags as $tag) {
            $tag->getPosts()->sortByDate();
        }

        return $posts;
    }
}
