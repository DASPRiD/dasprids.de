<?php
declare(strict_types=1);

namespace Staphp\Factory;

use DateTimeZone;
use Interop\Container\ContainerInterface;
use Twig_Environment;
use Twig_Extensions_Extension_Intl;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class TwigEnvironmentFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $loader = new Twig_Loader_Filesystem($config['site_path']);

        $twig = new Twig_Environment($loader);
        $twig->getExtension('core')->setTimezone($container->get(DateTimeZone::class));
        $twig->addExtension(new Twig_Extensions_Extension_Intl());

        foreach ($config['twig']['filters'] as $name => $containerKey) {
            $twig->addFilter(new Twig_SimpleFilter($name, $container->get($containerKey)));
        }

        foreach ($config['twig']['functions'] as $name => $containerKey) {
            $twig->addFunction($name, new Twig_SimpleFunction($name, $container->get($containerKey)));
        }

        return $twig;
    }
}
