<?php

namespace Progrupa\TrackingBundle\Tracking;


use JMS\Serializer\Annotation as Serializer;

class Entry
{
    /**
     * @Serializer\Type("string")
     */
    private $pgut;
    /**
     * @Serializer\Type("string")
     */
    private $site;
    /**
     * @Serializer\Type("string")
     */
    private $siteHash;

    /**
     * @return mixed
     */
    public function getPgut()
    {
        return $this->pgut;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @return mixed
     */
    public function getSiteHash()
    {
        return $this->siteHash;
    }
}
