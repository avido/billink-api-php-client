<?php
namespace Avido\BillinkApiClient\Request;

use SimpleXMLElement;
use Avido\BillinkApiClient\BaseModel;
/**
    @File: BaseRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class BaseRequest extends BaseModel
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
     *API Action
     * @var string 
     */
    protected $action = null;
    
    public function __construct($action=null)
    {
        if (!is_null($action)) {
            $this->setAction($action);
        }
    }
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
     * SET API Action
     * 
     * @access public
     * @param string$action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
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
     * Get API Action
     * 
     * @access public
     * @return string
     */
    public function getAction()
    {
        return (string)$this->action;
    }
    
    /**
     * Output Request as Xml
     * 
     * @access public
     * @return string (xml)
     */
    public function toXml()
    {
        $document = $this->prepXmlRequest();
        foreach ($this->toArray() as $key=>$val) {
            $document->addChild(strtoupper($key), $val);
        }
        #die($document->asXml());
        return $document->asXml();
    }
    
    /**
     * Prep XML Request 
     * 
     * @access protected
     * @return SimpleXMLElement
     */
    protected function prepXmlRequest()
    {
        $document = new SimpleXMLElement('<API></API>');
            $document->addChild('VERSION', $this->getVersion());
            $document->addChild('CLIENTUSERNAME', $this->getUsername());
            $document->addChild('CLIENTID', $this->getClientId());
            $document->addChild('ACTION', $this->getAction());
        
        return $document;
    }
}
