# Weather Data Emailer

## Project Overview
The Weather Data Emailer is a web application that retrieves weather data from the Weather.com API, displays the weather summary on the webpage, and sends a weather report via email using PHP. The email content is generated using the Gemini API to provide a professional and informative tone.

## Features
- Fetch current weather data for a specified location from Weather.com API.
- Compose a professional email with the weather summary using the Gemini API.
- Send the generated email to the specified recipient.
- Simple user interface built with HTML, CSS, and Bootstrap.

## Getting Started

### Prerequisites
- PHP 7.4 or higher
- Composer
- Access to Weather.com API for weather data
- Access to Gemini API for generating email content
- A web server (like Apache or Nginx)

### Installation

1. **Clone the Repository**
    git clone https://github.com/AdityaNarayan1203/weather_emailer.git
    cd weather_emailer
2. **Update the openai api**
    Go to send-emails.php and update the api key which I have provided to you over mail at line 18 or you can use your own api key
3. **Install Dependencies**
   composer install
