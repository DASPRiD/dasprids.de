<?php
return [
    'dist_path' => 'dist',
    'site_path' => 'site',
    'blog_url' => '/blog',
    'server_url' => 'https://dasprids.de',
    'time_zone' => 'Europe/Berlin',

    'twig' => [
        'filters' => [
            'serverurl' => Staphp\Filter\ServerUrlFilter::class,
        ],
        'functions' => [
            'paginate' => Staphp\Paginator\Paginator::class,
        ],
    ],

    'dependencies' => [
        'factories' => [
            Staphp\Filter\ServerUrlFilter::class => Staphp\Factory\Filter\ServerUrlFilterFactory::class,
            Staphp\Post\PostCollector::class => Staphp\Factory\Post\PostCollectorFactory::class,
            DateTimeZone::class => Staphp\Factory\DateTimeZoneFactory::class,
            Staphp\PathGenerator::class => Staphp\Factory\PathGeneratorFactory::class,
            Staphp\Runner::class => Staphp\Factory\RunnerFactory::class,
            Staphp\TemplateRunner::class => Staphp\Factory\TemplateRunnerFactory::class,
            Twig_Environment::class => Staphp\Factory\TwigEnvironmentFactory::class,
        ],
        'invokables' => [
            Staphp\Paginator\Paginator::class => Staphp\Paginator\Paginator::class,
        ],
    ],
];
