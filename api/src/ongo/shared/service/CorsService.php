<?php

namespace ongo\shared\service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CorsService {
	private $path;
	private $allowOrigin;
	private $allowMethods;
	private $allowHeaders;
	private $maxAge;

	public function __construct($path, $allowOrigin, $allowMethods, $allowHeaders, $maxAge) {
		$this->path = $path;
		$this->allowOrigin = $allowOrigin;
		$this->allowMethods = $allowMethods;
		$this->allowHeaders = $allowHeaders;
		$this->maxAge = $maxAge;
	}

	public function isCors(Request $request) {
		return (preg_match($this->path, $request->getPathInfo()) == 1);
	}

	public function setHeaders(Response $response) {
		$response->headers->set("Access-Control-Allow-Origin", $this->allowOrigin);
		$response->headers->set("Access-Control-Allow-Methods", $this->allowMethods);
		$response->headers->set("Access-Control-Allow-Headers", $this->allowHeaders);
		$response->headers->set("Access-Control-Max-Age", $this->maxAge);
	}
}

?>