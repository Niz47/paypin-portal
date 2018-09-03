<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

// Your Entity
use AppBundle\Entity\ServiceProvider;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Pin;
use AppBundle\Entity\User;

class PinType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // 2. RentityManagerove the dependent select from the original buildForm as this will be
        // dinamically added later and the trigger as well
        $builder->add('pinCode');

        // Test Agents
        /*$agentRepo = $this->entityManager->getRepository(Agent::class);
        $agents = $agentRepo->findByServiceProvider(1);
        var_dump($agents[0]->getApiKey());die();*/

        
        /*$builder->add('serviceProviderId', 'entity', array(
                    'label' => 'paypin_admin.agent.service_provider',
                    'class' => 'AppBundle\Entity\ServiceProvider',
                    'choice_label' => 'serviceProviderName',
                ));*/

        // Test Entity Manager
        /*$repository = $this->entityManager->getRepository(ServiceProvider::class);
        $user = $repository->find(1);
        var_dump($user->getServiceProviderName());die();*/

        // 3. Add 2 event listeners for the form
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }
    
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $pin = $event->getData();
        
        // Search for selected City and convert it into an Entity
        $serviceProvider = $this->entityManager->getRepository(ServiceProvider::class)->find($pin['serviceProviderId']);
        
        $this->addElements($form, $serviceProvider);
    }

    function onPreSetData(FormEvent $event) {
        $pin = $event->getData();
        $form = $event->getForm();

        $serviceProvider = $pin->getServiceProviderId() ? $this->entityManager->getRepository(ServiceProvider::class)->find($pin['serviceProviderId']) : null;
        
        $this->addElements($form, $serviceProvider);
    }

    protected function addElements(FormInterface $form, ServiceProvider $serviceProvider = null) {
        // 4. Add the province element
        $form->add('serviceProviderId', 'entity', array(
                    'required' => true,
                    // 'label' => 'paypin_admin.agent.service_provider',
                    'placeholder' => 'Select Service Provider Name ...',
                    'class' => 'AppBundle\Entity\ServiceProvider',
                    'choice_label' => 'serviceProviderName',
                    'attr' => ['class' => 'wrap-input100 validate-input input-margin'],
                ));
        
        $agents = array();
        
        // If there is a service provider value stored in the pin entity, load the agents of it
        if ($serviceProvider) {
            // Fetch agents of the service provider if there's a selected service provider
            $agentRepo = $this->entityManager->getRepository(Agent::class);
            $agents = $agentRepo->findByServiceProvider($serviceProvider->getId());
        }
        
        // Add the agents field with the properly data

        /*$form->add('agentId', 'entity', array(
                    'required' => true,
                    'label' => 'paypin_admin.agent',
                    'placeholder' => 'Select a Agent ...',
                    'class' => 'AppBundle\Entity\Agent',
                    'choice_label' => 'agentId',
                ));*/

        $form->add('agentId', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Select Agent Name ...',
            'class' => 'AppBundle:Agent',
            'choices' => $agents,
            'attr' => ['class' => 'wrap-input100 validate-input input-margin'],
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // $resolver->setRequired('entityManager');
        $resolver->setDefaults(array(
            'data_class' => Pin::class,
        ));
    }
}
