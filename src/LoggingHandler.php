<?php

namespace Voh\LaravelGoogleLogging;

use Google\Cloud\Logging\LoggingClient;
use Illuminate\Support\Arr;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class LoggingHandler extends AbstractProcessingHandler
{
	/**
	 * @var \Google\Cloud\Logging\Logger
	 */
	private $logger;

	public function __construct(array $config, $level = Logger::DEBUG, bool $bubble = true)
	{
		$this->logger = (new LoggingClient($config))
			->logger(
				Arr::get($config, 'logName'),
				[
					'labels' => Arr::get($config, 'labels')
				]
			);
		parent::__construct($level, $bubble);
	}

	/**
	 * @param array $record
	 */
	protected function write(array $record): void
	{
		$data = [
			'message' => $record['message'],
		];

		if ($context = $record['context']) {
			/**
			 * @var \Exception $exception
			 */
			$exception = $context['exception'];
			$data['context'] = [
				'file' => $exception->getFile(),
				'line' => $exception->getLine(),
				'trace' => $exception->getTraceAsString(),
				'code' => $exception->getCode(),
			];
		}

		$entry = $this->logger->entry($data, [
			'severity' => $record['level_name'],
		]);
		$this->logger->write($entry);
	}
}
