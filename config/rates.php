<?php

use App\Rates\CBR;
use App\Rates\YAHOO;

return [
  'CronJobTtl' => 15, // How long command will be executed (minutes)
  'CommandExistsFlagName' => 'cron_get_rates', // Key name in cache to indicate what command is executed
  'CommandLoopTimeout' => 10, // How long to wait betwenn iteratins (seconds)
  'CurrentRateKeyName' => 'current_rate', // Key name in cache for current rate
  'sources' => [
    [ 'class' => App\Rates\CBR::class,
      'dataSource' => 'http://www.cbr.ru/scripts/XML_daily.asp',
      'priority' => 3,
    ],
    [ 'class' => App\Rates\YAHOO::class,
      'dataSource' => 'https://query.yahooapis.com/v1/public/yql?q=select+*+from+yahoo.finance.xchange+where+pair+=+%22USDRUB,EURRUB%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback',
      'priority' => 2,
    ],
  ],
];
