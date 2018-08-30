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
        $builder->add('serviceProviderId', 'entity', array(
                    'label' => 'paypin_admin.agent.service_provider',
                    'class' => 'AppBundle\Entity\ServiceProvider',
                    'choice_label' => 'serviceProviderName',
                ));

        // Test Entity Manager
        /*$repository = $this->entityManager->getRepository(ServiceProvider::class);
        $user = $repository->find(1);
        var_dump($user->getServiceProviderName());die();*/


        // 3. Add 2 event listeners for the form
        /*$builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));*/
    }
    
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        
        // Search for selected City and convert it into an Entity
        /*$form->add('serviceProvider', 'entity', array(
                    'label' => 'paypin_admin.agent.service_provider',
                    'class' => 'AppBundle\Entity\ServiceProvider',
                    'choice_label' => 'serviceProviderName',
                ));*/
        $city = $this->entityManager->getRepository('AppBundle:ServiceProvider')->find($data['city']);
        
        $this->addElentityManagerents($form, $city);
    }

    function onPreSetData(FormEvent $event) {
        $person = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always entityManagerpty
        $service_provider = $person->getAgentId() ? $person->getAgentId() : null;
        
        $this->addElentityManagerents($form, $service_provider);
    }

    protected function addElentityManagerents(FormInterface $form, ServiceProvider $service_provider = null) {
        // 4. Add the province elentityManagerent
        $form->add('service_provider', 'entity', array(
            'required' => true,
            'placeholder' => 'Select a service_provider...',
            'class' => 'AppBundle\Entity\ServiceProvider',
            'choice_label' => 'serviceProviderName',
        ));
        
        // Neighborhoods entityManagerpty, unless there is a selected City (Edit View)
        $agents = array();
        
        // If there is a city stored in the Person entity, load the neighborhoods of it
        if ($service_provider) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoNeighborhood = $this->entityManager->getRepository('AppBundle:Agent');
            
            $agents = $repoNeighborhood->createQueryBuilder("q")
                ->where("q.service_provider = :spid")
                ->setParameter("spid", $service_provider->getAgents()->getAgentId())
                ->getQuery()
                ->getResult();
        }
        var_dump($service_provider);die();
        // Add the Neighborhoods field with the properly data
        $form->add('agent', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Select a Service Provider first ...',
            'class' => 'AppBundle:Agent',
            'choices' => $agents
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
