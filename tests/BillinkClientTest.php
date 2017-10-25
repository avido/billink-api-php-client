<?php
/**
    @File: BillinkClientTest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido

    Several unit tests for the Billink API PHP CLIENT
*/
namespace Avido\BillinkApiClient;

use PHPUnit\Framework\TestCase;
use Avido\BillinkApiClient\BillinkClient;
use Avido\BillinkApiClient\Request\CreditCheckRequest;
use Avido\BillinkApiClient\Request\OrderRequest;
use Avido\BillinkApiClient\Request\OrderItem;


use Avido\BillinkApiClient\Exceptions\BillinkClientException;

#use Avido\CopernicaRestClient\Exceptions\CopernicaRestClientBadResponseException;
use Monolog\Handler\StreamHandler;


class BillinkClientTest extends TestCase
{
    /**
     * @var Avido\BillinkApiClient\BillinkClient
     */
    private $client;

    /**
     * 
     * Caching placeholder (key/values)
     * 
     * @var array
     */
    private $cache = []; 
    
    public function setUp()
    {
        // retrieve username from phpunit.xml config
        $username = getenv('PHP_USERNAME');
        // retrieve client id from phpunit.xml config
        $client_id = getenv('PHP_CLIENTID');
        // test with logger
#        $handler = new StreamHandler(dirname(__FILE__) . '/../apiClient.log', \Monolog\Logger::DEBUG);
        $this->client = new BillinkClient($username, $client_id /*, $handler*/);
        $this->client->setTestMode(true);
    }

    /**
     * Test Request Credit Check
     * 
     * @group creditcheck
     * @group order
     */
    public function testCreditCheck()
    {
        $check = new CreditCheckRequest();
        $check->setType('P')
            ->setWorkflownumber(1)
            ->setAction('Check')
            ->setFirstname('T')
            ->setLastname('Test')
            ->setInitials('T')
            ->setHousenumber(1)
            ->setHouseextension('a')
            ->setPostalcode('1234AA')
            ->setPhonenumber('0612345678')
            ->setBirthdate('01-01-1980')
            ->setEmail('gokyto@cars2.club')
            ->setOrderamount('120.09')
            ->setIp('127.0.0.1')
            ->setBackdoor(1);
        $response = $this->client->check($check);
        $this->assertEquals(500, $response->getCode());
        return $response->getUuid();
    }
    
    public function testCreditCheckBillinkClientException()
    {
        $this->expectException(BillinkClientException::class);
        $check = new CreditCheckRequest();
        $check->setType('P')
            ->setWorkflownumber(1)
            ->setAction('Check')
            ->setFirstname('T')
            ->setLastname('Test')
            ->setInitials('T')
            ->setHousenumber(1)
            ->setHouseextension('a')
            ->setPostalcode('1234AA')
            ->setPhonenumber('') // missing phonenumber
            ->setBirthdate('01-01-1980')
            ->setEmail('gokyto@cars2.club')
            ->setOrderamount('120.09')
            ->setIp('127.0.0.1')
            ->setBackdoor(1);
        $this->client->check($check);
    }
    
    public function testCreditCheckRuntimeException()
    {
        $this->expectException(\RuntimeException::class);
        $check = new CreditCheckRequest();
        $check->setType('P')
            ->setWorkflownumber(100)
            ->setAction('Check')
            ->setFirstname('T')
            ->setLastname('Test')
            ->setInitials('T')
            ->setHousenumber(1)
            ->setHouseextension('a')
            ->setPostalcode('1234AA')
            ->setPhonenumber('0123456789') // missing phonenumber
            ->setBirthdate('01-01-1980')
            ->setEmail('gokyto@cars2.club')
            ->setOrderamount('120.09')
            ->setIp('127.0.0.1')
            ->setBackdoor(1);
        $this->client->check($check);
    }
    
    /**
     * Request Order test
     * 
     * @group order
     * @depends testCreditCheck
     */
    public function testOrder($uuid)
    {
        // echo "Running test order with uuid: {$uuid}\n";
        $order_id = time();
        $checkUuid = $uuid;
        $order = new OrderRequest();
        $order->setWorkflownumber(1)
            ->setAction('Order')
            ->setOrdernumber($order_id)
            ->setDate(date("Y-m-d"))
            ->setType('P')
            ->setFirstname('T')
            ->setLastname('Test')
            ->setInitials('T')
            ->setSex('M')
            ->setBirthdate('01-01-1980')
            ->setStreet('straat')
            ->setHousenumber(1)
            ->setHouseExtension('a')
            ->setPostalCode('1234AA')
            ->setCountryCode('NL')
            ->setCity('plaats')
            ->setDeliveryStreet('straat')
            ->setDeliveryHousenumber(1)
            ->setDeliveryHouseExtension('a')
            ->setDeliveryPostalcode('1234AA')
            ->setDeliveryCountrycode('NL')
            ->setDeliveryCity('Plaats')
            ->setDeliveryAddressFirstname('T')
            ->setDeliveryAddressLastname('Test')
            ->setPhoneNumber('0612345678')
            ->setBirthdate('01-01-1980')
            ->setEmail('gokyto@cars2.club')
            ->setIp('127.0.0.1')
            ->setAdditionalText('Additionele tekst')
            ->setTrackAndTrace('123verzondenmet')
            ->setCheckUuid($checkUuid);
        // order items can be added in several ways.
        $order->addItem(new OrderItem([
            'code' => 'product-a',
            'description' => 'Product A',
            'orderquantity' => 1,
            'priceincl' => 12.09,
            'btw' => 21
        ]));
        $orderItem = new OrderItem();
        $orderItem->setCode('product-b')
            ->setDescription('Product B')
            ->setOrderQuantity(1)
            ->setPrice(14.11)
            ->setVat(21);
        $order->addItem($orderItem);
        $order->setOrderItems([
            new OrderItem([
                'code' => 'product-c',
                'description' => 'Product C',
                'orderquantity' => 1,
                'priceincl' => 12.09,
                'btw' => 21
            ]),
            new OrderItem([
                'code' => 'product-d',
                'description' => 'Product D',
                'orderquantity' => 1,
                'priceincl' => 12.39,
                'btw' => 21
            ]),
        ]);
        
        #echo $order->toXml();
        $response = $this->client->simpleOrder($order);
        $this->assertEquals(200, $response->getCode());
        return $order_id;
    }
    
    /**
     * Test order exception unknown UUID
     * @group order
     */
    public function testOrderUnkownUUIDBillinkClientException()
    {
        $this->expectException(BillinkClientException::class);
        $order_id = time();
        $checkUuid = 'unkown-uuid-' . time();
        $order = new OrderRequest();
        $order->setWorkflownumber(1)
            ->setAction('Order')
            ->setOrdernumber($order_id)
            ->setDate(date("Y-m-d"))
            ->setType('P')
            ->setFirstname('T')
            ->setLastname('Test')
            ->setInitials('T')
            ->setSex('M')
            ->setBirthdate('01-01-1980')
            ->setStreet('straat')
            ->setHousenumber(1)
            ->setHouseExtension('a')
            ->setPostalCode('1234AA')
            ->setCountryCode('NL')
            ->setCity('plaats')
            ->setDeliveryStreet('straat')
            ->setDeliveryHousenumber(1)
            ->setDeliveryHouseExtension('a')
            ->setDeliveryPostalcode('1234AA')
            ->setDeliveryCountrycode('NL')
            ->setDeliveryCity('Plaats')
            ->setDeliveryAddressFirstname('T')
            ->setDeliveryAddressLastname('Test')
            ->setPhoneNumber('0612345678')
            ->setBirthdate('01-01-1980')
            ->setEmail('gokyto@cars2.club')
            ->setIp('127.0.0.1')
            ->setAdditionalText('Additionele tekst')
            ->setTrackAndTrace('123verzondenmet')
            ->setCheckUuid($checkUuid);
        // order items can be added in several ways.
        $order->addItem(new OrderItem([
            'code' => 'product-a',
            'description' => 'Product A',
            'orderquantity' => 1,
            'priceincl' => 12.09,
            'btw' => 21
        ]));
        $this->client->simpleOrder($order);
    }
    
    /**
     * Test order exception missing lastname
     * @group order
     * @depends testCreditCheck
     */
    public function testOrderMissingLastnameClientException($uuid)
    {
        $this->expectException(BillinkClientException::class);
        $order_id = time();
        $checkUuid = $uuid;
        $order = new OrderRequest();
        $order->setWorkflownumber(1)
            ->setAction('Order')
            ->setOrdernumber($order_id)
            ->setDate(date("Y-m-d"))
            ->setType('P')
            ->setFirstname('T')
            ->setLastname('')
            ->setInitials('T')
            ->setSex('M')
            ->setBirthdate('01-01-1980')
            ->setStreet('straat')
            ->setHousenumber(1)
            ->setHouseExtension('a')
            ->setPostalCode('1234AA')
            ->setCountryCode('NL')
            ->setCity('plaats')
            ->setDeliveryStreet('straat')
            ->setDeliveryHousenumber(1)
            ->setDeliveryHouseExtension('a')
            ->setDeliveryPostalcode('1234AA')
            ->setDeliveryCountrycode('NL')
            ->setDeliveryCity('Plaats')
            ->setDeliveryAddressFirstname('T')
            ->setDeliveryAddressLastname('Test')
            ->setPhoneNumber('0612345678')
            ->setBirthdate('01-01-1980')
            ->setEmail('gokyto@cars2.club')
            ->setIp('127.0.0.1')
            ->setAdditionalText('Additionele tekst')
            ->setTrackAndTrace('123verzondenmet')
            ->setCheckUuid($checkUuid);
        // order items can be added in several ways.
        $order->addItem(new OrderItem([
            'code' => 'product-a',
            'description' => 'Product A',
            'orderquantity' => 1,
            'priceincl' => 12.09,
            'btw' => 21
        ]));
        $this->client->simpleOrder($order);
    }
}