<?php

/**
 * Admin class for user management
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class UserAdmin
 * @package AppBundle\Admin
 */
class UserAdmin extends BaseAdmin
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
            ->add('email', 'text', ['label' => 'mytel_admin.user.email'])
            ->add('username', 'text', ['label' => 'mytel_admin.user.username'])
            ->add(
                'plainPassword',
                'password',
                ['label' => 'mytel_admin.user.password', 'required' => $isCreate]
            )
            ->add(
                'roles',
                'choice',
                ['label' => 'mytel_admin.user.roles', 'choices' => $allowedRoles, 'multiple' => true]
            )
            ->add('enabled', 'checkbox', ['label' => 'mytel_admin.user.enabled', 'required' => false]);
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
            ->add('username')
            ->add('email')
            ->add('roles', 'doctrine_orm_choice', [], 'choice', ['choices' => $allowedRoles, 'multiple' => true])
            ->add('enabled');
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
            ->add('username')
            ->add('email')
            ->add('roles', 'choice', ['choices' => $allowedRoles, 'multiple' => true])
            ->add('enabled')
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
            ->add('username')
            ->add('email')
            ->add('roles', 'choice', ['choices' => $allowedRoles, 'multiple' => true])
            ->add('enabled');
    }

    /**
     * Fields present in export
     * @return array
     */
    public function getExportFields()
    {
        return [
            'id',
            'username',
            'email',
            'roles',
            'enabled',
        ];
    }

    /**
     * @param mixed $user
     */
    public function prePersist($user)
    {
        $this->setUserFields($user);
        parent::prePersist($user);
    }

    /**
     * @param mixed $user
     */
    public function preUpdate($user)
    {
        $this->setUserFields($user);
        parent::preUpdate($user);
    }

    /**
     * @param $user
     */
    protected function setUserFields($user)
    {
        $userManager = $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager');
        $userManager->updateCanonicalFields($user);
        $userManager->updatePassword($user);
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
