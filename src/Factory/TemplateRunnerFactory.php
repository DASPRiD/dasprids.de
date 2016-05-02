<?php
declare(strict_types=1);

namespace Staphp\Factory;

use Interop\Container\ContainerInterface;
use Staphp\Paginator\Paginator;
use Staphp\PathGenerator;
use Staphp\TemplateRunner;
use Twig_Environment;

class TemplateRunnerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new TemplateRunner(
            $container->get(Twig_Environment::class),
            $container->get(PathGenerator::class),
            $container->get(Paginator::class)
        );
    }
}
