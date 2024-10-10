# COVID Vaccine Registration System

\*\*I've used Laragon for this project. Instructions will be provided based on that.

## Installation

1. **Clone the repository inside "laragon\www" directory:**
    ```bash
    git clone https://github.com/FarhanIsrakYen/vaccinationRegistrationSystem.git
    ```
2. **Install dependencies:**
    ```bash
    cd vaccinationRegistrationSystem
    composer install
    ```
3. **Copy the .env.example file to .env:**
    ```bash
    cp .env.example .env
    ```
4. **Generate the application key:**
    ```bash
    php artisan key:generate
    ```
5. **Set up your database connection in the .env file:**
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```
6. **Run migrations:**
    ```bash
    php artisan migrate --seed
    ```
7. **Make sure to configure your queue driver in the .env file and update mail credentials. I have used mailtrap. The account of provided credentials was created for test purpose:**
    ```bash
    QUEUE_CONNECTION=database
    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=78f5a5b1ea9f8e
    MAIL_PASSWORD=941b229bfc893d
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="info@vaccination.com"
    MAIL_FROM_NAME="Covid Vaccination Center"
    ```

## Running the Application

1. **Start the development server:**
    ```bash
    php artisan serve
    ```
    This will start the server at http://localhost:8000 . Check it from your browser. Also a file named CovidVaccinationRS.json has been provided which you can import in postman to test the api endpoints.

## Queue Management

To process queued jobs, you'll need to run the queue worker:

1. **Start the queue worker:**
    ```bash
    php artisan queue:work
    ```
    This command will start processing jobs from the queue. You can run this command in a separate terminal.

## Vaccination Reminder

A cronjob was set for the reminder.:

1. **Once there are enough data to test, run the following command to send reminder.:**
    ```bash
    php artisan send:vaccination-reminder
    ```
    This command will help to send a reminder at 9 PM to the users registered for next day's vaccination.

## Improvements

1. **To make performance faster:**
   I'll like to store the vaccination center data in the Cache so that instead of hitting DB every time, I'll be able to use the data from cache which will make it more faster and smoother. There will be a cronjob for storing that data so that if there's any changes then it'll be updated. Also if a new vaccinations center will be added or anything will be updated, this will update the cache data also.
2. **Sending ‘SMS’ notification along with the email:**
   Here are the instructions for adding SMS notifications along with email notifications in the future:
    ```
    ** Select an SMS gateway provider like Twilio, Nexmo, or any local SMS provider.
    ** Install the corresponding SDK or package for Laravel via Composer.
    ** Add environment variables for your chosen SMS service (e.g., API keys, phone numbers) to the .env file.
    ** Create a new service class dedicated to sending SMS messages. This service will interact with the SMS provider's API.
    ** In the notification class where the email is sent, add logic to call the SMS service to send an SMS notification to the user.
    ** Use Laravel's queuing system to send both email and SMS notifications asynchronously, ensuring the system remains efficient.
    ** Add proper error handling for failed SMS deliveries, logging them if necessary.
    ```
