<?php

namespace App\Console\Commands;

use App\Interfaces\Rate as RateInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Log;


class GetRates extends Command
{
    const CRON_JOB_TTL = 1; // How long command will be executed (minutes)
    const LOOP_TIMEOUT = 10; // How long to wait betwenn iteratins (seconds)

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get curency rates';

    /**
     * Currency rate sources [ [ $url_1, $priority_1], [ $url_2, $priority_2], ... ]
     *
     * @var array
     */
    protected $rates;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
      $jobExists = config('rates.CommandExistsFlagName');
      if( ! $jobExists ) {
        $this->error( "Config option 'rates.CommandExistsFlagName' is not defined.");
        exit();
      }
      if( Cache::has( $jobExists )) {
        $this->info( "'Get rates' command is already running.");
      } else {
        if( ! $jobTtl = config('rates.CronJobTtl')) {
          $this->error( "Config option 'rates.CronJobTtl' is not defined.");
          exit();
        }
        if( ! $timeout = config('rates.CommandLoopTimeout')) {
          $this->error( "Config option 'rates.CommandLoopTimeout' is not defined.");
          exit();
        }
        Cache::put( $jobExists, 1, $jobTtl );
        while( Cache::has( $jobExists) ){
          if( $this->loadSources()) {
            $this->process();
          } else {
            $this->error( "Error while processing.");
          }
          sleep( $timeout );
        }
        Cache::forget( $jobExists );
      }
    }

    protected function process()
    {
      $result = null;
      $sortedKeys = array_keys( $this->rates );
      sort( $sortedKeys );
      foreach( $sortedKeys as $index ) {
        /* @var $rate RateInterface */
        $rate = new $this->rates [$index] ['class'] ();

        $rate->init( $this->rates [$index] ['dataSource'] );

        if( ! $rate->download()) {
            $this->error( "Can`t download rate.");
            continue;
        }

        if( ! $rate->parse()) {
            $this->error( "Can`t parse rate.");
            continue;
        }

        if( ! $current = $rate->value()) {
            $this->error( "Can`t get the rate value.");
            continue;
        }

        if( ! $currentRateKey = config('rates.CurrentRateKeyName')) {
          $this->error( "Config option 'rates.CurrentRateKeyName' is not defined.");
          break;
        }

        Cache::forever( $currentRateKey, $current );

        $result = true;
        break;
      }
      return $result;
    }

    /**
     * Load and check rate sources
     *
     * @throws \Exception
     */
    protected function loadSources() {

        $rates = config('rates.sources');

        if( ! $rates || ! is_array( $rates )) {
          $this->error( 'Rate sources is not defined');
        }

        $newRates = [];

        foreach( $rates as $k => $rate ) {

          if( ! is_array( $rate) ||
              ! isset( $rate ['class']) ||
              ! isset( $rate ['dataSource']) ||
              ! isset( $rate ['priority'])
            ) {
              $this->error( "Invalid rate source at position [{$k}].");
              continue;
            }

            if( ! class_exists( $rate ['class'])) {
              $this->error( "Class for rate at position [{$k}] does not exists.");
              continue;
            }

            if( ! is_subclass_of( $rate ['class'], RateInterface::class )) {
              $this->error( "Invalid class for rate at position [{$k}].");
              continue;
            }

            // Не стал заморачиваться с автоиндексацией ...
            $index = (int) $rate ['priority'];
            if( isset( $newRates [$index])) {
              $this->error( "Rate with [{$index}] priority already exists.");
              continue;
            }
            $newRates [$index] = $rate;
        }
        if( empty( $newRates )) {
          $this->error( "There are no aviable rates.");
          return false;
        } else {
          $this->rates = $newRates;
          return true;
        }
    }
}
