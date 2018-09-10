<?php

/**
 * Admin class for Agent management
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\ServiceProvider;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class AgentAdmin
 * @package AppBundle\Admin
 */
class AgentAdmin extends BaseAdmin
{

    // Fields to be shown on create/edit forms
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $allowedRoles = array_flip($container->getParameter('portal_allowed_user_create_roles'));
        $isCreate = $this->subject->getId() === null;

        $formMapper
            ->add('agentId', 'number', ['label' => 'paypin_admin.agent.agent_id'])
            ->add('apiKey', 'text', ['label' => 'paypin_admin.agent.api_key'])
            ->add('serviceProvider', 'entity', array(
                    'label' => 'paypin_admin.agent.service_provider',
                    'class' => 'AppBundle\Entity\ServiceProvider',
                    'choice_label' => 'serviceProviderName',
                ))
            ->add('user', 'entity', array(
                    'label' => 'paypin_admin.agent.user',
                    'class' => 'AppBundle\Entity\User',
                    'choice_label' => 'userName',
                ))
            ->add('status', 'checkbox', ['label' => 'paypin_admin.agent.enabled', 'required' => false]);
            /*->add('user', EntityType::class, array(
                'label' => 'paypin_admin.agent.user',
                'class' => User::class,
                'choice_label' => function ($user) {
                    return $user->getUserName();
                }
            ));*/
    }

    /**
     * Fields to be shown on filter forms
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $allowedRoles = $container->getParameter('portal_allowed_user_create_roles');
        $datagridMapper
            ->add('id')
            ->add('agentId')
            ->add('apiKey');
    }

    /**
     * Fields to be shown on lists
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $allowedRoles = $container->getParameter('portal_allowed_user_create_roles');
        $listMapper
            ->addIdentifier('id')
            ->add('agentId')
            ->add('apiKey')
            ->add('serviceProvider.serviceProviderName', null, ['label' => 'paypin_admin.serviceprovider.sp_name'])
            ->add('user.username', null, ['label' => 'paypin_admin.user.username'])
            ->add(
                'createdDateTime',
                'datetime',
                ['template' => 'AppBundle:Admin:date_mmt_format_list.html.twig']
            )
            ->add(
                'updatedDateTime',
                'datetime',
                ['template' => 'AppBundle:Admin:date_mmt_format_list.html.twig']
            )
            ->add('status')
            ->add(
                '_action',
                'actions',
                ['actions' => ['show' => [], 'edit' => []]]
            );
    }

    /**
     * Fields to be shown on show view
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $allowedRoles = $container->getParameter('portal_allowed_user_create_roles');
        $showMapper
            ->add('id')
            ->add('agentId')
            ->add('apiKey')
            // ->add('serviceProvider.serviceProviderName', null, ['label' => 'paypin_admin.serviceprovider.sp_name'])
            ->add('user.userName', null, ['label' => 'paypin_admin.user.username'])
            ->add(
                'createdDateTime',
                'datetime',
                ['template' => 'AppBundle:Admin:date_mmt_format_show.html.twig']
            )
            ->add(
                'updatedDateTime',
                'datetime',
                ['template' => 'AppBundle:Admin:date_mmt_format_show.html.twig']
            )
            ->add('status');
    }

    /**
     * Fields present in export
     * @return array
     */
    public function getExportFields()
    {
        return [
            'id',
            'agentId',
            'apiKey',
            'serviceProvider.serviceProviderName',
            'user.userName',
            'status',
            'createdDateTime',
            'updatedDateTime',
        ];
    }

    /**
     * Routes to add or remove
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }
}
