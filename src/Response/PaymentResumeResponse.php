<?php
namespace Avido\BillinkApiClient\Response;

/**
    @File: PaymentResumeResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class PaymentResumeResponse extends BaseResponse
{
    protected  $code;
    protected  $description;
    
    public function __construct($xml = null)
    {
        if ($xml instanceof \SimpleXMLElement) {
            $this->setCode((string)$xml->MSG->CODE);
            $this->setDescription ((string)$xml->MSG->DESCRIPTION);
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
}