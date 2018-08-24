<?php

/**
 * Base admin class
 */

namespace AppBundle\Admin;

use AppBundle\DataSourceIterator\AppORMQuerySourceIterator;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class BaseAdmin extends AbstractAdmin
{

    /**
     * Add actions in the admin data grid based on the entity and permissions
     * @param ListMapper $listMapper
     * @param array $extraOperations
     */
    public function addActions(ListMapper $listMapper, array $extraOperations = array())
    {
        $securityContext = $this->getConfigurationPool()
            ->getContainer()
            ->get('security.authorization_checker');
        // actions allowed only for admin roles
        if ($securityContext->isGranted('ROLE_ADMIN')
            || $securityContext->isGranted('ROLE_SUPER_ADMIN')
        ) {
            $actions = array(
                'edit' => array('template' => 'AppBundle:Admin:conditional_edit.html.twig'),
                'delete' => array('template' => 'AppBundle:Admin:conditional_delete.html.twig'),
                'show' => array('template' => 'AppBundle:Admin:conditional_show.html.twig')
            );
            // add actions to the admin list
            $listMapper->add('_action', 'actions', array('actions' => $actions));
        }
    }

    /**
     * Function to get custom data source iterator to customize exports
     * @return AppORMQuerySourceIterator
     */
    public function getDataSourceIterator()
    {
        $datagrid = $this->getDatagrid();
        $datagrid->buildPager();
        $fields = $this->getExportFields();
        $query = $datagrid->getQuery();

        $query->select('DISTINCT ' . $query->getRootAlias());
        $query->setFirstResult(null);
        $query->setMaxResults(null);

        if ($query instanceof ProxyQueryInterface) {
            $query->addOrderBy($query->getSortBy(), $query->getSortOrder());

            $query = $query->getQuery();
        }
        $dsi = new AppORMQuerySourceIterator($query, $fields, 'Y-m-d H:i:s');
        // set the timezone for MMT Time
        $dsi->setTimezone('Asia/Rangoon');

        return $dsi;
    }
}
