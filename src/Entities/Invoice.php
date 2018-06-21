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

use Avido\BillinkApiClient\BaseModel;

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
    
    /**
     * Workflownumber
     * 
     * @access public
     * @param int $workflowNumber
     * @return $this
     */
    public function setWorkflowNumber($workflowNumber)
    {
        $this->workflownumber = (int)$workflowNumber;
        return $this;
    }
    
    /**
     * Invoicenumber
     * 
     * @access public
     * @param mixed $invoiceNumber
     * @return $this
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoicenumber = $invoiceNumber;
        return $this;
    }
    
    /**
     * Status
     * 
     * @access public
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    
    /**
     * Code
     * 
     * @access public
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    /**
     * Description
     * 
     * @access public
     * @param description $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Message
     * 
     * @access public
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    
    /**
     * Credit amount
     * 
     * @access public
     * @param float $amount
     * @return $this
     */
    public function setCreditAmount($amount)
    {
        $this->creditamount = number_format($amount, 2, ".", ",");
        return $this;
    }
    
    /**
     * Amount
     * 
     * @access public
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = number_format($amount, 2, ".", ",");
        return $this;
    }
    
    /**
     * Workflownumber
     * 
     * @access public
     * @return int
     */
    public function getWorkflowNumber()
    {
        return (int)$this->workflownumber;
    }
    
    /**
     * Invoicenumber
     * 
     * @access public
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoicenumber;
    }
    
    /**
     * Status
     * 
     * @access public
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Code
     * 
     * @access public
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * Description
     * 
     * @access public
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Message 
     * 
     * @access public
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Credit amount
     * 
     * @access public
     * @return float
     */
    public function getCreditAmount()
    {
        return (float)$this->creditamount;
    }
    
    /**
     * Amount
     * 
     * @access public
     * @return float
     */
    public function getAmount()
    {
        return (float)$this->amount;
    }

    /**
     * Cast object to array
     * 
     * @param array $filter - return only these keys from object
     * @return array
     */
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
