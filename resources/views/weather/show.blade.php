<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Data</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #loadingSpinner {
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Weather Data</h1>

            {{-- Mostrar mensaje de error si existe --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Button to show how the API works --}}
            <div class="mb-3 text-center">
                <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#apiExplanation" aria-expanded="false" aria-controls="apiExplanation">
                    How the API Works
                </button>
            </div>

            <div class="mb-3 text-center">
                <a href="{{ route('documentation') }}" class="btn btn-info">View Documentation</a>
            </div>

            {{-- Explanation section --}}
            <div class="collapse" id="apiExplanation">
                <div class="card card-body mb-4">
                    <h5 class="card-title">API Functionality</h5>
                    <p class="card-text">
                        This application fetches weather data from two different APIs. It retrieves current weather information such as temperature and wind speed based on the latitude and longitude you provide. 
                    </p>
                    <p class="card-text">
                        The app calculates the average temperature and wind speed from both APIs to give you a more accurate reading of the current weather conditions. 
                    </p>
                    <p class="card-text">
                        Simply enter the latitude and longitude of your desired location, and click "Get Weather Data" to see the results!
                    </p>
                </div>
            </div>

            {{-- Form to enter latitude and longitude --}}
            <form id="weatherForm" method="GET" action="{{ route('weather.show') }}" class="border p-4 shadow rounded bg-light">
                <div class="mb-3">
                    <label for="lat" class="form-label">Latitude:</label>
                    <input type="text" name="lat" id="lat" class="form-control" required placeholder="Enter latitude">
                </div>
                <div class="mb-3">
                    <label for="lon" class="form-label">Longitude:</label>
                    <input type="text" name="lon" id="lon" class="form-control" required placeholder="Enter longitude">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Get Weather Data</button>
                </div>
            </form>

            {{-- Loading Spinner --}}
            <div id="loadingSpinner" class="text-center mt-3">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Please wait while we fetch the data...</p>
            </div>

            {{-- Show results only if they exist --}}
            @if (isset($averageTemperature) && isset($averageWindSpeed) && isset($apiData))
                <div class="mt-5 p-4 border rounded shadow bg-white" id="results">
                    <h2 class="text-center">Results</h2>
                    <p><strong>Average Temperature:</strong> {{ $averageTemperature }}°C</p>
                    <p><strong>Average Wind Speed:</strong> {{ $averageWindSpeed }} km/h</p>

                    <h3 class="mt-4">Data from API</h3>
                    <ul class="list-group">
                        @foreach ($apiData as $source => $data)
                            <li class="list-group-item">
                                <strong>{{ $source }}</strong>: 
                                Temperature: {{ $data['temperature'] }}°C, 
                                Wind Speed: {{ $data['windSpeed'] }} km/h, 
                                Location: {{ $data['location'] }}, 
                                <a href="{{ $data['url'] }}" target="_blank">View API link used</a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Botón para volver a la ruta inicial --}}
                    <div class="text-center mt-4">
                        <a href="{{ route('weather.show') }}" class="btn btn-secondary">Back to Weather Form</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Link to Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show the loading spinner when the form is submitted
        const form = document.getElementById('weatherForm');
        const loadingSpinner = document.getElementById('loadingSpinner');

        form.addEventListener('submit', function() {
            loadingSpinner.style.display = 'block'; // Show the spinner
        });
    </script>
</body>
</html>
