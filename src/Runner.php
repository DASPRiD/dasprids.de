<?php
declare(strict_types=1);

namespace Staphp;

use DirectoryIterator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Staphp\Archive\Year;
use Staphp\Archive\YearCollection;
use Staphp\Post\PostCollection;
use Staphp\Post\PostCollector;
use Staphp\Post\TagCollection;

class Runner
{
    /**
     * @var string
     */
    private $distPath;

    /**
     * @var string
     */
    private $sitePath;

    /**
     * @var string
     */
    private $blogUrl;

    /**
     * @var PostCollector
     */
    private $postCollector;

    /**
     * @var TemplateRunner
     */
    private $templateRunner;

    public function __construct(
        string $distPath,
        string $sitePath,
        string $blogUrl,
        PostCollector $postCollector,
        TemplateRunner $templateRunner
    ) {
        $this->distPath = rtrim($distPath, '/');
        $this->sitePath = rtrim($sitePath, '/');
        $this->blogUrl = rtrim($blogUrl, '/');
        $this->postCollector = $postCollector;
        $this->templateRunner = $templateRunner;
    }

    public function run()
    {
        $posts = $this->postCollector->collect();
        $tags = $this->createTagList($posts);
        $archives = $this->createArchiveList($posts);

        $sharedVariables = [
            'posts' => $posts,
            'tags' => $tags,
            'archives' => $archives,
        ];

        $this->initializeDistDirectory();
        $this->generatePosts($posts, $sharedVariables);
        $this->generateTags($tags, $sharedVariables);
        $this->generateArchives($archives, $sharedVariables);
        $this->generatePages($sharedVariables);
        $this->copyStaticFiles();
    }

    private function createTagList(PostCollection $posts) : TagCollection
    {
        $tags = [];

        foreach ($posts as $post) {
            foreach ($post->getTags() as $tag) {
                if (!array_key_exists($tag->getUrl(), $tags)) {
                    $tags[$tag->getUrl()] = $tag;
                }
            }
        }

        $collection = new TagCollection($tags);
        $collection->sortByLabel();

        return $collection;
    }

    private function createArchiveList(PostCollection $posts) : YearCollection
    {
        $years = [];

        foreach ($posts as $post) {
            $year = (int) $post->getDate()->format('Y');

            if (!array_key_exists($year, $years)) {
                $years[$year] = new Year($year, $this->blogUrl . '/archive/' . $year . '/');
            }

            $years[$year]->getPosts()->addItem($post);
        }

        foreach ($years as $year) {
            $year->getPosts()->sortByDate();
        }

        $collection = new YearCollection($years);
        $collection->sortByYear();

        return $collection;
    }

    private function generatePosts(PostCollection $posts, array $sharedVariables)
    {
        foreach ($posts as $post) {
            $this->templateRunner->run('layout/post.twig', $sharedVariables + ['post' => $post], $post->getUrl());
        }
    }

    private function generateTags(TagCollection $tags, array $sharedVariables)
    {
        foreach ($tags as $tag) {
            $this->templateRunner->run('layout/tag.twig', $sharedVariables + ['tag' => $tag], $tag->getUrl());
        }
    }

    private function generateArchives(YearCollection $years, array $sharedVariables)
    {
        foreach ($years as $year) {
            $this->templateRunner->run('layout/archive.twig', $sharedVariables + ['year' => $year], $year->getUrl());
        }
    }

    private function generatePages(array $sharedVariables)
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->sitePath . '/pages',
                FilesystemIterator::KEY_AS_PATHNAME
                | FilesystemIterator::CURRENT_AS_FILEINFO
                | FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isDir()) {
                continue;
            }

            if ('twig' !== $fileInfo->getExtension()) {
                continue;
            }

            $targetUrl = preg_replace(
                '(^' . preg_quote($this->sitePath) . '/pages(/.*?)(?:index\.html)?\.twig$)',
                '\1',
                $fileInfo->getPathname()
            );
            $templatePath = preg_replace(
                '(^' . preg_quote($this->sitePath) . ')',
                '',
                $fileInfo->getPathname()
            );

            $this->templateRunner->run($templatePath, $sharedVariables, $targetUrl);
        }
    }

    private function copyStaticFiles()
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->sitePath . '/static',
                FilesystemIterator::KEY_AS_PATHNAME
                | FilesystemIterator::CURRENT_AS_FILEINFO
                | FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $fileInfo) {
            $targetPath = preg_replace(
                '(^' . preg_quote($this->sitePath) . '/static)',
                $this->distPath,
                $fileInfo->getPathname()
            );

            if ($fileInfo->isDir()) {
                mkdir($targetPath, 0755);
                continue;
            }

            copy($fileInfo->getPathname(), $targetPath);
        }
    }

    private function initializeDistDirectory()
    {
        if (file_exists($this->distPath)) {
            $this->deleteDirectory($this->distPath);
        }

        mkdir($this->distPath, 0755);
    }

    private function deleteDirectory(string $path)
    {
        foreach (new DirectoryIterator($path) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }

            if ($fileInfo->isDir()) {
                $this->deleteDirectory($fileInfo->getPathname());
                continue;
            }

            unlink($fileInfo->getPathname());
        }

        rmdir($path);
    }
}
