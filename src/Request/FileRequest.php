<?php
namespace Avido\BillinkApiClient\Request;
/**
    @File: FileRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/
class FileRequest extends BaseRequest
{
    protected $workflownumber;
    protected $invoicenumber;

    public function __construct()
    {
        parent::__construct('pdf');
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
