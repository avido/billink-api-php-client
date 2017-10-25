<?php
namespace Avido\BillinkApiClient\Response;

use Avido\BillinkApiClient\Entities\Invoice;
/**
    @File: CreditResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class CreditResponse extends BaseResponse
{
    protected $invoices = [];
    
    public function __construct($xml = null)
    {
        if ($xml instanceof \SimpleXMLElement) {
            $this->setInvoices($xml->MSG->STATUSES);
        }
    }
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    public function setInvoices($invoices)
    {
        $tmp = [];
        foreach ($invoices->ITEM as $invoice) {
            $tmp[] = new Invoice([
                'invoicenumber' => (string)$invoice->INVOICENUMBER,
                'code' => (string)$invoice->CODE,
                'message' => (string)$invoice->MESSAGE
            ]);
        }
        $this->invoices = $tmp;
        return $this;
    }
}
