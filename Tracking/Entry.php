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
    public function setPgut(string $pgut): void
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
    public function setSite(string $site): void
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
    public function setSiteHash(string $siteHash): void
    {
        $this->siteHash = $siteHash;
    }
}
