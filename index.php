<?php
session_start();
include('header.php');
include('api.php');

$apiKey = "0d5fd8d18d51493a93f103132242810"; // Your Weather API key

// Check if the city is submitted through the form
if (isset($_POST['city']) && !empty($_POST['city'])) {
    $cityName = trim($_POST['city']);
    $_SESSION['cityName'] = $cityName;

    $url = 'https://api.weatherapi.com/v1/current.json?key=' . $apiKey . '&q=' . urlencode($cityName); // URL encode city name
    $weatherData = getWeather($url); // Fetch weather data

    // Check if the API response contains valid data
    if (isset($weatherData['error'])) {
        echo "No Data Found <a href='http://localhost/weather'>Go Back</a>";
        exit();
    }
} else {
    if (!isset($_SESSION['cityName'])) {
        $_SESSION['cityName'] = "Delhi";
    }
    $cityName = "Delhi";
    $url = 'https://api.weatherapi.com/v1/current.json?key=' . $apiKey . '&q=' . urlencode($cityName);
    $weatherData = getWeather($url);
}


?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-7 boxbg m-auto mt-2">
                <form action="#" method="post">
                    <div class="formdin d-flex justify-content-center">
                        <div class="p-2">
                            <input type="text" class="form-control" name="city" placeholder="Enter city name" required>
                        </div>
                        <div class="p-2">
                            <input type="submit" class="form-control btn btn-success" value="Search" />
                        </div>
                    </div>
                </form>
                <h1 class="text-center"><?= htmlspecialchars($weatherData['location']['name']) ?></h1>
                <div class="d-flex justify-content-center">
                    <div class="p-2 mt-3">
                        <h1 class="tempText"><?= htmlspecialchars($weatherData['current']['temp_c']) ?> °C</h1>
                    </div>
                    <div class="p-2">
                        <div class="weatherIcon">
                            <img src="<?= htmlspecialchars($weatherData['current']['condition']['icon']) ?>" class="img-fluid" alt="">
                            <span><?= htmlspecialchars($weatherData['current']['condition']['text']) ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-row">
                            <div class="p-2">Wind Speed -</div>
                            <div class="p-2"><b><?= htmlspecialchars($weatherData['current']['wind_mph']) ?> MPH</b></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="p-2">
                                <h3><b><?= date("d-M", strtotime($weatherData['current']['last_updated'])) ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <!-- Button trigger modal -->
                    <div class="p-2">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Send Weather Report
                        </button>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="send-email.php" method="post">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Get weather report over mail</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="email" class="form-control" name="mail" placeholder="Enter your email id" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include('footer.php'); ?>