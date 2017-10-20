<?php
namespace Avido\BillinkApiClient\Request;

/**
    @File: BaseRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Copernica Rest Api Client
    @copyright   Avido
*/
class BaseRequest
{
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
