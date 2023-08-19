# PHP-ChatGPT (OpenAI) connection
The `index.php` is a simple .php file to connect to OpenAi's API and prompt a text request using `cUrl()`. <br>
OPTIONAL: You can use the `ChatGPT.php` class to create both **image** and **text** request with the help of OpenAi's API. More details in comments. <br>

*This is the simplest and beginner-friendly method to connect to ChatGPT API without any need of library*

## API_KEY:
Generate an API KEY from https://beta.openai.com/account/api-keys and paste into the code.


## Optional Parameters
Modify the prompt to fit your own needs.
You can add optional parameters to the class object function calls: 
* `createTextRequest("What's the best job?", 'text-davinci-003', 0.9, 300) // prompt, model, temperature, max_tokens`
* `generateImage("Frog on a frozen lake", '1080x1080', 2) // prompt, imageSize, numberOfImages`
