# Laravel Google Logging Handler

Laravel google logging handler

## Requirement
* Laravel 5.8 or above
* Logging Admin Role in Google Cloud Platform IAM

## Install
```shell
composer require vohinc/laravel-google-logging
```

## Config

Add a new driver to your logging.php

```
'google-logging' => [
    'driver' => 'custom',
    'via' => \Voh\LaravelGoogleLogging\LoggingDriver::class,
    'level' => 'debug',
    'projectId' => 'your-google-project-id',
    'keyFilePath' => 'google-credential-file-path,
    'logName' => 'application-log',
    'labels' => [
        'application' => 'my-application',
    ],
],
```
