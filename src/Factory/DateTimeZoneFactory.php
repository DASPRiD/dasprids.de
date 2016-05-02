<?php
declare(strict_types=1);

namespace Staphp\Factory;

use DateTimeZone;
use Interop\Container\ContainerInterface;

class DateTimeZoneFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new DateTimeZone($config['time_zone']);
    }
}
