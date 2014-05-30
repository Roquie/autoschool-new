<?php defined('SYSPATH') or die('No direct script access.');

class Email11 extends Kohana_Email
{
    protected static $_config = array();

    public function setCfg(array $cfg = array())
    {
        if (empty($cfg))
        {
            $cfg = Kohana::$config->load('email.default');
        }

        static::$_config =  $cfg;

        return $this;
    }

    public function send(array & $failed = NULL)
    {
        try
        {
            $result = Email::mailer()->send($this->_message, $failed);
        }
        catch(Swift_SwiftException $e)
        {

        }

        return $result;
    }


    public static function mailer()
    {
        if ( ! Email::$_mailer)
        {

            $config = static::$_config + array(
                    'driver'  => 'native',
                    'options' => array(),
                );

            // Extract configured options
            extract($config, EXTR_SKIP);

            if ($driver === 'smtp')
            {
                // Create SMTP transport
                $transport = Swift_SmtpTransport::newInstance($options['hostname']);

                if (isset($options['port']))
                {
                    // Set custom port number
                    $transport->setPort($options['port']);
                }

                if (isset($options['encryption']))
                {
                    // Set encryption
                    $transport->setEncryption($options['encryption']);
                }

                if (isset($options['username']))
                {
                    // Require authentication, username
                    $transport->setUsername($options['username']);
                }

                if (isset($options['password']))
                {
                    // Require authentication, password
                    $transport->setPassword($options['password']);
                }

                if (isset($options['timeout']))
                {
                    // Use custom timeout setting
                    $transport->setTimeout($options['timeout']);
                }
            }
            elseif ($driver === 'sendmail')
            {
                // Create sendmail transport
                $transport = Swift_SendmailTransport::newInstance();

                if (isset($options['command']))
                {
                    // Use custom sendmail command
                    $transport->setCommand($options['command']);
                }
            }
            else
            {
                // Create native transport
                $transport = Swift_MailTransport::newInstance();

                if (isset($options['params']))
                {
                    // Set extra parameters for mail()
                    $transport->setExtraParams($options['params']);
                }
            }

            // Create the SwiftMailer instance
            Email::$_mailer = Swift_Mailer::newInstance($transport);
        }

        return Email::$_mailer;
    }
}
