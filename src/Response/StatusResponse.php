<?php
namespace Avido\BillinkApiClient\Response;
use Avido\BillinkApiClient\Entities\Invoice;

/**
    @File: StatusResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class StatusResponse extends BaseResponse
{
    protected $invoices = [];
    
    public function __construct($xml = null)
    {
        if ($xml instanceof \SimpleXMLElement) {
            $this->setCode((string)$xml->MSG->CODE);
            $this->setInvoices($xml->MSG->INVOICES);
        }
    }
    
    /**
     * Invoices
     * 
     * @access public
     * @param object $invoices
     * @return $this
     */
    public function setInvoices($invoices)
    {
        $tmp = [];
        foreach ($invoices->INVOICE as $invoice) {
            $tmp[] = new Invoice([
                'invoicenumber' => (string)$invoice->INVOICENUMBER,
                'status' => (string)$invoice->STATUS,
                'description' => (string)$invoice->DESCRIPTION
            ]);
        }
        $this->invoices = $tmp;
        return $this;
    }
}
