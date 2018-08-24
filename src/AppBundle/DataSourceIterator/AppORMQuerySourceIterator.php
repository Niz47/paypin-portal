<?php

/**
 * Custom data source iterator
 * @author Jayraj Arora <jayraja@mindfiresolutions.com>
 * @category DataSourceIterator
 */


namespace AppBundle\DataSourceIterator;

use Exporter\Source\DoctrineORMQuerySourceIterator;

class AppORMQuerySourceIterator extends DoctrineORMQuerySourceIterator
{
    protected $timezone;

    /**
     * Set timezone by timezone string
     * @param $timezoneString String - Valid supported timezone string
     */
    public function setTimezone($timezoneString)
    {
        $this->timezone = new \DateTimeZone($timezoneString);
    }

    /**
     * Get Timezone
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     *
     * @param $value
     * @return null|string
     */
    protected function getValue($value)
    {
        //convert datetime to set timezones
        if ($value instanceof \DateTime && $this->timezone instanceof \DateTimeZone) {
            $value->setTimezone($this->timezone);
        }

        return parent::getValue($value);
    }
}
