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
}
