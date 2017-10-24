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
use Avido\BillinkApiClient\Request\CreditCheck;
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
        $username = getenv('PHP_USERNAME');
        $client_id = getenv('PHP_CLIENTID');
        // test with logger
#        $handler = new StreamHandler(dirname(__FILE__) . '/../apiClient.log', \Monolog\Logger::DEBUG);
        $this->client = new BillinkClient($username, $client_id /*, $handler*/);
        $this->client->setTestMode(true);
    }

    /**
     * Base code simple tests to lower Crap Index
     */

    /**
     * Test BaseEntity getData
     * @group base
     */
    public function testCreditCheck()
    {
        $check = new CreditCheck();
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
    }
    
    public function testCreditCheckBillinkClientException()
    {
        $this->expectException(BillinkClientException::class);
        $check = new CreditCheck();
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
        $check = new CreditCheck();
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
    
}