<?php
namespace Avido\BillinkApiClient\Response;

/**
    @File: CreditCheckResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
//extends BaseResponse
class CreditCheckResponse extends BaseResponse
{
    protected  $code;
    protected  $description;
    protected  $uuid;
    
    public function __construct($xml = null)
    {
        if ($xml instanceof \SimpleXMLElement) {
            $this->setCode((string)$xml->MSG->CODE);
            $this->setDescription ((string)$xml->MSG->DESCRIPTION);
            $this->setUuId((string)$xml->UUID);
        }
    }
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }
    
}
