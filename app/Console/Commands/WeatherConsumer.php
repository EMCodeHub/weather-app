<?php

// app/Console/Commands/WeatherConsumer.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RdKafka\Consumer;
use RdKafka\ConsumerTopic;

class WeatherConsumer extends Command
{
    protected $signature = 'weather:consume';
    protected $description = 'Consume weather data from Kafka';

    public function handle()
    {
        $consumer = new Consumer();
        $consumer->setLogLevel(LOG_DEBUG);
        $consumer->addBrokers(config('kafka.brokers'));

        $topic = $consumer->newTopic(config('kafka.topic'));
        $topic->consumeStart(0, RD_KAFKA_OFFSET_END);

        while (true) {
            $message = $topic->consume(0, 1000);

            if ($message->err) {
                if ($message->err == RD_KAFKA_RESP_ERR__TIMED_OUT) {
                    continue;
                }
                $this->error("Error consuming message: {$message->errstr()}");
                break;
            }

            $data = json_decode($message->payload, true);
            $this->info("Received weather data: Temperature: {$data['temperature']}, Wind Speed: {$data['wind_speed']} at {$data['location']}");
        }
    }
}
