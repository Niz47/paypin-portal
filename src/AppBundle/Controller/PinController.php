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
        $neighborhoodsRepository = $em->getRepository("AppBundle:Agent");
        
        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $neighborhoods = $neighborhoodsRepository->createQueryBuilder("q")
            ->where("q.serviceProvider = :spid")
            ->setParameter("spid", $request->query->get("id"))
            ->getQuery()
            ->getResult();
        var_dump($neighborhoods);die();
        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($neighborhoods as $neighborhood){
            $responseArray[] = array(
                "id" => $neighborhood->getId(),
                "name" => $neighborhood->getName()
            );
        }
        
        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }


    /**
     * @Route("/aa", name="aa")
     */
    public function createAction(Request $request)
    {
        // $pin = new Pin();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PinType::class, new Pin());
// var_dump("test");die();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Pin updated!');
        }

        return $this->render('aa.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/tt", name="homepage")
     */
    public function indexAction(Request $request)
    {
            // get Login user roles
            $roles = $this->getUser()->getRoles();
            if ($this->isAdmin($roles)) {
                # code... for admin 
                $form = $this->getAdminForm();
                $form -> handleRequest($request);
            } else {
                $form = $this->getUserForm();
                $form -> handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $apiResponse = $this->checkPinUserAction($form['pin_code']->getData());
                    var_dump($apiResponse);die();
                    return $this->redirectToRoute('todo_list');
                }
            }
        /*if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $todo->setName($form['name']->getData());
            $todo->setCategory($form['category']->getData());
            $todo->setDescription($form['description']->getData());
            $todo->setPriority($form['priority']->getData());
            $todo->setDueDate($form['dueDate']->getData());
            $todo->setCreateDate(new\DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            $this->addflash('notice', 'Todo Added!');
            return $this->redirectToRoute('todo_list');
        }*/
         return $this->render('pin/index.html.twig', array('form'=>$form->createView()));
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
    public function getAdminForm()
    {
        $form = $this->createFormBuilder()
                    ->add('aaa', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                     ->add('serviceProvider', 'entity', array(
                            'label' => 'paypin_admin.agent.service_provider',
                            'class' => 'AppBundle\Entity\ServiceProvider',
                            'choice_label' => 'serviceProviderName',
                        ))
                    // ->add('ville')
                    /*->addEventListener(
                        FormEvents::PRE_SET_DATA,
                        function (FormEvent $event) use ($formModifier) {
                            $data = $event->getData();
                            $formModifier($event->getForm(), $data->getAgents());
                        }
                    )
                    ->get('serviceProvider')->addEventListener(
                        FormEvents::POST_SUBMIT,
                        function (FormEvent $event) use ($formModifier) {
                            $serviceProvider = $event->getForm()->getData();
                            $formModifier($event->getForm()->getParent(), $serviceProvider);
                        }
                    )*/
                    /*->add('agent', ChoiceType::class, array(
                            'disabled'    => true,
                        ))*/
                    ->add('save', SubmitType::class, array('label'=>'Check', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                    ->getForm();
                    /*$formModifier = function (FormInterface $form, ServiceProvider $serviceProvider = null) {
                            $villes = null === $serviceProvider ? array() : $serviceProvider->getAgents();
                            $form->add('ville', EntityType::class, array(
                                'class' => 'AppBundle:Agent',
                                'placeholder' => '',
                                'choices' => $villes,
                                'label' => 'Ville *',
                                'label_attr' => [
                                    "class" => "smaller lighter blue",
                                    "style" => "font-size: 21px;",
                                ],
                                // 'choice_label'  => 'nom',
                                'multiple'      => false,
                            ));
                        };
                    $form->addEventListener(
                        FormEvents::PRE_SET_DATA,
                        function (FormEvent $event) use ($formModifier) {
                            $data = $event->getData();
                            $formModifier($event->getForm(), $data->getVille());
                        }
                    );
                    $form->get('serviceProvider')->addEventListener(
                        FormEvents::POST_SUBMIT,
                        function (FormEvent $event) use ($formModifier) {
                            $serviceProvider = $event->getForm()->getData();
                            $formModifier($event->getForm()->getParent(), $serviceProvider);
                        }
                    );*/
        /*$form = $this->createFormBuilder()
                    ->add('aaa', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                    ->add('serviceProvider', 'entity', array(
                            'label' => 'paypin_admin.agent.service_provider',
                            'class' => 'AppBundle\Entity\ServiceProvider',
                            'choice_label' => 'serviceProviderName',
                        ))
                    ->add('agent', ChoiceType::class, array(
                            'disabled'    => true,
                        ))
                    ->add('save', SubmitType::class, array('label'=>'Check', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                    ->getForm();*/
        return $form;
    }

    public function isAdmin($roles)
    {
        return in_array($this->container->getParameter('check_pin_admin_access'), $roles);
    }
}