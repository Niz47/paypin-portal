<?php
namespace AppBundle\Controller;
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\User;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Pin;
use AppBundle\Entity\ServiceProvider;
use AppBundle\Services\PinManager;
use AppBundle\Repository\ServiceProviderRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\Type\PinType;

class PinController extends AbstractController
{
    /**
     * Returns a JSON string with the neighborhoods of the City with the providen id.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function listNeighborhoodsOfCityAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();

        // Search the agents that belongs to the service provider with the given id as GET parameter "serviceProviderId"
        $serviceProviderId = $request->query->get("serviceProviderId");
        $agentRepo = $em->getRepository(Agent::class);
        $agents = $agentRepo->findByServiceProvider($serviceProviderId);
        
        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($agents as $agent){
            $responseArray[] = array(
                "id" => $agent->getId(),
                "name" => $agent->getAgentId()
            );
        }
        
        // Return array with structure of the agents of the providen service provider id
        return new JsonResponse($responseArray);
    }


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // get Login user roles
        $roles = $this->getUser()->getRoles();
        if ($this->isAdmin($roles)) 
        {
            # code... for admin 
            $form = $this->createForm(PinType::class, new Pin());

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash('success', 'Pin updated!');
            }

            return $this->render('new.html.twig', ['form' => $form->createView()]);

        } else {

            $form = $this->getUserForm();
            $form -> handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $apiResponse = $this->checkPinUserAction($form['pin_code']->getData());
                var_dump($apiResponse);die();
            }
            
            return $this->render('pin/index.html.twig', array('form'=>$form->createView()));
        }
        // return $this->render('pin/index.html.twig');
    }

    public function checkPinUserAction($pinCode)
    {
        $user_id = $this->getUser()->getId();
        // check Login user role
        $roles = $this->getUser()->getRoles();
        if (in_array($this->container->getParameter('check_pin_admin_access'), $roles)) {
            var_dump($roles);
        } else {
            $uRepository = $this->getDoctrine()->getRepository(User::class);
            $aRepository = $this->getDoctrine()->getRepository(Agent::class);
            $agentID = $uRepository->find($user_id)->getAgent()->getAgentId();
            $secretKey = $uRepository->find($user_id)->getAgent()->getApiKey();
            $agent_id = $uRepository->find($user_id)->getAgent()->getId();
            $serviceProviderID = $aRepository->find($agent_id)->getServiceProvider()->getServiceProviderId();
        }
        // $pinCode = '145675282726186';
        //  connect Pin Manager service
        $pinManager = $this->get('paypin.pin_manager');
        $apiResponse = $pinManager->checkPinStatus($agentID, $secretKey, $serviceProviderID, $pinCode);
        var_dump($apiResponse);die();
        return $this->render('pin/index.html.twig');
    }

    public function getUserForm()
    {
        $form = $this->createFormBuilder()
                    ->add('pin_code', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                    ->add('save', SubmitType::class, array('label'=>'Check', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                    ->getForm();
        return $form;
    }

    public function isAdmin($roles)
    {
        return in_array($this->container->getParameter('check_pin_admin_access'), $roles);
    }
}