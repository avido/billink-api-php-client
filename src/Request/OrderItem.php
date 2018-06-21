<?php
namespace Avido\BillinkApiClient\Request;
/**
    @File: OrderItem.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/

use Avido\BillinkApiClient\BaseModel;

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
            if (isset($data['vat'])) {
                $this->setVat($data['vat']);
            }
        }
    }
    
    /**
     * Code 
     * 
     * @access public
     * @param mixed $code
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
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Quantity
     * 
     * @access public
     * @param int $orderQuantity
     * @return $this
     */
    public function setOrderQuantity($orderQuantity)
    {
        $this->orderQuantity = (int)$orderQuantity;
        return $this;
    }
    
    /**
     * Price
     * 
     * @access public
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = number_format($price, 2, '.', ',');
        return $this;
    }
    
    /**
     * Vat 
     * 
     * @access public
     * @param float $vat
     * @return $this
     */
    public function setVat($vat)
    {
        $this->vat = (float)$vat;
        return $this;
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
     * Order quantity
     * 
     * @access public
     * @return int
     */
    public function getOrderQuantity()
    {
        return (int)$this->orderQuantity;
    }
    
    /**
     * Price
     * 
     * @access public
     * @return float
     */
    public function getPrice()
    {
        return (float)$this->price;
    }
    
    /**
     * Vat 
     * 
     * @access public
     * @return float
     */
    public function getVat()
    {
        return (float)$this->vat;
    }
    
    /**
     * Cast object to array
     * 
     * @access public
     * @return array
     */
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
