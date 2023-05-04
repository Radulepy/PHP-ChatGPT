<?php
// Simple ChatGPT Class that enables both text and image prompt
// to use this class in another file just import it and call one of the 2 functions createTextRequest() or generateImage() with your prompt (or options)
//
// Example:
// 
// include_once('ChatGPT.php'); // include class from folder
// $ai = new ChatGPT();         // initialize class object
// echo $ai->generateImage('a cat on a post lamp');               // print the image URL
// echo $ai->createTextRequest('what is the weather in Romania?') // print the text response
// // https://github.com/Radulepy/PHP-ChatGPT

class ChatGPT
{

    private $API_KEY = "enter_API_KEY_here";
    private $textURL = "https://api.openai.com/v1/completions";
    private $imageURL =  "https://api.openai.com/v1/images/generations";

    public $curl;       // create cURL object
    public $data = [];  // data request array

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function initialize($requestType = "text" || "image")
    {
        $this->curl = curl_init();

        if ($requestType === 'image')
            curl_setopt($this->curl, CURLOPT_URL, $this->imageURL);
        if ($requestType === 'text')
            curl_setopt($this->curl, CURLOPT_URL, $this->textURL);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POST, true);

        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $this->API_KEY"
        );

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    }

    // returns text
    public function createTextRequest($prompt, $model = 'text-davinci-003', $temperature = 0.5, $maxTokens = 1000)
    {
        curl_reset($this->curl);
        $this->initialize('text');

        $this->data["model"] = $model;
        $this->data["prompt"] = $prompt;
        $this->data["temperature"] = $temperature;
        $this->data["max_tokens"] = $maxTokens;

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->data));

        $response = curl_exec($this->curl);
        $response = json_decode($response, true);
		$this->data = array();
        return $response['choices'][0]['text'] ?? -1; // return text or -1 if error
    }

    // returns URL with the image
    public function generateImage($prompt, $imageSize = '512x512', $numberOfImages = 1)
    {
        curl_reset($this->curl);
        $this->initialize('image');

        $this->data["prompt"] = $prompt;
        $this->data["n"] = $numberOfImages;
        $this->data["size"] = $imageSize;

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->data));

        $response = curl_exec($this->curl);
        $response = json_decode($response, true);
		$this->data = array();
        return $response['data'][0]['url'] ?? -1; //return the first url or -1 if error
    }
}
