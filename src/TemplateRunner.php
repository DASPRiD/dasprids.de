<?php
declare(strict_types=1);

namespace Staphp;

use Staphp\Paginator\Paginator;
use Staphp\PathGenerator;
use Twig_Environment;

class TemplateRunner
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var PathGenerator
     */
    private $pathGenerator;

    /**
     * @var Paginator
     */
    private $paginator;

    public function __construct(Twig_Environment $twig, PathGenerator $pathGenerator, Paginator $paginator)
    {
        $this->twig = $twig;
        $this->pathGenerator = $pathGenerator;
        $this->paginator = $paginator;
    }

    public function run(string $templatePath, array $variables, string $targetUrl)
    {
        $this->paginator->setBaseUrl($targetUrl);
        $targetPath = $this->pathGenerator->generatePath($targetUrl);
        $targetDirectory = dirname($targetPath);

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $variables += ['url' => $targetUrl];

        file_put_contents($targetPath, $this->twig->render($templatePath, $variables));

        if ($this->paginator->hasPagination()) {
            $pagination = $this->paginator->getPagination();

            while ($pagination->advance()) {
                $targetPath = $this->pathGenerator->generatePath($pagination->getCurrentPageUrl());
                mkdir(dirname($targetPath), 0755, true);
                file_put_contents($targetPath, $this->twig->render($templatePath, $variables));
            }
        }

        $this->paginator->resetPagination();
    }
}
