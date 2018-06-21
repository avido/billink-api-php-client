<?php
namespace Avido\BillinkApiClient\Request;
/**
    @File: PaymentResumeRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/

class PaymentResumeRequest extends BaseRequest
{
    protected $workflownumber;
    protected $invoicenumber;
    protected $resume ='y';
    
    public function __construct()
    {
        parent::__construct('resume');
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
     * Invoicenumber
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
}
