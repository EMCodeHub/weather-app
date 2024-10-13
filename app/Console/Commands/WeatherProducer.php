<?php

// app/Console/Commands/WeatherProducer.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RdKafka\Producer;
use App\Services\Adapters\WeatherAdapterFactory;

class WeatherProducer extends Command
{
    protected $signature = 'weather:produce';
    protected $description = 'Produce weather data to Kafka';

    public function handle()
    {
        $locations = [
            ['lat' => 55, 'lon' => 13],
        ];

        foreach ($locations as $location) {
            $temperatureTotal = 0;
            $windSpeedTotal = 0;
            $sources = ['BrightSky', 'OpenMeteo', 'WeatherAPI'];

            foreach ($sources as $source) {
                $adapter = WeatherAdapterFactory::create($source);
                $temperature = $adapter->getTemperature($location['lat'], $location['lon']);
                $windSpeed = $adapter->getWindSpeed($location['lat'], $location['lon']);

                if ($temperature !== null && $windSpeed !== null) {
                    $temperatureTotal += $temperature;
                    $windSpeedTotal += $windSpeed;

                    $data = json_encode([
                        'temperature' => $temperature,
                        'wind_speed' => $windSpeed,
                        'location' => $adapter->getLocation($location['lat'], $location['lon']),
                    ]);

                    $this->produceMessage($data);
                }
            }

            $averageTemperature = $temperatureTotal / count($sources);
            $averageWindSpeed = $windSpeedTotal / count($sources);

            // Produce average data as well, if required
            $this->produceMessage(json_encode([
                'temperature' => $averageTemperature,
                'wind_speed' => $averageWindSpeed,
                'location' => 'Average Location',
            ]));
        }

        $this->info('Weather data produced successfully.');
    }

    protected function produceMessage($data)
    {
        $producer = new Producer();
        $producer->addBrokers(config('kafka.brokers'));

        $topic = $producer->newTopic(config('kafka.topic'));
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $data);

        $producer->poll(0);
    }
}
