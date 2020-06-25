<?php

namespace Voh\LaravelGoogleLogging;

use Illuminate\Log\ParsesLogConfiguration;
use Illuminate\Support\Arr;
use Monolog\Logger;

/**
 * Class LoggingDriver
 *
 * @package Voh\LaravelGoogleLogging
 */
class LoggingDriver
{
	use ParsesLogConfiguration;

	/**
	 * @var array
	 */
	private $config;

	/**
	 * @param $config
	 *
	 * @return \Monolog\Logger
	 */
	public function __invoke($config)
	{
		$this->config = $config;
		return new Logger($this->parseChannel($config), [
			new LoggingHandler(
				$config,
				$this->level($config)
			),
		]);
	}

	/**
	 * @return string
	 */
	protected function getFallbackChannelName()
	{
		return Arr::get($this->config, 'logName', 'google-logging');
	}
}
