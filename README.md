# Symfony Twilio Bundle (for Twilio SDK v6+)

# About

A quick and easy way to use the Twilio SDK (version 7) in a Symfony based application.
Support for PHP 8.1+, Symfony >= 6.4.
Check older version of this repo, for supporting older Versions of PHP, Symfony, Twilio SDK.
For full documentation about how to use the Twilio Client, see the [official SDK](https://github.com/twilio/twilio-php) provided by [Twilio](https://www.twilio.com/).

This bundle is a small wrapper around the official sdk.
It just adds the basic auth and configs and avoid that you have to configure your service.yaml manual.

If you are already using the [symfony/notifier](https://symfony.com/doc/current/notifier.html) component, habe a look at [twilio-notifier](https://symfony.com/components/Twilio%20Notifier).

Thank you for the awesome work of [Fridolin Koch](http://fkse.io) who created the first version of this bundle, with support for version 4 of the SDK.

# Installation

```bash
composer req blackford/twilio-bundle
```

# Configuration

Add these 2 parameters in `.env.local` and set it to your twilio credentials.
Please see [Env-Variables](https://symfony.com/doc/current/configuration/env_var_processors.html) for more details.

```yaml
TWILIO_USER='!changeMe!'
TWILIO_PASSWORD='!changeMe!'
```

Add a new file `config/packages/twilio.yml` and copy and adjust the following content:

```yaml
blackford_twilio:
  
  # (Required) Username to authenticate with, typically your Account SID from www.twilio.com/user/account
  username: '%env(TWILIO_USER)%'

  # (Required) Password to authenticate with, typically your Auth Token from www.twilio.com/user/account
  password: '%env(TWILIO_PASSWORD)%'
    
  # (Optional) Account Sid to authenticate with, defaults to <username> (typically not required)
  # accountSid: 
    
  # (Optional) Region to send requests to, defaults to no region selection (typically not required)
  # region: 
```

# Usage

[Configure your Twilio-Account](https://www.twilio.com/blog/verifying-twilio-api-requests-php-symfony-5)

Provided services:

| Service             | Class                         |
|---------------------|-------------------------------|
| `twilio.client`     | `\Twilio\Rest\Client`         |


## Inside a controller:

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

## Inside a console command:

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

# Copyright / License

See [LICENSE](LICENSE)
