<?php

namespace AppBundle\Services;

use AppBundle\Exception\APIException;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Class PinManager
 * @package AppBundle\Services
 */
class PinManager
{
    protected $url;
    protected $container;

    /**
     * PinManager constructor.
     * @param ContainerInterface $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->url = $container->getParameter('pay_pin_api_url');var_dump($this->url );die();
    }

    public function checkPinStatus($agentID, $secretKey, $serviceProviderID, $pinCode)
    {
        // Create the message Hash to prevent signature reuse
        $contentmd5 = encodeReqBody($pinCode);
        $contentType = 'application/json';

        // Get the time in UTC (critical to use UTC).
        $dateNow = new DateTime('now',new DateTimeZone('UTC'));
        $savedate = $dateNow->format('r');
        $dateNow = $dateNow->format('c');

        // Generate the Authorisation Code from the component parts
        $hash_string = $verb. "\n" . $contentmd5 . "\n" . $contentType . "\n" . $dateNow . "\n";
        echo "\nHASH STRING:\n" . $hash_string . "\n\n";

        $authCode = base64_encode(hash_hmac('sha1', $hash_string, $secretKey));
        echo "\nAUTHCODE:\n" . $authCode . "\n\n";

        // Build the HTTP Request Headers
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body),
            'Content-MD5: ' .$contentmd5,
            'Date: ' . $savedate,
            'Authorization: MAV ' . $serviceProviderID . ':' . $agentId . ':' . $authCode
        ));

        echo "\n\n" . $output = curl_exec($ch) . "\n\n";
    }

    public function encodeReqBody($pinCode)
    {
        $body = '{"Request":{"Vouchers":[{"amount":"", "serviceProviderTransactionID":"' . time() . '","voucherReferenceID":"' . $pinCode . '","callbackURL":"", "status":"", "serviceProviderName":"", "serviceDescription":""}]}}';
        return base64_encode(md5($body, true));
    }

    /**
     * Generate dummy response in case of avoiding api calls
     * @return array
     */
    public function generateDummyResponse()
    {
        // dummy response to be sent in case of mock api call
        return array(
            'success' => true,
            'result' => array(
                'status' => 'SUCCESS'
            ),
            'resultCode' => '200',
        );
    }
}
