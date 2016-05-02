<?php
declare(strict_types=1);

namespace Staphp\Factory;

use Interop\Container\ContainerInterface;
use Staphp\Post\PostCollector;
use Staphp\Runner;
use Staphp\TemplateRunner;

class RunnerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new Runner(
            $config['dist_path'],
            $config['site_path'],
            $config['blog_url'],
            $container->get(PostCollector::class),
            $container->get(TemplateRunner::class)
        );
    }
}
