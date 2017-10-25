<?php
namespace Avido\BillinkApiClient\Entities;

use Avido\BillinkApiClient\BaseModel;
/**
    @File: Invoice.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/
class Invoice extends BaseModel
{
    // statusRequest
    protected $workflownumber;
    protected $invoicenumber;
    protected $status; // Status is used in StatusRequest, Code is used in WorkflowRequest (workflow start)
    protected $description; // Description is used in StatusRequest, Message is used in WorkflowRequest (workflow start)
    // workflowRequest
    protected $code; 
    protected $message;
    // creditRequest
    protected $creditamount;
    // payment Request
    protected $amount;
    
    
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
            if (isset($data['code'])) {
                $this->setCode($data['code']);
            }
            if (isset($data['description'])) {
                $this->setDescription($data['description']);
            }
            if (isset($data['message'])) {
                $this->setMessage($data['message']);
            }
            if (isset($data['creditamount'])) {
                $this->setCreditAmount($data['creditamount']);
            }
            if (isset($data['amount'])) {
                $this->setAmount($data['amount']);
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
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    public function setCreditAmount($amount)
    {
        $this->creditamount = number_format($amount, 2, ".", ",");
        return $this;
    }
    public function setAmount($amount)
    {
        $this->amount = number_format($amount, 2, ".", ",");
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
    public function getCode()
    {
        return $this->code;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getMessage()
    {
        return $this->message;
    }
    public function getCreditAmount()
    {
        return $this->creditamount;
    }
    public function getAmount()
    {
        return $this->amount;
    }

    public function toArray($filter=[]) {
        if (count($filter) > 0) {
            $return = [];
            foreach ($filter as $key) {
                $return[$key] = $this->getData($key);
            }
            return $return;
        } else {
            return parent::toArray();
        }
    }
}
