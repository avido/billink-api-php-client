<?php
namespace Avido\BillinkApiClient\Request;


use DOMDocument;
use SimpleXMLElement;

use Avido\BillinkApiClient\BaseModel;

/**
    @File: OrderRequest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/
class OrderRequest extends BaseModel
{
    protected $companyname;
    protected $chamberofcommerce;
    protected $action;
    protected $workflownumber;
    protected $ordernumber;
    protected $date;
    protected $type;
    protected $firstname;
    protected $lastname;
    protected $initials;
    protected $sex;
    protected $birthdate;
    protected $street;
    protected $housenumber;
    protected $houseextension;
    protected $postalcode;
    protected $countrycode;
    protected $city;
    protected $deliveryStreet;
    protected $deliveryHousenumber;
    protected $deliveryHouseExtension;
    protected $deliveryPostalcode;
    protected $deliveryCountrycode;
    protected $deliveryCity;
    protected $deliveryAddressCompanyname;
    protected $deliveryAddressFirstname;
    protected $deliveryAddressLastname;
    protected $phonenumber;
    protected $email;
    protected $email2;
    protected $ip;
    protected $additionaltext;
    protected $trackandtrace;
    protected $vatnumber;
    protected $debtornumber;
    protected $checkuuid;
    protected $orderitems = [];


    public function setCompanyname($companyname)
    {
        $this->companyname = $companyname;
        return $this;
    }
    public function setChamberOfCommerce($chamberofcommerce)
    {
        $this->chamberofcommerce = $chamberofcommerce;
        return $this;
    }
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
    public function setWorkflowNumber($workflownumber)
    {
        $this->workflownumber = $workflownumber;
        return $this;
    }
    public function setOrdernumber($ordernumber)
    {
        $this->ordernumber = $ordernumber;
        return $this;
    }
    public function setDate($date) 
    {
        $this->date = $date;
        return $this;
    }
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }
    public function setInitials($initials)
    {
        $this->initials = $initials;
        return $this;
    }
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
        return $this;
    }
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }
    public function setHousenumber($housenumber)
    {
        $this->housenumber = $housenumber;
        return $this;
    }
    public function setHouseExtension($houseextension)
    {
        $this->houseextension = $houseextension;
        return $this;
    }
    public function setPostalCode($postalcode) 
    {
        $this->postalcode = $postalcode;
        return $this;
    }
    public function setCountryCode($countrycode)
    {
        $this->countrycode = $countrycode;
        return $this;
    }
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
    public function setDeliveryStreet($deliveryStreet)
    {
        $this->deliveryStreet = $deliveryStreet;
        return $this;
    }
    public function setDeliveryHousenumber($deliveryHousenumber)
    {
        $this->deliveryHousenumber = $deliveryHousenumber;
        return $this;
    }
    public function setDeliveryHouseExtension($deliveryHouseExtension)
    {
        $this->deliveryHouseExtension = $deliveryHouseExtension;
        return $this;
    }
    public function setDeliveryPostalcode($deliveryPostalcode)
    {
        $this->deliveryPostalcode = $deliveryPostalcode;
        return $this;
    }
    public function setDeliveryCountrycode($deliveryCountrycode)
    {
        $this->deliveryCountrycode = $deliveryCountrycode;
        return $this;
    }
    public function setDeliveryCity($deliveryCity)
    {
        $this->deliveryCity = $deliveryCity;
        return $this;
    }
    public function setDeliveryAddressCompanyname($deliveryAddressCompanyname)
    {
        $this->deliveryAddressCompanyname = $deliveryAddressCompanyname;
        return $this;
    }
    public function setDeliveryAddressFirstname($deliveryAddressFirstname)
    {
        $this->deliveryAddressFirstname = $deliveryAddressFirstname;
        return $this;
    }
    public function setDeliveryAddressLastname($deliveryAddressLastname)
    {
        $this->deliveryAddressLastname = $deliveryAddressLastname;
        return $this;
    }
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
        return $this;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    public function setEmail2($email2)
    {
        $this->email2 = $email2;
        return $this;
    }
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
    public function setAdditionalText($additionaltext)
    {
        $this->additionaltext = $additionaltext;
        return $this;
    }
    public function setTrackAndTrace($trackandtrace)
    {
        $this->trackandtrace = $trackandtrace;
        return $this;
    }
    public function setVatnumber($vatnumber)
    {
        $this->vatnumber = $vatnumber;
        return $this;
    }
    public function setDebtorNumber($debtornumber)
    {
        $this->debtornumber = $debtornumber;
        return $this;
    }
    public function setCheckUuid($checkuuid)
    {
        $this->checkuuid = $checkuuid;
        return $this;
    }
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

    public function addItem(OrderItem $item)
    {
        $this->orderitems[] = $item;
        return $this;
    }
    
    public function toXml()
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $api = $document->createElement('API');
            $api->appendChild($document->createElement('VERSION', $this->getVersion()));
            $api->appendChild($document->createElement('CLIENTUSERNAME', $this->getUsername()));
            $api->appendChild($document->createElement('CLIENTID', $this->getClientId()));
            
            // append data from request.
            foreach ($this->toArray() as $key=>$val) {
                if ($key == 'orderitems') {
                    $items = $document->createElement('ORDERITEMS');
                    foreach ($val as $item) {
                        $childItem = $document->createElement('ITEM');
                        foreach ($item->toArray() as $childKey => $childVal) {
                            $childItem->appendChild($document->createElement(strtoupper($childKey), $childVal));
                        }
                        $items->appendChild($childItem);
                    }
                    $api->appendChild($items);
                } else {
                    $api->appendChild($document->createElement(strtoupper($key), $val));
                }
            }
        $document->appendChild($api);
        $document->formatOutput = true;
        return $document->saveXml();
    }
}
