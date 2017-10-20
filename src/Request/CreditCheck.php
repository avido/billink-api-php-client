<?php
namespace Avido\BillinkApiClient\Request;

/**
    @File: CreditCheck.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Copernica Rest Api Client
    @copyright   Avido
*/
class CreditCheck extends BaseRequest
{
    protected  $type;
    protected  $companyname;
    protected  $chamberofcommerce;
    protected  $workflownumber;
    protected  $action;
    protected  $firstname;
    protected  $lastname;
    protected  $initials;
    protected  $housenumber;
    protected  $houseextension;
    protected  $postalcode;
    protected  $phonenumber;
    protected  $birthdate;
    protected  $email;
    protected  $orderamount;
    protected  $ip;
    protected  $backdoor;
    
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function setCompanyname($companyname)
    {
        $this->companyname = $companyname;
        return $this;
    }
    public function setChamberofcommerce($chamberofcommerce)
    {
        $this->chamberofcommerce = $chamberofcommerce;
        return $this;
    }
    public function setWorkflownumber($workflownumber)
    {
        $this->workflownumber = $workflownumber;
        return $this;
    }
    public function setAction($action)
    {
        $this->action = $action;
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
    public function setHousenumber($housenumber)
    {
        $this->housenumber = $housenumber;
        return $this;
    }
    public function setHouseextension($houseextension)
    {
        $this->houseextension = $houseextension;
        return $this;
    }
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
        return $this;
    }
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
        return $this;
    }
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
        return $this;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    public function setOrderamount($orderamount)
    {
        $this->orderamount = $orderamount;
        return $this;
    }
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
    public function setBackdoor($backdoor)
    {
        $this->backdoor = $backdoor;
        return $this;
    }

}
