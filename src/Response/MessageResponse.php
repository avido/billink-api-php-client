<?php
namespace Avido\BillinkApiClient\Response;

/**
    @File: MessageResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class MessageResponse extends BaseResponse
{
    public function __construct($xml = null)
    {
        if ($xml instanceof \SimpleXMLElement) {
            $this->setCode((string)$xml->MSG->CODE);
            $this->setDescription((string)$xml->MSG->DESCRIPTION);
        }
    }
}
