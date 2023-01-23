<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void
{
    $services = $containerConfigurator->services();

    $services->set('@twilio.client', Twilio\Rest\Client::class)
        ->public()
        ->args(
            [
                '%blackford_twilio.username%',
                '%blackford_twilio.password%',
                '%blackford_twilio.accountSid%',
                '%blackford_twilio.region%',
            ]
        )
        ->tag('controller.service_arguments')
    ;

    $services->alias(Twilio\Rest\Client::class, '@twilio.client');
};
