<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Class PinManager
 * @package AppBundle\Services
 */
class PinManager
{
    protected $container;

    /**
     * PinManager constructor.
     * @param ContainerInterface $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function checkPinStatus($agentID, $secretKey, $serviceProviderID, $pinCode)
    {
        $body = '{
                        "Request":
                            {"Vouchers" : [{
                                                        "amount" : "", 
                                                        "serviceProviderTransactionID" : "' . time() . '",
                                                        "voucherReferenceID" : "' . $pinCode . '",
                                                        "callbackURL" : "", 
                                                        "status" : "", 
                                                        "serviceProviderName" : "", 
                                                        "serviceDescription" : ""
                                                }]
                            }
                    }';

        $url = $this->container->getParameter('pay_pin_api_url');

        return $this->sendRequest($body, $url, $agentID, $secretKey, $serviceProviderID);
    }

    public function sendRequest($body, $url, $agentID, $secretKey, $serviceProviderID)
    {
        $contentType = 'application/json';
        $verb        = 'GET';
        $savedate    = (new \DateTime())->format('r');
        // Create the message Hash to prevent signature reuse
        $contentmd5 = $this->encodeReqBody($body);
        $authCode = $this->hashAuthCode($contentmd5, $verb, $contentType, $secretKey);

        // Build the HTTP Request Headers
        $ch = curl_init($url);

        // set SSL false
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body),
            'Content-MD5: ' . $contentmd5,
            'Date: ' . $savedate,
            'Authorization: MAV ' . $serviceProviderID . ':' . $agentID . ':' . $authCode,
        ));

        $output = curl_exec($ch);
        return json_decode($output, true);
    }

    public function encodeReqBody($body)
    {
        return base64_encode(md5($body, true));
    }

    public function hashAuthCode($contentmd5, $verb, $contentType, $secretKey)
    {
        $dateNow     = (new \DateTime())->format('c');
        $hash_string = $verb . "\n" . $contentmd5 . "\n" . $contentType . "\n" . $dateNow . "\n";

        return base64_encode(hash_hmac('sha1', $hash_string, $secretKey));
    }

    /**
     * Generate dummy response in case of avoiding api calls
     * @return array
     */
    public function generateDummyResponse()
    {
        // dummy response to be sent in case of mock api call
        return array(
            'success'    => true,
            'result'     => array(
                'status' => 'SUCCESS',
            ),
            'resultCode' => '200',
        );
    }
}
