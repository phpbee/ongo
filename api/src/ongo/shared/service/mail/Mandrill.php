<?php
/**
 * Created by PhpStorm.
 * User: alexk
 * Date: 03/05/16
 * Time: 14:12
 */

namespace ongo\shared\service\mail;


class Mandrill implements MailService
{
    /** @var  \Mandrill */
    private $mandrill;

    /** @var  string */
    private $from_email;

    /** @var  string */
    private $from_name;

    /**
     * Mandrill constructor.
     * @param \Mandrill $mandrill
     * @param string $from_email
     * @param string $from_name
     */
    public function __construct(\Mandrill $mandrill, $from_email, $from_name)
    {
        $this->mandrill = $mandrill;
        $this->from_email = $from_email;
        $this->from_name = $from_name;
    }


    public function send($recipient, $subject, $body)
    {
        $message = array(
            'subject' => $subject,
            'text' => $body,
            'from_email' => $this->from_email,
            'from_name' => $this->from_name,
            'to' => array(
                array(
                    'type' => 'to',
                    'email' => $recipient
                ),
            ),
            'track_opens' => false,
            'track_clicks' => false,
            'view_content_link' => false,
        );

        $this->mandrill->messages->send($message);
    }
}