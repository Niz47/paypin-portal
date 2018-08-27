<?php

namespace AppBundle\Twig\Extension;

/**
 * Class AppExtension
 * @package AppBundle\Twig\Extension
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('to_MMT', [$this, 'convertToMMT'])
        ];
    }

    /*
     * Converts the UTC datetime to MMT date time
     * @params $datetime
     */
    /**
     * @param $datetime
     * @return string
     */
    public function convertToMMT($datetime)
    {
        if ($datetime && $datetime instanceof \DateTime) {
            return $datetime->modify("+6 hour 30 minute")->format('Y-m-d H:i:s');
        }
        return '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }
}
