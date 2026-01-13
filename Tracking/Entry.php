<?php

namespace Progrupa\TrackingBundle\Tracking;


class Entry
{
    /**
     * @var string
     */
    private $pgut;
    /**
     * @var string
     */
    private $site;
    /**
     * @var string
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
     * @param string $pgut
     */
    public function setPgut($pgut)
    {
        $this->pgut = $pgut;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getSiteHash()
    {
        return $this->siteHash;
    }

    /**
     * @param string $siteHash
     */
    public function setSiteHash($siteHash)
    {
        $this->siteHash = $siteHash;
    }
}
