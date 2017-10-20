<?php
/**
    @File:  BillinkClient.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido

    Billink Client for interacting with the Billink API
    https://test.billink.nl/api/docs | https://www.billink.nl
*/
namespace Avido\BillinkApiClient;

//use Avido\CopernicaRestClient\Exceptions\CopernicaRestClientException;
//use Avido\CopernicaRestClient\Exceptions\CopernicaRestClientBadResponseException;

// entities
//use Avido\CopernicaRestClient\Entities\Database;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
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
    const API_ADDRESS = 'https://client.billink.nl/api';

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
    public function check(Request\CreditCheck $check)
    {
        // get data
        $data = $check->toArray();
        $document = new \SimpleXMLElement('<API></API>');
        $document->addChild('VERSION', self::VERSION)
            ->addChild('CLIENTUSERNAME', $this->username)
            ->addChild('CLIENTID', $this->client_id);
        // append data from request.
        foreach ($data as $key=>$val) {
            $document->addChild(strtoupper($key), $val);
        }
        echo $document->asXml();
        exit;
        return $this->get('identity');
    }
    
    /**
     * Create Profile
     * 
     * @see https://www.copernica.com/nl/documentation/rest-php
     * @param Entities\Database\Profile $profile
     * @return Entities\Database\Profile
     * @throws CopernicaRestClientBadResponseException
     */
    public function createProfile(Entities\Database\Profile $profile)
    {
        // extract fields.
        $fields = $profile->fieldsToArray();
        $id = $this->post("database/{$profile->getDatabase()}/profiles/fields", $fields);
        if (intval($id) > 0) {
            $profile->setId($id);
            return $profile;
        }
        throw new CopernicaRestClientBadResponseException("No ID received from Copernica");
    }
    
    /**
     * Update profile
     * 
     * @see https://www.copernica.com/nl/documentation/rest-put-profile
     * @param Entities\Database\Profile $profile
     * @return Entities\Database\Profile $profile
     * @throws \BadMethodCallException
     * @throws CopernicaRestClientBadResponseException
     */
    public function updateProfile(Entities\Database\Profile $profile)
    {
        if (!$profile->hasId()) {
            throw new \BadMethodCallException("Missing Id");
        }
        // save it
        $result = $this->put("profile/{$profile->getId()}", $profile->toArray());
        $response = $result->getBody()->getContents();
        $json = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $profile->setData($json);
        }
        throw new CopernicaRestClientBadResponseException("Response not in json format");
    }
    
    /**
     * Update profile fields
     * 
     * @see https://www.copernica.com/nl/documentation/rest-put-profile-fields
     * @param Entities\Database\Profile $profile
     * @return Entities\Database\Profile $profile
     * @throws \BadMethodCallException
     * @throws CopernicaRestClientBadResponseException
     */
    public function updateProfileFields(Entities\Database\Profile $profile)
    {
        if (!$profile->hasId()) {
            throw new \BadMethodCallException("Missing Id");
        }
        // extract fields.
        $fields = $profile->fieldsToArray();
        // save it
        $result = $this->put("profile/{$profile->getId()}/fields", $fields);
        $response = $result->getBody()->getContents();
        $json = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $profile->setData($json);
        }
        throw new CopernicaRestClientBadResponseException("Response not in json format");
    }
    
    /**
     * Update profile interests
     * 
     * @see https://www.copernica.com/nl/documentation/rest-post-profile-interests
     * @param Entities\Database\Profile $profile
     * @return boolean
     */
    public function updateProfileInterests(Entities\Database\Profile $profile)
    {
        if (!$profile->hasId()) {
            throw new \BadMethodCallException("Missing Id");
        }
        // extract interests.
        $interests = $profile->interestsToArray();
        // save it
        return $this->post("profile/{$profile->getId()}/interests", $interests);
    }
    
    /**
     * Overwrite profile interests
     * 
     * @see https://www.copernica.com/nl/documentation/rest-put-profile-interests
     * @param Entities\Database\Profile $profile
     * @return boolean
     */
    public function overwriteProfileInterests(Entities\Database\Profile $profile)
    {
        if (!$profile->hasId()) {
            throw new \BadMethodCallException("Missing Id");
        }
        // extract interests.
        $interests = $profile->interestsToArray();
        // save it
        $result = $this->put("profile/{$profile->getId()}/interests", $interests);
        $response = $result->getBody()->getContents();
        $json = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $profile->setData($json);
        }
        throw new CopernicaRestClientBadResponseException("Response not in json format");
    }
    
    public function createProfileSubprofile(Entities\Database\Subprofile $profile)
    {
        if (!$profile->hasProfileId()) {
            throw new \BadMethodCallException("Missing Profile ID");
        }
        if (!$profile->hasCollectionId()) {
            throw new \BadMethodCallException("Missing Collection ID");
        }
        // extract fields.
        $fields = $profile->fieldsToArray();
        // save it
        $id = $this->post("profile/{$profile->getProfileId()}/subprofiles/{$profile->getCollectionId()}", $fields);
        if (intval($id) > 0) {
            $profile->setId($id);
            return $profile;
        }
        throw new CopernicaRestClientBadResponseException("Response not in json format");
    }
    
    
    
    /***********************************
     * API DELETE Calls
     ***********************************/
    /**
     * Delete subprofile
     * 
     * @see https://www.copernica.com/nl/documentation/rest-delete-subprofile
     * @param \Avido\CopernicaRestClient\Entities\Database\Subprofile $profile
     * @return boolean
     * @throws \BadMethodCallException
     * @throws CopernicaRestClientBadResponseException
     */
    public function deleteProfileSubprofile(Entities\Database\Subprofile $profile)
    {
        if (!$profile->hasId()) {
            throw new \BadMethodCallException("Missing ID");
        }
        $id = $this->delete("subprofile/{$profile->getId()}");
        return ($id > 0) ? true : false; 
        throw new CopernicaRestClientBadResponseException("Response not in json format");
    }
    
    /**
     * Delete profile
     * 
     * @see https://www.copernica.com/nl/documentation/rest-delete-profile
     * @param \Avido\CopernicaRestClient\Entities\Database\Profile $profile
     * @return boolean
     * @throws \BadMethodCallException
     * @throws CopernicaRestClientBadResponseException
     */
    public function deleteProfile(Entities\Database\Profile $profile)
    {
        if (!$profile->hasId()) {
            throw new \BadMethodCallException("Missing ID");
        }
        $id = $this->delete("profile/{$profile->getId()}");
        return ($id > 0) ? true : false; 
        throw new CopernicaRestClientBadResponseException("Response not in json format");
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
     * @param array $data
     * @return mixed Int($id) | false
     */
    public function post($endpoint = '', array $data = [], $parameters = [])
    {
        if ($endpoint === '') {
            throw new \BadMethodCallException("Missing endpoint");
        }
        $endpoint = $this->endpoint($endpoint, $parameters);
        $res =  $this->setExpectedStatusCode(201)->makeRequest('POST', $endpoint, ['json' => $data]);
        // get header
        $id = (int)$res->getHeaderLine('X-Created');
        // return id if present, if response code differs from 201 an exception is thrown
        return ($id > 0) ? $id : true;
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
     * @param array $payload
     * @return mixed
     * @throws CopernicaRestClientBadResponseException
     * @throws \Avido\CopernicaRestClient\GuzzleHttp\Exception\ClientException
     */
    public function makeRequest($method = 'GET', $endpoint = '', $payload = [])
    {
        if ($endpoint === '') {
            throw new \BadMethodCallException("Missing endpoint");
        }
        try {
            // create stack middleware
            /**
             * Middleware currently hijacks response body..
             * Untill issue is fixed.. disabled middleware
             * 
             * @see https://github.com/guzzle/guzzle/issues/1582
             */
            $stack = HandlerStack::create();
            if ($this->hasLogger()) {
                $stack->push(
                    Middleware::log(
                        $this->getLogger(),
                        new MessageFormatter($this->logMessageFormat)
                    )
                );
            }
            $client = new \GuzzleHttp\Client([
                'handler' => $stack
            ]);

            $res = $client->request($method, $endpoint, $payload);
            if ($res->getStatusCode() === $this->expectedStatusCode) {
                return $res;
            } else {
                $response = $res->getBody();
                if ($response != '') {
                    // json response?
                    $json = json_decode($response, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        throw new CopernicaRestClientBadResponseException($json->error->message, $e->getCode());
                    }
                }
                throw new CopernicaRestClientBadResponseException(
                    "Invalid http response, expected: {$this->expectedStatusCode}, received: {$res->getStatusCode()}"
                );
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $json = json_decode($e->getResponse()->getBody()->getContents());
            if (json_last_error() === JSON_ERROR_NONE) {
                throw new CopernicaRestClientBadResponseException($json->error->message, $e->getCode());
            }
            throw $e;
        } catch (\Exception $e) {
            throw $e;
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
        $endpoint = self::API_ADDRESS . $endpoint;
        $query = http_build_query(['access_token' => $this->token] + $parameters);
        return "{$endpoint}?{$query}";
    }
    
    /**
     * Format paging
     * 
     * @see https://www.copernica.com/nl/documentation/rest-paging
     * @param int $start
     * @param int $limit
     * @param boolean $total
     * @return array
     */
    private function paging($start = 0, $limit = 0, $total = false, $orderBy = null, $orderDir = null, $fields = [])
    {
        $paging = [];
        if ((int)$start > 0) {
            $paging['start'] = (int)$start;
        }
        if ((int)$limit > 0) {
            $paging['limit'] = (int)$limit;
        }
        $paging['total']= (bool)$total;
        if (count($fields) > 0) {
            $paging['fields'] = $fields;
        }
        if (!is_null($orderBy)) {
            $paging['orderby'] = $orderBy;
        }
        if (in_array(strtolower($orderDir), ['asc', 'desc'])) {
            $paging['order'] = $orderDir;
        }
        
        return $paging;
    }
}
