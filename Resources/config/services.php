<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void
{
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire();

    $services->alias(Twilio\Rest\Client::class, 'twilio.client');

    $services->set(Twilio\Rest\Client::class)
        ->tag('controller.service_arguments');
};
