<?php
namespace Avido\BillinkApiClient\Request;
/**
    @File: CreditCheck.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @see https://test.billink.nl/api/docs
    @copyright   Avido
*/

class CreditCheckRequest extends BaseRequest
{
    protected  $type;
    protected  $companyname;
    protected  $chamberofcommerce;
    protected  $workflownumber;
    protected  $firstname;
    protected  $initials;
    protected  $lastname;
    protected  $housenumber;
    protected  $houseextension;
    protected  $postalcode;
    protected  $phonenumber;
    protected  $birthdate;
    protected  $email;
    protected  $orderamount;
    protected  $ip;
    protected  $backdoor;
    
    public function __construct() 
    {
        parent::__construct('Check');
    }
    
    /**
     * Type (P = B2B, B = B2B)
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
    public function setChamberofcommerce($chamberofcommerce)
    {
        $this->chamberofcommerce = $chamberofcommerce;
        return $this;
    }
    
    /**
     * Workflow number
     * Options:
            1: 14 Dagen Garantie Particulieren en Klein Zakelijk
            2: 14 Dagen Groot Zakelijk
            3: Geen garantie
     * @param int $workflownumber
     * @return $this
     */
    public function setWorkflownumber($workflownumber)
    {
        $this->workflownumber = (int)$workflownumber;
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
     * Lastname
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
     * House number extension
     * 
     * @access public
     * @param string $houseextension
     * @return $this
     */
    public function setHouseextension($houseextension)
    {
        $this->houseextension = $houseextension;
        return $this;
    }
    
    /**
     * Postal code
     * 
     * @access public
     * @param string $postalcode
     * @return $this
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
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
     * Birthday (mandatory Type "P")
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
     * Order amount
     * 
     * @access public
     * @param float $orderamount
     * @return $this
     */
    public function setOrderamount($orderamount)
    {
        $this->orderamount = (float)$orderamount;
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
     * Backdoor (credit check always validates)
     * 
     * @access public
     * @param int $backdoor
     * @return $this
     */
    public function setBackdoor($backdoor)
    {
        $this->backdoor = (int)$backdoor;
        return $this;
    }
}
