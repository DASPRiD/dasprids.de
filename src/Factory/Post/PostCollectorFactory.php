<?php
declare(strict_types=1);

namespace Staphp\Factory\Post;

use DateTimeZone;
use Interop\Container\ContainerInterface;
use Staphp\Post\PostCollector;

class PostCollectorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new PostCollector(
            $config['blog_url'],
            $config['site_path'],
            $container->get(DateTimeZone::class)
        );
    }
}
