<?php
namespace Avido\BillinkApiClient;
/**
    @File: BillinkClientTest.php
    @version 0.1.0
    @Encoding:  UTF-8
    @Package: Billink API Php Client
    @copyright   Avido

    Several unit tests for the Billink API PHP CLIENT
*/

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

use Monolog\Handler\StreamHandler;


class BillinkClientTest extends TestCase
{
    /**
     * @var Avido\BillinkApiClient\BillinkClient
     */
    private $client;
    
    public function setUp()
    {
        // retrieve username from phpunit.xml config
        $username = getenv('PHP_USERNAME');
        // retrieve client id from phpunit.xml config
        $client_id = getenv('PHP_CLIENTID');
        // test with logger
#        $handler = new StreamHandler(dirname(__FILE__) . '/../apiClient.log', \Monolog\Logger::DEBUG);
        $this->client = new BillinkClient($username, $client_id /*, $handler*/);
        $this->client->setTestMode(true); // enforce test mode
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
    
    /**
     * Test Credit check exception (missing phonenumber)
     * @group creditcheck
     */
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
    
    /**
     * Test Credit check runtimeexception
     * @group order
     * @group status
     * @group workflow
     * @group credit
     * @group payment
     * @group onhold
     * @group resume
     * @group file
     * @group message
     * @group creditcheck
     */
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
     * @group status
     * @group workflow
     * @group credit
     * @group payment
     * @group onhold
     * @group resume
     * @group file
     * @group message
     * @depends testCreditCheck
     */
    public function testOrder($uuid)
    {
        // echo "Running test order with uuid: {$uuid}\n";
        $order_id = floor(time() * (rand(0,1000)/100*10));
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
     * @depends testOrder
     */
    public function testStatus($order_id)
    {
        
        $status = new StatusRequest();
        $status->addInvoice(new Invoice(['workflownumber'=> 1, 'invoicenumber' => $order_id]));
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
     * @depends testOrder
     */
    public function testWorkflowStart($order_id)
    {
        $workflow = new WorkflowRequest();
        $workflow->addInvoice(new Invoice(['workflownumber'=> 1, 'invoicenumber' => $order_id]));
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
     * @depends testOrder
     */
    public function testCredit($order_id)
    {
        
        $credit = new CreditRequest();
        $credit->addInvoice(new Invoice(['workflownumber'=> 1, 'invoicenumber' => $order_id, 'creditamount' => 10.00, 'description' => 'credit test']));
        $response = $this->client->Credit($credit);
        $this->assertTrue(count($response->getInvoices()) >0);
    }
    
    /**
     * Request Payment test
     * 
     * @group payment
     * @depends testOrder
     */
    public function testPayment($order_id)
    {
        
        $payment = new PaymentRequest();
        $payment->addInvoice(new Invoice(['workflownumber'=> 1, 'invoicenumber' => $order_id, 'amount' => 10.00, 'description' => 'payment test']));
        $response = $this->client->Payment($payment);
        $this->assertTrue(count($response->getInvoices()) >0);
    }
        
    
    /**
     * Request Payment OnHold test
     * 
     * @group onhold
     * @depends testOrder
     */
    public function testPaymentOnHold($order_id)
    {
        $onHold = new Request\PaymentOnHoldRequest();
        $onHold->setWorkflowNumber(1)
            ->setInvoiceNumber($order_id)
            ->setDays(3);
        $response = $this->client->paymentOnHold($onHold);
        $this->assertEquals(200, $response->getCode());        
    }
        
    /**
     * Request Payment Resume test
     * 
     * @group resume
     * @depends testOrder
     */
    public function testPaymentResume($order_id)
    {
        $paymentResume = new Request\PaymentResumeRequest();
        $paymentResume->setWorkflowNumber(1)
            ->setInvoiceNumber($order_id);
        $response = $this->client->paymentResume($paymentResume);
        $this->assertEquals(200, $response->getCode());        
    }
        
        
    /**
     * Request File (PDF) test
     * 
     * @group file
     * @depends testOrder
     */
    public function testFile($order_id)
    {
        $fileRequest = new Request\FileRequest();
        $fileRequest->setWorkflowNumber(1)
            ->setInvoiceNumber($order_id);
        $response = $this->client->file($fileRequest);
        $this->assertNotNull($response->getFilename());
    }
        
    /**
     * Request Message test
     * 
     * @group message
     * @depends testOrder
     */
    public function testMessage($order_id)
    {
        $messageRequest = new Request\MessageRequest();
        $messageRequest->setWorkflowNumber(1)
            ->setInvoiceNumber($order_id)
            ->setMessage('UnitTest Message test 1234');
        $response = $this->client->message($messageRequest);
        $this->assertEquals(200, $response->getCode());        
    }
}
