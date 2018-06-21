<?php
namespace Avido\BillinkApiClient\Request;
/**
    @File: OrderRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/

class OrderRequest extends BaseRequest
{
    protected $type;
    protected $companyname;
    protected $chamberofcommerce;
    protected $workflownumber;
    protected $ordernumber;
    protected $date;
    protected $firstname;
    protected $initials;
    protected $lastname;
    protected $sex;
    protected $street;
    protected $housenumber;
    protected $houseextension;
    protected $postalcode;
    protected $countrycode;
    protected $city;
    protected $phonenumber;
    protected $birthdate;
    protected $email;
    protected $email2;
    protected $ip;
    protected $additionaltext;
    protected $trackandtrace;
    protected $variable1;
    protected $variable2;
    protected $variable3;
    protected $vatnumber;
    protected $debtornumber;
    protected $checkuuid;
    protected $currency;
    protected $state;
    protected $locality;
    
    protected $deliveryStreet;
    protected $deliveryHousenumber;
    protected $deliveryHouseExtension;
    protected $deliveryPostalcode;
    protected $deliveryCountrycode;
    protected $deliveryCity;
    protected $deliveryAddressCompanyname;
    protected $deliveryAddressFirstname;
    protected $deliveryAddressLastname;
    protected $orderitems = [];

    public function __construct()
    {
        parent::__construct('Order');
    }
    
    /**
     * Set Type (P = B2C, B = B2B)
     * 
     * @access public
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    /**
     * Companyname
     * 
     * @access public
     * @param string $companyname
     * @return $this
     */
    public function setCompanyname($companyname)
    {
        $this->companyname = $companyname;
        return $this;
    }
    
    /**
     * Chamber of commerce
     * 
     * @access public
     * @param string $chamberofcommerce
     * @return $this
     */
    public function setChamberOfCommerce($chamberofcommerce)
    {
        $this->chamberofcommerce = $chamberofcommerce;
        return $this;
    }
    
    /**
     * Workflow number
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
     * Ordernumber 
     * 
     * @access public
     * @param mixed $ordernumber
     * @return $this
     */
    public function setOrdernumber($ordernumber)
    {
        $this->ordernumber = $ordernumber;
        return $this;
    }
    
    /**
     * Set (order) date
     * 
     * @param string $date
     * @return $this
     */
    public function setDate($date) 
    {
        $this->date = $date;
        return $this;
    }
    
    /**
     * Firstname 
     * 
     * @access public
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }
    
    /**
     * Initials
     * 
     * @access public
     * @param string $initials
     * @return $this
     */
    public function setInitials($initials)
    {
        $this->initials = $initials;
        return $this;
    }
    
    /**
     * Last name
     * 
     * @access public
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }
    
    /**
     * Sex (M|F)
     * 
     * @access public
     * @param string $sex
     * @return $this
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }
    
    /**
     * Street
     * 
     * @access public
     * @param string $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }
    
    /**
     * House number
     * 
     * @access public
     * @param int $housenumber
     * @return $this
     */
    public function setHousenumber($housenumber)
    {
        $this->housenumber = (int)$housenumber;
        return $this;
    }
    
    /**
     * Housenumber extension
     * 
     * @access public
     * @param string $houseextension
     * @return $this
     */
    public function setHouseExtension($houseextension)
    {
        $this->houseextension = $houseextension;
        return $this;
    }
    
    /**
     * Postcode
     * 
     * @access public
     * @param string $postalcode
     * @return $this
     */
    public function setPostalCode($postalcode) 
    {
        $this->postalcode = $postalcode;
        return $this;
    }
    
    /**
     * Country code (ISO 3166-1 alpha-2.)
     * 
     * @access public
     * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
     * @param string $countrycode
     * @return $this
     */
    public function setCountryCode($countrycode)
    {
        $this->countrycode = $countrycode;
        return $this;
    }
    
    /**
     * City
     * 
     * @access public
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
    
    /**
     * Phonenumber
     * 
     * @access public
     * @param string $phonenumber
     * @return $this
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
        return $this;
    }
    
    /**
     * Birthday (mandatory, Type "P")
     * 
     * @access public
     * @param string $birthdate
     * @return $this
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
        return $this;
    }
    
    /**
     * Email
     * 
     * @access public
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    /**
     * Optional addition email
     * 
     * @access public
     * @param string $email2
     * @return $this
     */
    public function setEmail2($email2)
    {
        $this->email2 = $email2;
        return $this;
    }
    
    /**
     * IP
     * 
     * @access public
     * @param string $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
    
    /**
     * Optional additional text
     * 
     * @access public
     * @param string $additionaltext
     * @return $this
     */
    public function setAdditionalText($additionaltext)
    {
        $this->additionaltext = $additionaltext;
        return $this;
    }
    
    /**
     * Track and trace code of shipment
     * 
     * @access public
     * @param string $trackandtrace
     * @return $this
     */
    public function setTrackAndTrace($trackandtrace)
    {
        $this->trackandtrace = $trackandtrace;
        return $this;
    }
    
    /**
     * Optional Variable 1
     * 
     * @access public
     * @param mixed $variable1
     * @return $this
     */
    public function setVariable1($variable1)
    {
        $this->variable1 = $variable1;
        return $this;
    }
    
    /**
     * Optional Variable 2
     * 
     * @access public
     * @param mixed $variable2
     * @return $this
     */
    public function setVariable2($variable2)
    {
        $this->variable2 = $variable2;
        return $this;
    }
    
    /**
     * Optional Variable 3
     * 
     * @access public
     * @param mixed $variable3
     * @return $this
     */
    public function setVariable3($variable3)
    {
        $this->variable3 = $variable3;
        return $this;
    }
    
    /**
     * Vatnumber
     * 
     * @access public
     * @param string $vatnumber
     * @return $this
     */
    public function setVatnumber($vatnumber)
    {
        $this->vatnumber = $vatnumber;
        return $this;
    }
    
    /**
     * Debtornumber
     * 
     * @access public
     * @param string $debtornumber
     * @return $this
     */
    public function setDebtorNumber($debtornumber)
    {
        $this->debtornumber = $debtornumber;
        return $this;
    }
    
    /**
     * Check UUID (obtainable by creditcheck)
     * 
     * @access public
     * @param string $checkuuid
     * @return $this
     */
    public function setCheckUuid($checkuuid)
    {
        $this->checkuuid = $checkuuid;
        return $this;
    }
    
    /**
     * Currency
     * 
     * @access public
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }
    
    /**
     * State
     * 
     * @access public
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    
    /**
     * Locality
     * 
     * @access public
     * @param string $locality
     * @return $this
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
        return $this;
    }
    /**
     * Delivery fields can be left empty if same as financial information
     */
    
    /**
     * Delivery street
     * 
     * @access public
     * @param string $deliveryStreet
     * @return $this
     */
    public function setDeliveryStreet($deliveryStreet)
    {
        $this->deliveryStreet = $deliveryStreet;
        return $this;
    }
    
    /**
     * Delivery Housenumber
     * 
     * @access public
     * @param int $deliveryHousenumber
     * @return $this
     */
    public function setDeliveryHousenumber($deliveryHousenumber)
    {
        $this->deliveryHousenumber = (int)$deliveryHousenumber;
        return $this;
    }
    
    /**
     * Delivery Housenumber extension
     * 
     * @access public
     * @param string $deliveryHouseExtension
     * @return $this
     */
    public function setDeliveryHouseExtension($deliveryHouseExtension)
    {
        $this->deliveryHouseExtension = $deliveryHouseExtension;
        return $this;
    }
    
    /**
     * Delivery postalcode
     * 
     * @access public
     * @param string $deliveryPostalcode
     * @return $this
     */
    public function setDeliveryPostalcode($deliveryPostalcode)
    {
        $this->deliveryPostalcode = $deliveryPostalcode;
        return $this;
    }
    
    /**
     * Delivery country code (ISO 3166-1 alpha-2.)
     * 
     * @access public
     * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
     * @param string $deliveryCountrycode
     * @return $this
     */
    public function setDeliveryCountrycode($deliveryCountrycode)
    {
        $this->deliveryCountrycode = $deliveryCountrycode;
        return $this;
    }
    
    /**
     * Delivery city
     * 
     * @access public
     * @param string $deliveryCity
     * @return $this
     */
    public function setDeliveryCity($deliveryCity)
    {
        $this->deliveryCity = $deliveryCity;
        return $this;
    }
    
    /**
     * Delivery companyname
     * 
     * @access public
     * @param string $deliveryAddressCompanyname
     * @return $this
     */
    public function setDeliveryAddressCompanyname($deliveryAddressCompanyname)
    {
        $this->deliveryAddressCompanyname = $deliveryAddressCompanyname;
        return $this;
    }
    
    /**
     * Delivery firstname
     * 
     * @access public
     * @param string $deliveryAddressFirstname
     * @return $this
     */
    public function setDeliveryAddressFirstname($deliveryAddressFirstname)
    {
        $this->deliveryAddressFirstname = $deliveryAddressFirstname;
        return $this;
    }
    
    /**
     * Delivery lastname
     * 
     * @access public
     * @param string $deliveryAddressLastname
     * @return $this
     */
    public function setDeliveryAddressLastname($deliveryAddressLastname)
    {
        $this->deliveryAddressLastname = $deliveryAddressLastname;
        return $this;
    }
    
    /**
     * Order items.
     * 
     * @access public
     * @param array $orderitems
     * @return $this
     */
    public function setOrderItems($orderitems = [])
    {
        foreach ($orderitems as $item) {
            if (!$item instanceof OrderItem) {
                $item = new OrderItem($item);
            }
            $this->addItem($item);
        }
        return $this;
    }

    /**
     * Add order item to items collection
     * 
     * @access public
     * @param \Avido\BillinkApiClient\Request\OrderItem $item
     * @return $this
     */
    public function addItem(OrderItem $item)
    {
        $this->orderitems[] = $item;
        return $this;
    }
    
    /**
     * Output object as xml
     * 
     * @access public
     * @return string
     */
    public function toXml()
    {
        $document = $this->prepXmlRequest();

        // append data from request.
        foreach ($this->toArray() as $key=>$val) {
            if ($key == 'orderitems') {
                $items = $document->addChild('ORDERITEMS');
                foreach ($val as $item) {
                    $childItem = $items->addChild('ITEM');
                    if ($this->isBusiness()) {
                        $fields = ['code', 'description', 'orderquantity', 'priceincl', 'btw'];
                    } else {
                        $fields = ['code', 'description', 'orderquantity', 'priceexcl', 'btw'];
                    }
                    foreach ($item->toArray($fields) as $childKey => $childVal) {
                        $childItem->addChild(strtoupper($childKey), $childVal);
                    }
                }
            } else {
                $document->addChild(strtoupper($key), $val);
            }
        }
        
        return $document->asXml();
    }
    
    /**
     * Business 
     * 
     * @access public
     * @return boolean
     */
    public function isBusiness()
    {
        return (bool)(strtoupper($this->type) == 'B') ? true : false;
    }
}
