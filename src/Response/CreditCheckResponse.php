<?php
namespace Avido\BillinkApiClient\Response;

/**
    @File: CreditCheckResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/

class CreditCheckResponse extends BaseResponse
{
    protected  $uuid;
    
    public function __construct($xml = null)
    {
        if ($xml instanceof \SimpleXMLElement) {
            $this->setCode((string)$xml->MSG->CODE);
            $this->setDescription ((string)$xml->MSG->DESCRIPTION);
            $this->setUuId((string)$xml->UUID);
        }
    }
    
    /**
     * UUID
     * 
     * @access public
     * @param string $uuid
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }
    
    /**
     * UUID
     * 
     * @access public
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
