<?php

$curl = curl_init();    // create cURL session

$API_KEY = "ADD_YOUR_API_KEY_HERE"; // login to https://beta.openai.com/account/api-keys and create an API KEY

$url = "https://api.openai.com/v1/completions";
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);

$headers = array( // cUrl headers (-H)
    "Content-Type: application/json",
    "Authorization: Bearer $API_KEY"
);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = array( // cUrl data
    "model" => "text-davinci-003", // choose your designated model
    "prompt" => "What's the weather in Vienna today? only metrics", // choose your prompt (what you ask the AI)
    "temperature" => 0.5,   // temperature = creativity (higher value => greater creativity in your promts)
    "max_tokens" => 100     // max amount of tokens to use per request
);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($curl);               // execute cURL
$response = json_decode($response, true);   // extract json from response

$generated_text = $response['choices'][0]['text'];  // extract first response from json

echo $generated_text;   // output response

curl_close($curl);      // close cURL session
