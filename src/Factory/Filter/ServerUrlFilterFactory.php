<?php
declare(strict_types=1);

namespace Staphp\Factory\Filter;

use Interop\Container\ContainerInterface;
use Staphp\Filter\ServerUrlFilter;

class ServerUrlFilterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new ServerUrlFilter($config['server_url']);
    }
}
