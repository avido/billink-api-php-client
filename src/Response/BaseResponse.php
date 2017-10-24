<?php
namespace Avido\BillinkApiClient\Response;

use Avido\BillinkApiClient\BaseModel;
/**
    @File: BaseResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class BaseResponse extends BaseModel
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
}
