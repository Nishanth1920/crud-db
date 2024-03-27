<?php
require_once 'facebook/autoload.php'; // Include the Facebook PHP SDK

$fb = new Facebook\Facebook([
  'app_id' => '1139736640360187',
  'app_secret' => 'f0e870b2a16111b3dcf75d0ff11fc624',
  'default_graph_version' => 'v19.0',
]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
    $response = $fb->get('/me?fields=id,name,email', $accessToken);
    $userData = $response->getGraphNode()->asArray();

    // Process $userData to register the user in your system
    // You may store user's Facebook ID, name, email, etc. in your database

    // Redirect the user to the registration success page
    header("Location: read.php");
    exit();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
?>