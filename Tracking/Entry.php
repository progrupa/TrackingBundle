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
     * @return string
     */
    public function getPgut()
    {
        return $this->pgut;
    }

    /**
     * @param string $pgut
     */
    public function setPgut(string $pgut)
    {
        $this->pgut = $pgut;
    }

    /**
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $site
     */
    public function setSite(string $site)
    {
        $this->site = $site;
    }

    /**
     * @return string
     */
    public function getSiteHash()
    {
        return $this->siteHash;
    }

    /**
     * @param string $siteHash
     */
    public function setSiteHash(string $siteHash)
    {
        $this->siteHash = $siteHash;
    }
}
