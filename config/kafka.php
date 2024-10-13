<?php

return [
    'brokers' => env('KAFKA_BROKER', 'localhost:9092'),
    'topic' => env('KAFKA_TOPIC', 'weather'),
];
