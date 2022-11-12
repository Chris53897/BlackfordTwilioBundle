# Symfony Twilio Bundle (for PHP SDK v6)

About
-----

A quick and easy way to use the Twilio SDK (version 6) in a Symfony based application.

Support for PHP 8+, Symfony >= 5.4.

For full documentation about how to use the Twilio Client, see the [official SDK](https://github.com/twilio/twilio-php) provided by [Twilio](https://www.twilio.com/).

Thank you for the awesome work of [Fridolin Koch](http://fkse.io) who created the first version of this bundle, with support for version 4 of the SDK.

Installation
------------

```
composer req blackford/twilio-bundle
```

Configuration
-------------

Add a new file `config/packages/twilio.yml` and copy and adjust the following content:
Please see [Env-Variables](https://symfony.com/doc/current/configuration/env_var_processors.html) for more Security.

```yaml
blackford_twilio:
    # (Required) Username to authenticate with, typically your Account SID from www.twilio.com/user/account
    username: 'TODO'
    
    # (Required) Password to authenticate with, typically your Auth Token from www.twilio.com/user/account
    password: 'TODO'
    
    # (Optional) Account Sid to authenticate with, defaults to <username> (typically not required)
    # accountSid: 
    
    # (Optional) Region to send requests to, defaults to no region selection (typically not required)
    # region: 
```

Usage
-----

Provided services:

| Service             | Class                         |
|---------------------|-------------------------------|
| `twilio.client`     | `\Twilio\Rest\Client`         |


Inside a controller:

```php
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client as TwilioClient;

class TestController extends Controller
{
    public function __construct(private TwilioClient $twilioClient)
    {}
    
    public function smsAction()
    {
        $date = date('r');
        
        $message = $this->twilioClient->messages->create(
            '+12125551234', // Text any number
            array(
                'from' => '+14085551234', // From a Twilio number in your account
                'body' => "Hi there, it's $date and Twilio is working properly."
            )
        );

        return new Response("Sent message [$message->sid] via Twilio.");
    }
}
```

Inside a console command:

```php
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Twilio\Rest\Client as TwilioClient;

#[AsCommand(name: 'twilio:test:sms', description: 'Test the Twilio integration by sending a text message.')]
class TwilioTestCommand extends ContainerAwareCommand
{
    public function __construct(private TwilioClient $twilioClient)
    {}
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $date = date('r');
         
         $message = $this->twilioClient->messages->create(
             '+12125551234', // Text any number
             array(
                 'from' => '+14085551234', // From a Twilio number in your account
                 'body' => "Hi there, it's $date and Twilio is working properly."
             )
         );
        
        $output->writeln("Sent message [$message->sid] via Twilio.");
    }
}
```

Copyright / License
-------------------

See [LICENSE](LICENSE)
