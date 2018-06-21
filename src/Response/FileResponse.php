<?php
namespace Avido\BillinkApiClient\Response;

/**
    @File: FileResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/
class FileResponse extends BaseResponse
{
    protected  $filename;
    
    public function __construct($xml = null)
    {
        if ($xml instanceof \SimpleXMLElement) {
            $this->setCode((string)$xml->MSG->CODE);
            $this->setFilename((string)$xml->MSG->DESCRIPTION);
        }
    }
    
    /**
     * Filename
     * 
     * @access public
     * @param string $filename
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }
    
    /**
     * Filename
     * 
     * @access public
     * @return mixed string|null
     */
    public function getFilename()
    {
        return ($this->filename != '') ? $this->filename : null;
    }
}
