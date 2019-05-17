<?php
/**
 * Copyright 2019 Matiullah <mati_ullah31@yahoo.com>
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */
namespace Royalmail;

use Royalmail\Authentication\Token;
use Royalmail\Exceptions\RoyalmailException;

/**
 * Class Royalmail
 *
 * @package Royalmail
 */
class Royalmail
{
    /**
     * @const string Version number of the Royalmail PHP SDK.
     */
    const VERSION = '1.0.0';
   /**
     * @var RoyalmailClient The Royalmail client service.
     */
    protected $client;
    /**
     * @var Token|null The default access token to use with requests.
     */
    protected $defaultToken;

 	/**
     * @var RoyalmailResponse|null Stores the last request made to api.
     */
    protected $lastResponse;

    /**
     * Instantiates a new Royalmail super-class object.
     *
     * @param array $config
     *
     * @throws RoyalmailException
     */
    public function __construct(array $config = [])
    {
        $config = array_merge([], $config);

         $this->client = new RoyalmailClient();
    }


     /**
     * Returns the RoyalmailClient service.
     *
     * @return RoyalmailClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns the last response returned from Graph.
     *
     * @return RoyalmailResponse|null
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }


    /**
     * Returns the default Token entity.
     *
     * @return Token|null
     */
    public function getDefaultToken()
    {
        return $this->defaultToken;
    }

    /**
     * Sets the default access token to use with requests.
     *
     * @param Token|string $token The access token to save.
     *
     * @throws \InvalidArgumentException
     */
    public function setDefaultToken($token)
    {
        if (is_string($token)) {
            $this->defaultToken = new Token($token);

            return;
        }

        if ($token instanceof Token) {
            $this->defaultToken = $token;

            return;
        }

        throw new \InvalidArgumentException('The default access token must be of type "string" or Royalmail\Token');
    }

   

    public function sendRequest($method, $endpoint, array $params = [], $token = null)
    {
        $token = $token ?: $this->defaultToken;
        $request = $this->request($method, $endpoint, $params, $token);

        return $this->lastResponse = $this->client->sendRequest($request);
    }

   
}
