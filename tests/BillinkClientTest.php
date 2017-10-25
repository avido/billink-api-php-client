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
// requests
use Avido\BillinkApiClient\Request\CreditCheckRequest;
use Avido\BillinkApiClient\Request\OrderRequest;
use Avido\BillinkApiClient\Request\OrderItem;
use Avido\BillinkApiClient\Request\StatusRequest;
use Avido\BillinkApiClient\Request\WorkflowRequest;
use Avido\BillinkApiClient\Request\CreditRequest;
use Avido\BillinkApiClient\Request\PaymentRequest;
use Avido\BillinkApiClient\Request\PaymentOnHoldRequest;
use Avido\BillinkApiClient\Request\FileRequest;

// entities
use Avido\BillinkApiClient\Entities\Invoice;



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
     * @group single
     * @group creditcheck
     * @group order
     */
    public function testCreditCheck()
    {
        $check = new CreditCheckRequest();
        $check->setType('P')
            ->setWorkflownumber(1)
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
    
    /**
     * Request Status test
     * 
     * @group status
     * @xdepends testCreditCheck
     */
    public function testStatus()
    {
        
        $status = new StatusRequest();
        $status->addInvoice(new Invoice(['workflownumber'=> 1, 'invoicenumber' => '1508925794']))
            ->addInvoice(new Invoice(['workflownumber' => 1, 'invoicenumber' => '150892576912']));
        $response = $this->client->status($status);
        $this->assertTrue(count($response->getInvoices()) >0);
    }
        
    /**
     * Request Status  Exception, no invoices provided test
     * 
     * @group status
     */
    public function testStatusMissingInvoicesClientException()
    {
        $this->expectException(BillinkClientException::class);
        $status = new StatusRequest();
        $this->client->status($status);
    }
    
    /**
     * Request Workflow Start test
     * 
     * @group workflow
     * @xdepends testCreditCheck
     */
    public function testWorkflowStart()
    {
        
        $workflow = new WorkflowRequest();
        $workflow->addInvoice(new Invoice(['workflownumber'=> 1, 'invoicenumber' => '1508935410']))
            ->addInvoice(new Invoice(['workflownumber' => 1, 'invoicenumber' => '1508935305']));
        $response = $this->client->startWorkflow($workflow);
        $this->assertEquals(500, $response->getCode());
    }
        
    /**
     * Request Status  Exception, no invoices provided test
     * 
     * @group workflow
     */
    public function testWorkflowStartMissingInvoicesClientException()
    {
        $this->expectException(BillinkClientException::class);
        $workflow = new WorkflowRequest();
        $this->client->startWorkflow($workflow);
    }
    
    /**
     * Request Credit test
     * 
     * @group credit
     * @xdepends testCreditCheck
     */
    public function testCredit()
    {
        
        $credit = new CreditRequest();
        $credit->addInvoice(new Invoice(['workflownumber'=> 1, 'invoicenumber' => '1508935410', 'creditamount' => 10.00, 'description' => 'credit test']))
            ->addInvoice(new Invoice(['workflownumber' => 1, 'invoicenumber' => '1508935305', 'creditamount' => 1.00, 'description' => 'credit test']));
        $response = $this->client->Credit($credit);
        $this->assertTrue(count($response->getInvoices()) >0);
    }
    
    /**
     * Request Payment test
     * 
     * @group payment
     * @xdepends testCreditCheck
     */
    public function testPayment()
    {
        
        $payment = new PaymentRequest();
        $payment->addInvoice(new Invoice(['workflownumber'=> 1, 'invoicenumber' => '1508935410', 'amount' => 10.00, 'description' => 'payment test']))
            ->addInvoice(new Invoice(['workflownumber' => 1, 'invoicenumber' => '1508935305', 'amount' => 1.00, 'description' => 'payment test']));
        $response = $this->client->Payment($payment);
        $this->assertTrue(count($response->getInvoices()) >0);
    }
        
    
    /**
     * Request Payment OnHold test
     * 
     * @group onhold
     * @xdepends testCreditCheck
     */
    public function testPaymentOnHold()
    {
        
        $onHold = new Request\PaymentOnHoldRequest();
        $onHold->setWorkflowNumber(1)
            ->setInvoiceNumber(1508935410);
        $response = $this->client->paymentOnHold($onHold);
        echo "<pre>";
        print_r($response);exit;
        $this->assertTrue(count($response->getInvoices()) >0);
    }
        
    /**
     * Request Payment Resume test
     * 
     * @group resume
     * @xdepends testCreditCheck
     */
    public function testPaymentResume()
    {
        $paymentResume = new Request\PaymentResumeRequest();
        $paymentResume->setWorkflowNumber(1)
            ->setInvoiceNumber(1508935410);
        $response = $this->client->paymentResume($paymentResume);
        echo "<pre>";
        print_r($response);exit;
        $this->assertTrue(count($response->getInvoices()) >0);
    }
        
        
    /**
     * Request File (PDF) test
     * 
     * @group file
     * @xdepends testCreditCheck
     */
    public function testFile()
    {
        $fileRequest = new Request\FileRequest();
        $fileRequest->setWorkflowNumber(1)
            ->setInvoiceNumber(1508935410);
        $response = $this->client->file($fileRequest);
        $this->assertNotNull($response->getFilename());
    }
        
    /**
     * Request Message test
     * 
     * @group message
     * @xdepends testCreditCheck
     */
    public function testMessage()
    {
        $messageRequest = new Request\MessageRequest();
        $messageRequest->setWorkflowNumber(1)
            ->setInvoiceNumber(1508935410)
            ->setMessage('Message test 1234');
        $response = $this->client->message($messageRequest);
        $this->assertEquals(200, $response->getCode());        
    }
}
