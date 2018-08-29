<?php

namespace AppBundle\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Agent;
use AppBundle\Services\PinManager;

class PinController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('pin/index.html.twig');

        // replace this example code with whatever you need
        /*return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);*/
    }

    /**
     * @Route("/check-pin", name="check-pin")
     */
    public function checkPinAction(Request $request)
    {
        $serviceProviderID = '1000021369';
        $agentID = '100002149';
        $secretKey = 'NLLPUPEKFJ0UBET9';
        $pinCode = '145675282726186';

        //  connect Pin Manager service
        $pinManager = $this->get('paypin.pin_manager');
        $apiResponse = $pinManager->checkPinStatus($agentID, $secretKey, $serviceProviderID, $pinCode);
        var_dump($apiResponse);die();
        return $this->render('pin/index.html.twig');
    }
}
