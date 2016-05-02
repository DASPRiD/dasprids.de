<?php
declare(strict_types=1);

namespace Staphp\Factory;

use Interop\Container\ContainerInterface;
use Staphp\PathGenerator;

class PathGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new PathGenerator($config['dist_path']);
    }
}
