<?php
namespace Avido\BillinkApiClient;

/**
    @File:  BillinkClient.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido

    Billink Client for interacting with the Billink API
    https://test.billink.nl/api/docs | https://www.billink.nl
*/

use Avido\BillinkApiClient\Exceptions\BillinkClientException;

// entities
//use Avido\CopernicaRestClient\Entities\Database;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\MessageFormatter;
use Monolog\Logger;
use Monolog\Handler\NullHandler;

class BillinkClient
{
    const VERSION = 'BILLINK2.0';
    
    /**
     * Namespace for loading entities
     */
    const _NAMESPACE = "Avido\\BillinkApiClient\\Request\\";
    /**
     * API Address
     */
    const API_ADDRESS_LIVE = 'https://client.billink.nl/api';
    const API_ADDRESS_TEST = 'https://test.billink.nl/api';

    /**
     * Expected http response code
     * @var int
     */
    private $expectedStatusCode = 200;
    
    /**
     *API Username
     * @var string
     * 
     */
    private $username = null;
    
    /**
     * Client ID / ApiKey
     * @var string
     */
    private $client_id = null;

    /**
     * Indicates test mode
     * @var bool
     */
    private $testMode = null;
    
    /**
     * Log 
     * @var Monolog\Logger
     */
    private $logger = null;

    private $logMessageFormat = "[{method}] - {uri} *|* <<REQUEST>> {req_body} *|* <<RESPONSE>> {res_body}";
    
    public function __construct($username, $client_id, $logger=null)
    {
        $this->username = $username;
        $this->client_id = $client_id;
        $this->setLogger($logger);
        date_default_timezone_set('europe/amsterdam');
    }
    
    /**
     * Enable or disable testmode (default disabled)
     * @param $mode boolean
     */
    public function setTestMode($mode)
    {
        $this->testMode = (bool)$mode;
    }

    
    /**
     * Set logger
     * 
     * @param Monolog\Handler $handler
     * @return $this
     */
    public function setLogger($handler)
    {
        if (!is_null($handler)) {
            $this->logger = new Logger('BillinkApiClient'); //initialize the logger
            $this->logger->pushHandler($handler);
        }
        
        return $this;
    }
    
    /**
     * Get Logger
     * @return Monolog\Logger
     */
    public function getLogger()
    {
        if (is_null($this->logger)) {
            // return dummy
            $this->logger = new Logger('BillinkApiClient');
            $this->logger->pushHandler(new NullHandler);
        }
        return $this->logger;
    }
    public function hasLogger()
    {
        return !is_null($this->logger) ? true : false;
    }
    
    /**
     * Set expected http status code
     *
     * @access public
     * @param int $code
     * @return $this
     */
    public function setExpectedStatusCode($code = 200)
    {
        $this->expectedStatusCode = (int)$code;
        return $this;
    }
    
    /**
     * Retrieve entity
     * @param string $entity
     * @param type $data
     * @return \Avido\CopernicaRestClient\entity
     * @throws Exceptions\CopernicaRestClientMissingEntityException
     */
    public function getEntity($entity, $data = null)
    {
        $entity = self::_NAMESPACE  . $entity;
        if (!class_exists($entity)) {
            throw new Exceptions\CopernicaRestClientMissingEntityException("No such entity '{$entity}'");
        }
        return new $entity($data);
    }
    
    /***********************************
     * Credit Check API
     ***********************************/
    /**
     * Get Copernica Identity
     *
     * @see https://www-dev.copernica.com/nl/documentation/rest-get-identity
     * @return array
     */
    public function check(Request\CreditCheckRequest $check)
    {
        // get data
        $data = $check->toArray();
        $document = new \SimpleXMLElement('<API></API>');
        $document->addChild('VERSION', self::VERSION);
        $document->addChild('CLIENTUSERNAME', $this->username);
        $document->addChild('CLIENTID', $this->client_id);
        // append data from request.
        foreach ($data as $key=>$val) {
            $document->addChild(strtoupper($key), $val);
        }
        $xml = $this->post('check', $document->asXML());
        return new Response\CreditCheckResponse($xml);
    }
    
    
    
    /**
     * Get request
     *
     * @param string $endpoint
     * @param array $parameters
     * @param boolean $rawReturn (true, skip json decode)
     * @return array
     */
    public function get($endpoint = '', array $parameters = [], $rawReturn = false)
    {
        if ($endpoint === '') {
            throw new \BadMethodCallException("Missing endpoint");
        }
        $endpoint = $this->endpoint($endpoint, $parameters);
        $res = $this->setExpectedStatusCode(200)->makeRequest('GET', $endpoint);
        $response = $res->getBody();
        return ($rawReturn) ? $response : json_decode($response, true);
    }

    /**
     * Post request
     * @param string $endpoint
     * @param string $xml
     * @return mixed Int($id) | false
     */
    public function post($endpoint = '', $xml=null)
    {
        if ($endpoint === '') {
            throw new \BadMethodCallException("Missing endpoint");
        }
        $endpoint = $this->endpoint($endpoint);
        return $this->makeRequest('POST', $endpoint, ['body' => $xml]);
    }

    /**
     * Put request
     *
     * @param string $endpoint
     * @param array $data
     * @return boolean
     */
    public function put($endpoint = '', array $data = [], $parameters = [])
    {
        if ($endpoint === '') {
            throw new \BadMethodCallException("Missing endpoint");
        }
        $endpoint = $this->endpoint($endpoint, $parameters);
        $res =  $this->setExpectedStatusCode()->makeRequest('PUT', $endpoint, ['json' => $data]);
        return $res;
    }

    /**
     * Delete request
     *
     * @param string $endpoint
     * @return boolean
     */
    public function delete($endpoint = '', $parameters = [])
    {
        if ($endpoint === '') {
            throw new \BadMethodCallException("Missing endpoint");
        }
        $endpoint = $this->endpoint($endpoint, $parameters);
        $res = $this->makeRequest('DELETE', $endpoint);
//        echo "Response:";
//        var_dump($res->getBody()->getContents());
//        exit;
        $xDeleted = $res->getHeaderLine('X-Deleted');
        if ($xDeleted !== '') {
            // extract id from X-Deleted
            $id = preg_replace('[\D]', '', $xDeleted);
        }
        // return id if present, if response code differs from 200 an exception is thrown
        return ($id > 0) ? intval($id) : true;        
    }
        
    /**
     * Make http request
     *
     * @param string $method - GET,POST,PUT,DELETE
     * @param string $endpoint
     * @param string $payload
     * @return mixed
     * @throws CopernicaRestClientBadResponseException
     * @throws \Avido\CopernicaRestClient\GuzzleHttp\Exception\ClientException
     */
    public function makeRequest($method = 'GET', $endpoint = '', $payload=null)
    {
        if ($endpoint === '') {
            throw new \BadMethodCallException("Missing endpoint");
        }
        try {
            // create stack middleware
            /**
             * Middleware currently hijacks response body..
             * Untill issue is fixed.. disabled middleware (6.3.0)
             * 
             * @see https://github.com/guzzle/guzzle/issues/1582
             */
            $stack = HandlerStack::create();
//            $stack->push(
//                Middleware::log(
//                    $this->getLogger(),
//                    new MessageFormatter($this->logMessageFormat)
//                )
//            );
            // guzzle(6.3.0) still hijacks body when adding stack handler..
            $client = new \GuzzleHttp\Client([
                'handler' => $stack
            ]);
            $res = $client->request($method, $endpoint, $payload);
            $response = $res->getBody()->getContents();
            $xml = new \SimpleXMLElement($response);
            $this->checkErrors($xml);
            return $xml;
        } catch (RequestException $e) {
            throw $e;
        } catch (ClientException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    private function checkErrors($xml)
    {
        if ($xml->ERROR) {
            $msg = (string)$xml->ERROR->DESCRIPTION;
            $code = (string)$xml->ERROR->CODE;
            if (in_array($code, ['001', '101', '102', '103', '105', '601'])) {
                throw new \RuntimeException((string)$msg, $code);
            }
            throw new BillinkClientException((string)$msg, $code);
        }
    }
    
    /**
     * Format endpoint
     *
     * @access private
     * @param string $endpoint
     * @return string
     */
    private function endpoint($endpoint, $parameters = [])
    {
        if (substr($endpoint, 0, 1) !== '/') {
            $endpoint = "/{$endpoint}";
        }
        return (($this->testMode) ? self::API_ADDRESS_TEST : self::API_ADDRESS_LIVE) . $endpoint;
    }
}
