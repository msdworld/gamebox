<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $brand = $_POST['brand'];
    $modelName = $_POST['modelName'];
    $price = $_POST['price'];
    $launchDate = $_POST['launchDate'];
    $mileage = $_POST['mileage'];
    $capacity = $_POST['capacity'];
    $fuelType = $_POST['fuelType'];
    $wheelType = $_POST['wheelType'];
    $postLink = $_POST['postLink'];

    // Read existing JSON file
    $jsonFile = 'https://github.com/msdworld/gamebox/raw/main/CarData.json';
    $currentData = json_decode(file_get_contents($jsonFile), true);

    // Add new data
    if (!isset($currentData[$brand]['models'][$modelName])) {
        $currentData[$brand]['models'][$modelName] = [
            'price' => $price,
            'launchDate' => $launchDate,
            'mileage' => $mileage,
            'capacity' => $capacity,
            'fuelType' => $fuelType,
            'wheelType' => $wheelType,
            'postLink' => $postLink
        ];

        // Write updated data back to the JSON file
        file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT));

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Model already exists for the brand']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
