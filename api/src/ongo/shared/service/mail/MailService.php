<?php

namespace ongo\shared\service\mail;

interface MailService {
	/**
	 * @param string $recipient
	 * @param string $subject
	 * @param string $body
	 */
	public function send($recipient, $subject, $body);
}

?>