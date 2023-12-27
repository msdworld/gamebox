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

    // Read existing JSON file using cURL
    $jsonFileUrl = 'https://raw.githubusercontent.com/msdworld/gamebox/main/CarData.json';
    $ch = curl_init($jsonFileUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $jsonContent = curl_exec($ch);
    curl_close($ch);

    // Decode existing JSON content
    $currentData = json_decode($jsonContent, true);

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

        // Write updated data back to the JSON file using cURL
        $ch = curl_init('/CarData.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($currentData, JSON_PRETTY_PRINT));
        $result = curl_exec($ch);
        curl_close($ch);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Model already exists for the brand']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
