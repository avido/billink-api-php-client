<?php
namespace Avido\BillinkApiClient\Request;


use DOMDocument;

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
        $this->setAction('status');
    }
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

    public function addInvoice(Invoice $invoice)
    {
        $this->invoices[] = $invoice;
        return $this;
    }
    
    public function toXml()
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $api = $document->createElement('API');
            $api->appendChild($document->createElement('VERSION', $this->getVersion()));
            $api->appendChild($document->createElement('CLIENTUSERNAME', $this->getUsername()));
            $api->appendChild($document->createElement('CLIENTID', $this->getClientId()));
            $api->appendChild($document->createElement('ACTION', $this->getAction()));
            // append invoices
            $invoices = $document->createElement('INVOICES');
            foreach ($this->invoices as $invoice) {
                $childItem = $document->createElement('ITEM');
                foreach ($invoice->toArray() as $childKey => $childVal) {
                    $childItem->appendChild($document->createElement(strtoupper($childKey), $childVal));
                }
                $invoices->appendChild($childItem);
            }
            $api->appendChild($invoices);
    
        $document->appendChild($api);
        $document->formatOutput = true;
        return $document->saveXml();
    }
}
