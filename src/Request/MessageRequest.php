<?php
namespace Avido\BillinkApiClient\Request;
/**
    @File: MessageRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/
class MessageRequest extends BaseRequest
{
    protected $workflownumber;
    protected $invoicenumber;
    protected $message;
    
    public function __construct()
    {
        parent::__construct('message');
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
}
