<?php

/**
 * Admin class for ServiceProvider management
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class ServiceProviderAdmin
 * @package AppBundle\Admin
 */
class ServiceProviderAdmin extends BaseAdmin
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
            ->add('serviceProviderId', 'number', ['label' => 'paypin_admin.serviceprovider.sp_id'])
            ->add('serviceProviderName', 'text', ['label' => 'paypin_admin.serviceprovider.sp_name']);
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
            ->add('serviceProviderId')
            ->add('serviceProviderName');
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
            ->add('serviceProviderId')
            ->add('serviceProviderName')
            ->add(
                'created_date_time',
                'datetime',
                ['template' => 'AppBundle:Admin:date_mmt_format_list.html.twig']
            )
            ->add(
                'updatedDateTime',
                'datetime',
                ['template' => 'AppBundle:Admin:date_mmt_format_list.html.twig']
            )
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
            ->add('serviceProviderId')
            ->add('serviceProviderName')
            ->add(
                'createdDateTime',
                'datetime',
                ['template' => 'AppBundle:Admin:date_mmt_format_show.html.twig']
            )
            ->add(
                'updatedDateTime',
                'datetime',
                ['template' => 'AppBundle:Admin:date_mmt_format_show.html.twig']
            );
    }

    /**
     * Fields present in export
     * @return array
     */
    public function getExportFields()
    {
        return [
            'id',
            'serviceProviderId',
            'serviceProviderName',
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
