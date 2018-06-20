<?php
require '../vendor/autoload.php';

use Avido\BillinkApiClient\BillinkClient;
use Avido\BillinkApiClient\Request\CreditCheckRequest;
use Avido\BillinkApiClient\Request\OrderRequest;
use Avido\BillinkApiClient\Request\StatusRequest;
use Avido\BillinkApiClient\Request\WorkflowRequest;
use Avido\BillinkApiClient\Request\CreditRequest;
use Avido\BillinkApiClient\Request\PaymentRequest;
use Avido\BillinkApiClient\Request\PaymentOnHoldRequest;
use Avido\BillinkApiClient\Request\PaymentResumeRequest;
use Avido\BillinkApiClient\Request\FileRequest;
use Avido\BillinkApiClient\Request\MessageRequest;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
  
    Billink API Example

    NOTE! 
    This code is just an example.
    You should NOT use this for a production environment!
 
    @package     billink-api-php-client
    @copyright   Avido
    @see https://test.billink.nl/
 * 
 */

// GLOBAL CONFIGURATION
$username = "apitest";
$client_id = "d108a0f1bc5bc4618f150fa95cd6dc537bd774f0";

$view = isset($_GET['v']) ? $_GET['v'] : '';

// init example class
$billink = new billink($username, $client_id);


switch ($view) {
    case 'runCreditCheck':
        $billink->runCreditCheck();
        break;
    case 'requestOrder':
        $billink->renderRequestOrder();
        break;
    case 'runRequestOrder':
        $billink->runRequestOrder();
        break;
    case 'requestStatusOrder':
        $billink->runRequestOrderStatus();
        break;
    case 'startWorkflow':
        $billink->startWorkflow();
        break;
    case 'orderCredit':
        $billink->orderCredit();
        break;
    case 'orderPayment':
        $billink->orderPayment();
        break;
    case 'orderHold':
        $billink->orderHold();
        break;
    case 'orderResume':
        $billink->orderResume();
        break;
    case 'orderFile':
        $billink->orderFile();
        break;
    case 'orderMessage':
        $billink->orderMessage();
        break;
    default:
        $billink->renderCreditCheck();
}

class billink 
{
    private $client = null;
    private $twig = null;
    // logger 
    private $logfile = null;
    
    public function __construct($username, $client_id)
    {
        $loader = new Twig_Loader_Filesystem(dirname(__FILE__) . '/views');
        $this->twig = new Twig_Environment($loader);
        
        // set log handler
        $logfile = dirname(__FILE__) . "/logs/billink.log";
        $handler = new StreamHandler($logfile, LOGGER::DEBUG);
        $this->client = new BillinkClient($username, $client_id, $handler);
        $this->client->setTestMode(true);
    }
    
    public function renderCreditCheck()
    {
//        $template = $twig->load('views/index.php');
        echo $this->twig->render('creditcheck-form.html', []);
    }
    
    public function renderRequestOrder()
    {
        $uuid = isset($_GET['uuid']) ? $_GET['uuid'] : '';
        $orderamount = isset($_GET['orderamount']) ? $_GET['orderamount'] : 0;
        $workflownumber = isset($_GET['workflownumber']) ? $_GET['workflownumber'] : 0;
        $email = isset($_GET['email']) ? $_GET['email'] : '';
        echo $this->twig->render('request-order-form.html', [
            'uuid' => $uuid, 
            'ordernumber' => time(), 
            'date' => date('d-m-Y'), 
            'orderamount' => $orderamount,
            'workflownumber' => $workflownumber,
            'email' => $email
        ]);
    }
    
    public function runCreditCheck()
    {
        $creditCheckRequest = new CreditCheckRequest();
        $creditCheckRequest->setType($this->getPost('type'))
            ->setCompanyname($this->getPost('companyname'))
            ->setChamberofcommerce($this->getPost('chamberofcommerce'))
            ->setWorkflownumber($this->getPost('workflownumber'))
            ->setFirstname($this->getPost('firstname'))
            ->setLastname($this->getPost('lastname'))
            ->setInitials($this->getPost('initials'))
            ->setHousenumber($this->getPost('housenumber'))
            ->setHouseextension($this->getPost('houseextension'))
            ->setPostalcode($this->getPost('postalcode'))
            ->setPhonenumber($this->getPost('phonenumber'))
            ->setBirthdate($this->getPost('birthdate'))
            ->setEmail($this->getPost('email'))
            ->setOrderamount($this->getPost('orderamount'))
            ->setIp($this->getPost('ip'))
            ->setBackdoor($this->getPost('backdoor'));
        try {
            $response = $this->client->check($creditCheckRequest);
            echo $this->twig->render('creditcheck-response.html', [
                'code' => $response->getCode(),
                'description' => $response->getDescription(),
                'uuid' => $response->getUuid(),
                'orderamount' => $this->getPost('orderamount'),
                'email' => $this->getPost('email'),
                'workflownumber' => $this->getPost('workflownumber'),
                'request' => $this->prettyPrint($creditCheckRequest->toXml())
            ]);
        } catch (\Exception $e) {
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($creditCheckRequest->toXml())]);
        }
    }
    
    public function runRequestOrder()
    {
        $orderRequest = new OrderRequest();
        $orderRequest->setCompanyname($this->getPost('companyname'))
            ->setChamberofcommerce($this->getPost('chamberofcommerce'))
            ->setWorkflownumber($this->getPost('workflownumber'))
            ->setOrderNumber($this->getPost('ordernumber'))   // <!---
            ->setDate($this->getPost('date')) // <---
            ->setType($this->getPost('type'))
            ->setFirstname($this->getPost('firstname'))
            ->setLastname($this->getPost('lastname'))
            ->setInitials($this->getPost('initials'))
            ->setSex($this->getPost('sex'))
            ->setBirthdate($this->getPost('birthdate'))
            ->setStreet($this->getPost('street'))
            ->setHousenumber($this->getPost('housenumber'))
            ->setHouseextension($this->getPost('houseextension'))
            ->setPostalcode($this->getPost('postalcode'))
            ->setCountryCode($this->getPost('countrycode'))
            ->setCity($this->getPost('city'))
            ->setPhonenumber($this->getPost('phonenumber'))
            ->setEmail($this->getPost('email'))
            ->setEmail2($this->getPost('email2'))
            ->setIp($this->getPost('ip'))
            ->setAdditionalText($this->getPost('additionaltext'))
            ->setTrackAndTrace($this->getPost('trackandtrace'))
            ->setVatnumber($this->getPost('vatnumber'))
            ->setDebtorNumber($this->getPost('debtornumber'))
            ->setCheckUuid($this->getPost('checkuuid'))
            ->setOrderItems($this->getPost('item'));
        try {
            $response = $this->client->simpleOrder($orderRequest);
            echo $this->twig->render('order-request-response.html', [
                'code' => $response->getCode(),
                'description' => $response->getDescription(),
                'invoicenumber' => $this->getPost('ordernumber'),
                'workflownumber' => $this->getPost('workflownumber'),
                'request' => $this->prettyPrint($orderRequest->toXml())
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($orderRequest->toXml())]);
        }
    }
    
    public function runRequestOrderStatus()
    {
        $invoicenumber = isset($_REQUEST['invoicenumber']) ? $_REQUEST['invoicenumber'] : null;
        $workflownumber = isset($_REQUEST['workflownumber']) ? $_REQUEST['workflownumber'] : null;
        $statusRequest = new StatusRequest();
        $statusRequest->setInvoices([
            ['workflownumber' => $workflownumber, 'invoicenumber' => $invoicenumber]
        ]);
        try {
            if (!is_null($invoicenumber) && !is_null($workflownumber)) {
                $response = $this->client->status($statusRequest);
            } else {
                $response = null;
            }
            echo $this->twig->render('status-request-response.html', [
                'invoicenumber' => $invoicenumber,
                'workflownumber' => $workflownumber,
                'code' => !is_null($response) ? $response->getCode() : null,
                'invoices' => !is_null($response) ? $response->getInvoices() : null,
                'request' => !is_null($response) ? $this->prettyPrint($statusRequest->toXml()) : null
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($statusRequest->toXml())]);
        }
    }
    
    public function startWorkflow()
    {
        $invoicenumber = isset($_REQUEST['invoicenumber']) ? $_REQUEST['invoicenumber'] : null;
        $workflownumber = isset($_REQUEST['workflownumber']) ? $_REQUEST['workflownumber'] : null;
        $workflowRequest = new WorkflowRequest();
        $workflowRequest->setInvoices([
            ['workflownumber' => $workflownumber, 'invoicenumber' => $invoicenumber]
        ]);
        try {
            if (!is_null($invoicenumber) && !is_null($workflownumber)) {
                $response = $this->client->startWorkflow($workflowRequest);
            } else {
                $response = null;
            }
            echo $this->twig->render('start-workflow-request-response.html', [
                'invoicenumber' => $invoicenumber,
                'workflownumber' => $workflownumber,
                'code' => !is_null($response) ? $response->getCode() : null,
                'invoices' => !is_null($response) ? $response->getInvoices() : null,
                'request' => !is_null($response) ? $this->prettyPrint($workflowRequest->toXml()) : null
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($workflowRequest->toXml())]);
        }
    }
    
    public function orderCredit()
    {
        $invoicenumber = isset($_POST['invoicenumber']) ? $_POST['invoicenumber'] : null;
        $amount = isset($_POST['amount']) ? $_REQUEST['amount'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        
        if (!is_null($invoicenumber) && !is_null($amount) && !is_null($description)) {
            $creditRequest = new CreditRequest();
            $creditRequest->setInvoices([
                ['invoicenumber' => $invoicenumber, 'creditamount' => $amount, 'description' => $description]
            ]);
        } else {
            $creditRequest = null;
        }
        try {
            if (!is_null($creditRequest)) {
                $response = $this->client->credit($creditRequest);
            } else {
                $response = null;
            }
            echo $this->twig->render('order-credit-request-response.html', [
                'invoicenumber' => $invoicenumber,
                'amount' => $amount,
                'description' => $description,
                'code' => !is_null($response) ? $response->getCode() : null,
                'invoices' => !is_null($response) ? $response->getInvoices() : null,
                'request' => !is_null($response) ? $this->prettyPrint($creditRequest->toXml()) : null
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($creditRequest->toXml())]);
        }
    }
    
    public function orderPayment()
    {
        $invoicenumber = isset($_POST['invoicenumber']) ? $_POST['invoicenumber'] : null;
        $amount = isset($_POST['amount']) ? $_REQUEST['amount'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        
        if (!is_null($invoicenumber) && !is_null($amount) && !is_null($description)) {
            $paymentRequest = new PaymentRequest();
            $paymentRequest->setInvoices([
                ['invoicenumber' => $invoicenumber, 'amount' => $amount, 'description' => $description]
            ]);
        } else {
            $paymentRequest = null;
        }
        try {
            if (!is_null($paymentRequest)) {
                $response = $this->client->payment($paymentRequest);
            } else {
                $response = null;
            }
            echo $this->twig->render('order-payment-request-response.html', [
                'invoicenumber' => $invoicenumber,
                'amount' => $amount,
                'description' => $description,
                'code' => !is_null($response) ? $response->getCode() : null,
                'invoices' => !is_null($response) ? $response->getInvoices() : null,
                'request' => !is_null($response) ? $this->prettyPrint($paymentRequest->toXml()) : null
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($paymentRequest->toXml())]);
        }
    }
    
    public function orderHold()
    {
        $invoicenumber = isset($_REQUEST['invoicenumber']) ? $_REQUEST['invoicenumber'] : null;
        $workflownumber = isset($_REQUEST['workflownumber']) ? $_REQUEST['workflownumber'] : null;
        $days = isset($_POST['days']) ? $_REQUEST['days'] : null;
        
        if (!is_null($invoicenumber) && !is_null($workflownumber) && !is_null($days)) {
            $paymentOnHoldRequest = new PaymentOnHoldRequest();
            $paymentOnHoldRequest->setInvoiceNumber($invoicenumber)
                ->setWorkflowNumber($workflownumber)
                ->setDays($days);
        } else {
            $paymentOnHoldRequest = null;
        }
        try {
            if (!is_null($paymentOnHoldRequest)) {
                $response = $this->client->paymentOnHold($paymentOnHoldRequest);
            } else {
                $response = null;
            }
            echo $this->twig->render('order-payment-onhold-request-response.html', [
                'invoicenumber' => $invoicenumber,
                'workflownumber' => $workflownumber,
                'days' => $days,
                'code' => !is_null($response) ? $response->getCode() : null,
                'description' => !is_null($response) ? $response->getDescription() : null,
                'request' => !is_null($response) ? $this->prettyPrint($paymentOnHoldRequest->toXml()) : null
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($paymentOnHoldRequest->toXml())]);
        }
    }
    
    
    public function orderResume()
    {
        $invoicenumber = isset($_REQUEST['invoicenumber']) ? $_REQUEST['invoicenumber'] : null;
        $workflownumber = isset($_REQUEST['workflownumber']) ? $_REQUEST['workflownumber'] : null;
        
        if (!is_null($invoicenumber) && !is_null($workflownumber)) {
            $paymentResumeRequest = new PaymentResumeRequest();
            $paymentResumeRequest->setInvoiceNumber($invoicenumber)
                ->setWorkflowNumber($workflownumber);
        } else {
            $paymentResumeRequest = null;
        }
        try {
            if (!is_null($paymentResumeRequest)) {
                $response = $this->client->paymentResume($paymentResumeRequest);
            } else {
                $response = null;
            }
            echo $this->twig->render('order-payment-resume-request-response.html', [
                'invoicenumber' => $invoicenumber,
                'workflownumber' => $workflownumber,
                'code' => !is_null($response) ? $response->getCode() : null,
                'description' => !is_null($response) ? $response->getDescription() : null,
                'request' => !is_null($response) ? $this->prettyPrint($paymentResumeRequest->toXml()) : null
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($paymentResumeRequest->toXml())]);
        }
    }
    
    public function orderFile()
    {
        $invoicenumber = isset($_REQUEST['invoicenumber']) ? $_REQUEST['invoicenumber'] : null;
        $workflownumber = isset($_REQUEST['workflownumber']) ? $_REQUEST['workflownumber'] : null;
        
        if (!is_null($invoicenumber) && !is_null($workflownumber)) {
            $fileRequest = new FileRequest();
            $fileRequest->setInvoiceNumber($invoicenumber)
                ->setWorkflowNumber($workflownumber);
        } else {
            $fileRequest = null;
        }
        try {
            if (!is_null($fileRequest)) {
                $response = $this->client->file($fileRequest);
            } else {
                $response = null;
            }
            echo $this->twig->render('order-file-request-response.html', [
                'invoicenumber' => $invoicenumber,
                'workflownumber' => $workflownumber,
                'code' => !is_null($response) ? $response->getCode() : null,
                'description' => !is_null($response) ? $response->getDescription() : null,
                'filename' => !is_null($response) ? $response->getFilename() : null,
                'request' => !is_null($response) ? $this->prettyPrint($fileRequest->toXml()) : null
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($fileRequest->toXml())]);
        }
    }
    
    public function orderMessage()
    {
        $invoicenumber = isset($_REQUEST['invoicenumber']) ? $_REQUEST['invoicenumber'] : null;
        $workflownumber = isset($_REQUEST['workflownumber']) ? $_REQUEST['workflownumber'] : null;
        $message = isset($_POST['message']) ? $_POST['message'] : null;
        
        if (!is_null($invoicenumber) && !is_null($workflownumber) && !is_null($message)) {
            $messageRequest = new MessageRequest();
            $messageRequest->setInvoiceNumber($invoicenumber)
                ->setWorkflowNumber($workflownumber)
                ->setMessage($message);
        } else {
            $messageRequest = null;
        }
        try {
            if (!is_null($messageRequest)) {
                $response = $this->client->message($messageRequest);
            } else {
                $response = null;
            }
            echo $this->twig->render('order-message-request-response.html', [
                'invoicenumber' => $invoicenumber,
                'workflownumber' => $workflownumber,
                'message' => $message,
                'code' => !is_null($response) ? $response->getCode() : null,
                'description' => !is_null($response) ? $response->getDescription() : null,
                'request' => !is_null($response) ? $this->prettyPrint($messageRequest->toXml()) : null
            ]);
        } catch (\Exception $e) {
            // pretty print xml
            echo $this->twig->render('api-response-error.html', ['error' => $e->getMessage(), 'request' => $this->prettyPrint($messageRequest->toXml())]);
        }
    }
    
    private function prettyPrint($xml)
    {
        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);
        return $dom->saveXML();    
    }
    
    private function getPost($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : '';
    }
}