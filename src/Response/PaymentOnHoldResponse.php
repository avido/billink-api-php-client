<?php
namespace Avido\BillinkApiClient\Response;

/**
    @File: PaymentOnHoldResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class PaymentOnHoldResponse extends BaseResponse
{
    protected  $uuid;
    
    public function __construct($xml = null)
    {
        if ($xml instanceof \SimpleXMLElement) {
            $this->setCode((string)$xml->MSG->CODE);
            $this->setDescription ((string)$xml->MSG->DESCRIPTION);
        }
    }
}
