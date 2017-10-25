<?php
namespace Avido\BillinkApiClient;

use SimpleXMLElement;
use DOMDocument;

/**
    @File: BaseModel.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class BaseModel
{
    /**
     * API Username
     * @var string
     */
    private $username = null;
    /**
     *API Client ID
     * @var string
     */
    private $client_id = null;
    /**
     *API Version
     * @var string
     */
    private $version = null;
    
    /**
     * Set API username
     * 
     * @access public
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    /**
     * Set API Client ID
     * 
     * @access public
     * @param string $client_id
     * @return $this
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }
    
    /**
     * Set API Version
     * 
     * @access public
     * @param type $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    
    /**
     * Get API Username
     * 
     * @access public
     * @return string
     */
    protected function getUsername()
    {
        return (string)$this->username;
    }
    
    /**
     * Get API Client ID
     * 
     * @access public
     * @return string
     */
    protected function getClientId()
    {
        return (string)$this->client_id;
    }
    
    /**
     * Get API Version
     * 
     * @access public
     * @return string
     */
    protected function getVersion()
    {
        return (string)$this->version;
    }
    
    /**
     * Set/Get attribute wrapper
     *
     * @param   string $method
     * @param   array $args
     * @return  mixed
     */
    public function __call($method, $args)
    {
        switch (substr($method, 0, 3)) {
            case 'get' :
                $key = strtolower(substr($method,3));
                return $this->getData($key, isset($args[0]) ? $args[0] : null);
                break;
//            case 'set' :
//                $result = $this->setData($key, isset($args[0]) ? $args[0] : null);
//                //Varien_Profiler::stop('SETTER: '.get_class($this).'::'.$method);
//                return $result;
//
//            case 'uns' :
//                //Varien_Profiler::start('UNS: '.get_class($this).'::'.$method);
//                $key = $this->_underscore(substr($method,3));
//                $result = $this->unsetData($key);
//                //Varien_Profiler::stop('UNS: '.get_class($this).'::'.$method);
//                return $result;
//
//            case 'has' :
//                //Varien_Profiler::start('HAS: '.get_class($this).'::'.$method);
//                $key = $this->_underscore(substr($method,3));
//                //Varien_Profiler::stop('HAS: '.get_class($this).'::'.$method);
//                return isset($this->_data[$key]);
        }
    }
    /**
     * Get data from attribute, child entity or nested entity
     *
     * @param string $key
     * @return null|string|array
     */
    public function getData($key=null)
    {
        $data = $this->toArray();
        return isset($data[$key]) ? $data[$key] : null;
    }
    
    /**
     * Return array of protected/public properties
     * 
     * @access public
     * @return array
     */
    public function toArray()
    {
        //Instantiate the reflection object
        $oReflector = new \ReflectionClass(get_class($this));

        //Now get all the properties from class A in to $properties array
        $arrProperties = $oReflector->getProperties();
        $arrData = array();
        //Now go through the $properties array and populate each property
        foreach ($arrProperties as $oProperty) {
            $sProperty = $oProperty->getName();
            $arrData[$sProperty] = $this->{$sProperty};
        }
        
        return $arrData;
    }
    
    /**
     * Output Request as Xml
     * 
     * @access public
     * @return string (xml)
     */
    public function toXml()
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $api = $document->createElement('API');
            $api->appendChild($document->createElement('VERSION', $this->getVersion()));
            $api->appendChild($document->createElement('CLIENTUSERNAME', $this->getUsername()));
            $api->appendChild($document->createElement('CLIENTID', $this->getClientId()));
            foreach ($this->toArray() as $key=>$val) {
                $api->appendChild($document->createElement(strtoupper($key), $val));
            }
        $document->appendChild($api);
        $document->formatOutput = true;
        return $document->saveXML();
    }
}