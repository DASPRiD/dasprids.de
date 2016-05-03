<?php
declare(strict_types=1);

namespace Staphp\Factory\Filter;

use Interop\Container\ContainerInterface;
use Staphp\Filter\RssFilter;

class RssFilterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new RssFilter(
            $container->get(\Staphp\Filter\ServerUrlFilter::class),
            $config['rss']['author']
        );
    }
}
