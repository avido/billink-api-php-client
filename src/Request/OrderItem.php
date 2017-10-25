<?php
namespace Avido\BillinkApiClient\Request;

use DOMDocument;

use Avido\BillinkApiClient\BaseModel;

/**
    @File: OrderItem.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/
class OrderItem extends BaseModel
{
    protected $code;
    protected $description;
    protected $orderQuantity;
    protected $price;
    protected $vat;
    
    public function __construct($data=null) {
        if (is_array($data)) {
            if (isset($data['code'])) {
                $this->setCode($data['code']);
            }
            if (isset($data['description'])) {
                $this->setDescription($data['description']);
            }
            if (isset($data['orderquantity'])) {
                $this->setOrderQuantity($data['orderquantity']);
            }
            if (isset($data['priceincl'])) {
                $this->setPrice($data['priceincl']);
            }
            if (isset($data['btw'])) {
                $this->setVat($data['btw']);
            }
        }
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
    public function setOrderQuantity($orderQuantity)
    {
        $this->orderQuantity = $orderQuantity;
        return $this;
    }
    public function setPrice($price)
    {
        $this->price = number_format($price, 2, '.', ',');
        return $this;
    }
    public function setVat($vat)
    {
        $this->vat = (int)$vat;
        return $this;
    }
    
    public function getCode()
    {
        return $this->code;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getOrderQuantity()
    {
        return $this->orderQuantity;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getVat()
    {
        return (int)$this->vat;
    }
    
    public function toArray() {
        return [
            'code' => $this->code,
            'description' => $this->description,
            'orderquantity' => $this->orderQuantity,
            'priceincl' => $this->price,
            'btw' => $this->vat
        ];
    }
}
