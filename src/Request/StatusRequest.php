<?php
namespace Avido\BillinkApiClient\Request;


use Avido\BillinkApiClient\Entities\Invoice;


/**
    @File: StatusRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/
class StatusRequest extends BaseRequest
{
    protected $invoices = [];

    public function __construct()
    {
        parent::__construct('Status');
    }
    
    /**
     * Set invoices
     * 
     * @access public
     * @param array $invoices
     * @return $this
     */
    public function setInvoices($invoices = [])
    {
        foreach ($invoices as $item) {
            if (!$item instanceof Invoice) {
                $item = new Invoice($item);
            }
            $this->addInvoice($item);
        }
        return $this;
    }

    /**
     * Add invoice
     * 
     * @param Invoice $invoice
     * @return $this
     */
    public function addInvoice(Invoice $invoice)
    {
        $this->invoices[] = $invoice;
        return $this;
    }
    
    public function toXml()
    {
        $document = $this->prepXmlRequest();
        // append invoices
        $invoices = $document->addChild('INVOICES');
        foreach ($this->invoices as $invoice) {
            $childItem = $invoices->addChild('ITEM');
            foreach ($invoice->toArray(['workflownumber', 'invoicenumber']) as $childKey => $childVal) {
                $childItem->addChild(strtoupper($childKey), $childVal);
            }
        }
        return $document->asXml();
    }
}
