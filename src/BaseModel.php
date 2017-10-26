<?php
namespace Avido\BillinkApiClient;
/**
    @File: BaseModel.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/

use SimpleXMLElement;

class BaseModel
{
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
        $data = self::toArray();
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
}
