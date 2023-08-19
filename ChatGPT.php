<!-- Simple ChatGPT Class that enables both text and image prompt
to use this class in another file just import it and call one of the 2 functions createTextRequest() or generateImage() with your prompt (or options)

Code Example:

include_once('ChatGPT.php'); // include class from folder
$ai = new ChatGPT(); // initialize class object
echo $ai->generateImage('a cat on a post lamp')['data'] ?? 'ERROR!'; // print the image URL or error text
echo $ai->createTextRequest('what is the weather in Romania?')['data'] ?? 'ERROR!'; // print the text response or error text -->


<?php
class ChatGPT
{
    private $API_KEY = "ADD_YOUR_API_KEY_HERE";
    private $textURL = "https://api.openai.com/v1/completions";
    private $imageURL = "https://api.openai.com/v1/images/generations";

    public $curl;

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

    /**
     * Generates a text response based on the given prompt using the specified parameters.
     *
     * @param string $prompt The prompt for generating the text response.
     * @param string $model The GPT-3 model to use for text generation.
     * @param float $temperature The temperature parameter for controlling randomness (default: 0.7).
     * @param int $maxTokens The maximum number of tokens in the generated text (default: 1000).
     * @return array An array containing 'data' and 'error' keys, representing the generated text and any errors.
     */
    public function createTextRequest($prompt, $model = 'text-davinci-003', $temperature = 0.7, $maxTokens = 1000)
    {
        curl_reset($this->curl);
        $this->initialize('text');

        $data["model"] = $model;
        $data["prompt"] = $prompt;
        $data["temperature"] = $temperature;
        $data["max_tokens"] = $maxTokens;

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($this->curl);
        $response = json_decode($response, true);

        $output['data'] = $response['choices'][0]['text'] ?? null;
        $output['error'] = $response['error']['code'] ?? null;
        return $output;
    }

    /**
     * Generates an image URL based on the given prompt and parameters.
     *
     * @param string $prompt The prompt for generating the image URL.
     * @param string $imageSize The desired image size (default: '512x512').
     * @param int $numberOfImages The number of images to generate (default: 1).
     * @return array An array containing ['data'] and ['error'] keys, representing the generated image URL and any errors.
     */
    public function generateImage($prompt, $imageSize = '512x512', $numberOfImages = 1)
    {
        curl_reset($this->curl);
        $this->initialize('image');

        $data["prompt"] = $prompt;
        $data["n"] = $numberOfImages;
        $data["size"] = $imageSize;

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($this->curl);
        $response = json_decode($response, true);

        $output['data'] = $response['data'][0]['url'] ?? null;
        $output['error'] =  $response['error']['code'] ?? null;
        return $output;
    }
}
