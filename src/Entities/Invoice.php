<?php
namespace Avido\BillinkApiClient\Entities;

/**
    @File: Invoice.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/
class Invoice
{
    protected $workflownumber;
    protected $invoicenumber;
    protected $status;
    protected $description;
    
    public function __construct($data=null) {
        if (is_array($data)) {
            if (isset($data['workflownumber'])) {
                $this->setWorkflowNumber($data['workflownumber']);
            }
            if (isset($data['invoicenumber'])) {
                $this->setInvoiceNumber($data['invoicenumber']);
            }
            if (isset($data['status'])) {
                $this->setStatus($data['status']);
            }
            if (isset($data['description'])) {
                $this->setDescription($data['description']);
            }
        }
    }
    public function setWorkflowNumber($workflowNumber)
    {
        $this->workflownumber = $workflowNumber;
        return $this;
    }
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoicenumber = $invoiceNumber;
        return $this;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    public function getWorkflowNumber()
    {
        return $this->workflownumber;
    }
    public function getInvoiceNumber()
    {
        return $this->invoicenumber;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function toArray() {
        return [
            'workflownumber' => $this->getWorkflowNumber(),
            'invoicenumber' => $this->getInvoiceNumber(),
            'status' => $this->getStatus(),
            'description' => $this->getDescription()
        ];
    }
}
