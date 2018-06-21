<?php
namespace Avido\BillinkApiClient\Request;
/**
    @File: PaymentOnHoldRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/

class PaymentOnHoldRequest extends BaseRequest
{
    protected $workflownumber;
    protected $invoicenumber;
    protected $days;
    
    public function __construct()
    {
        parent::__construct('Onhold');
    }
    
    /**
     * Workflownumber
     * 
     * @access public
     * @param int $workflownumber
     * @return $this
     */
    public function setWorkflowNumber($workflownumber)
    {
        $this->workflownumber = (int)$workflownumber;
        return $this;
    }
    
    /**
     * Invoice number
     * 
     * @access public
     * @param string $invoicenumber
     * @return $this
     */
    public function setInvoiceNumber($invoicenumber)
    {
        $this->invoicenumber = $invoicenumber;
        return $this;
    }
    
    /**
     * Days (to put on hold)
     * 
     * @access public
     * @param int $days
     * @return $this
     */
    public function setDays($days)
    {
        $this->days = (int)$days;
        return $this;
    }
}
