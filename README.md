## How to Launch the Weather Application

Follow the steps below to set up and run the Weather application:

### 1. Clone the Repository
Clone the repository to your local machine:

git clone https://github.com/your-username/weather-application.git


### 2. Navigate to the Project Directory

Change into the project directory:


cd weather-application



### 3. Install Necessary Dependencies

Install the required dependencies using Composer:

composer install



### 4. Create the Database


Create a new database for the application. You can use the following SQL command in your database management tool (e.g., MySQL Workbench):
sql
CREATE DATABASE weather_db;



### 5. Configure the Database

Update the .env file to configure the database connection. Make sure the values match your local database configuration:

dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=weather_db
DB_USERNAME=your_username
DB_PASSWORD=your_password


Important add this to the .env document

KAFKA_BROKER=localhost:9092
KAFKA_TOPIC=weather
WEATHERAPI_KEY=2d093f92eb494259860135409241010



### 6. Run Database Migrations

Run the migrations to set up the database schema:

php artisan migrate



### 7. Install Kafka and Guzzle Dependencies

Install the necessary packages for Kafka and Guzzle:

composer require nmred/kafka-php guzzlehttp/guzzle



### 8. Start the Application Server

Start the Laravel development server:

php artisan serve


### 9. Start Kafka Consumers (Optional)

If you are using Kafka, you can start the Kafka consumer with the following command:

php artisan weather:consume


### 10. Access the Application

Open your web browser and navigate to http://localhost:8000 to access the application.


Additional Information
Ensure you have Kafka running and properly configured if you intend to use it.
Refer to the API documentation for further configuration or usage details.