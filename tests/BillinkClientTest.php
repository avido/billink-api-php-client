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
            ->setAction('check')
            ->setFirstname('Voornaam')
            ->setLastname('Achternaam')
            ->setInitials('A')
            ->setHousenumber(1)
            ->setPostalcode('1111AA')
            ->setPhonenumber('0123456789')
            ->setBirthdate('01-01-1985')
            ->setEmail('test@123.nl')
            ->setOrderamount('120.09')
            ->setIp('127.0.0.1');
        $this->client->check($check);
    }
}