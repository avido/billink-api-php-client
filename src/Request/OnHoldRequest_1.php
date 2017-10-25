<?php
namespace Avido\BillinkApiClient\Request;
/**
    @File: OnHoldRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/

class OnHoldRequest extends BaseRequest
{
    protected $workflownumber;
    protected $invoicenumber;
    protected $days;
    
    public function __construct()
    {
        parent::__construct('Onhold');
    }
    
    public function setWorkflowNumber($workflownumber)
    {
        $this->workflownumber = $workflownumber;
        return $this;
    }
    public function setInvoiceNumber($invoicenumber)
    {
        $this->invoicenumber = $invoicenumber;
        return $this;
    }
    public function setDays($days)
    {
        $this->days = (int)$days;
        return $this;
    }
}
