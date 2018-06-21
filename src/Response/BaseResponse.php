<?php
namespace Avido\BillinkApiClient\Response;
/**
    @File: BaseResponse.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido
*/

use Avido\BillinkApiClient\BaseModel;

class BaseResponse extends BaseModel
{
    protected  $code;
    protected  $description;
    
    /**
     * Code
     * 
     * @access protected
     * @param int $code
     * @return $this
     */
    protected function setCode($code)
    {
        $this->code = (int)$code;
        return $this;
    }
    
    /**
     * Description
     * 
     * @access protected
     * @param string $description
     * @return $this
     */
    protected function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    
}
