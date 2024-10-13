<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Application Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Weather Application Documentation</h1>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Introduction</div>
            <div class="card-body">
                <p>
                    This documentation describes the Weather Application, a Laravel-based project designed to gather weather data from multiple external APIs. The application integrates with Kafka to consume and produce weather data streams. It supports data persistence and caching to optimize performance. The codebase adheres to SOLID principles and follows Laravel best practices.
                </p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">How to Launch the Application</div>
            <div class="card-body">
                <ol>
                    <li>Clone the repository and navigate to the project directory.</li>
                    <li>Install the necessary dependencies using Composer:
                        <pre><code>composer install</code></pre>
                    </li>
                    <li>Create the database:
                        <pre><code>CREATE DATABASE weather_db;</code></pre>
                    </li>
                    <li>Run the database migrations:
                        <pre><code>php artisan migrate</code></pre>
                    </li>
                    <li>Install Kafka and Guzzle dependencies:
                        <pre><code>composer require nmred/kafka-php guzzlehttp/guzzle</code></pre>
                    </li>
                    <li>Start the application server:
                        <pre><code>php artisan serve</code></pre>
                    </li>
                    <li>Start Kafka Consumers (optional, if Kafka is being used):
                        <pre><code>php artisan weather:consume</code></pre>
                    </li>
                </ol>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Application Features</div>
            <div class="card-body">
                <ul>
                    <li><strong>Multiple API Integration:</strong> The app integrates multiple weather sources such as OpenMeteo, WeatherAPI, and BrightSky.</li>
                    <li><strong>Data Caching:</strong> Cached data is used to minimize unnecessary API calls, improving performance.</li>
                    <li><strong>Kafka Integration:</strong> Kafka is used for consuming and producing weather data asynchronously.</li>
                    <li><strong>Database Transactions:</strong> All database operations are wrapped in transactions to ensure data integrity.</li>
                    <li><strong>SOLID Principles:</strong> The application follows SOLID principles with the use of interfaces and factories for the different weather API integrations.</li>
                    <li><strong>Logging:</strong> Separate log streams are used for errors and informational logs, following a thread-based logging mechanism.</li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Step-by-Step Application Flow</div>
            <div class="card-body">
                <ol>
                    <li>User submits latitude and longitude via a form.</li>
                    <li>The application checks for cached weather data for the provided location.</li>
                    <li>If no cache exists, the app fetches weather data from multiple APIs.</li>
                    <li>The data is saved to the database, and averages for temperature and wind speed are calculated.</li>
                    <li>The result is returned to the user and also cached for future requests.</li>
                    <li>Optional Kafka producers/consumers handle asynchronous data processing.</li>
                </ol>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Database Structure and Connections</div>
            <div class="card-body">
                <h5>Database Tables:</h5>
                <ul>
                    <li><strong>requests:</strong> Stores the user's latitude and longitude requests.</li>
                    <li><strong>weather_data:</strong> Stores the weather data fetched from different APIs, linked to the request via a foreign key.</li>
                </ul>
                <h5>Relationships:</h5>
                <p>The <code>Request</code> model has a one-to-many relationship with <code>WeatherData</code> model. Each request can have multiple associated weather data entries from different sources.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Adherence to SOLID Principles</div>
            <div class="card-body">
                <p>
                    The application code adheres to the SOLID principles:
                </p>
                <ul>
                    <li><strong>Single Responsibility:</strong> Each class handles one specific task, such as fetching weather data from APIs or managing Kafka messages.</li>
                    <li><strong>Open/Closed Principle:</strong> The system is designed to easily integrate new weather sources without modifying existing code by leveraging the <code>WeatherAdapterFactory</code>.</li>
                    <li><strong>Liskov Substitution:</strong> All API adapters implement a common interface <code>WeatherAdapterInterface</code>, ensuring interchangeable use.</li>
                    <li><strong>Interface Segregation:</strong> The <code>WeatherAdapterInterface</code> only contains relevant methods for fetching weather data.</li>
                    <li><strong>Dependency Inversion:</strong> The factory pattern is used to invert the dependency between the app and API sources.</li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Testing</div>
            <div class="card-body">
                <h5>Unit and Functional Tests</h5>
                <p>
                    The application includes unit and functional tests to ensure its correct functionality:
                </p>
                <ul>
                    <li>Functional tests validate API integration and database operations.</li>
                    <li>Unit tests focus on isolated classes, especially the adapters for weather sources.</li>
                    <li>Tests for both successful and unsuccessful data retrieval are included.</li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Conclusion</div>
            <div class="card-body">
                <p>
                    This Laravel-based weather application follows best practices in software architecture, adhering to the SOLID principles and ensuring modularity and scalability. It provides a flexible framework to integrate additional data sources, Kafka integration for message-based communication, and robust error-handling and caching mechanisms to improve performance.
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
