<?php

namespace Progrupa\TrackingBundle\Twig;

class TrackingExtension extends \Twig_Extension
{
    /** @var  string */
    private $trackerBaseUrl;
    /** @var  string */
    private $trackerSiteId;

    /**
     * TrackingExtension constructor.
     * @param string $trackerBaseUrl
     * @param string $trackerSiteId
     */
    public function __construct($trackerBaseUrl, $trackerSiteId)
    {
        $this->trackerBaseUrl = $trackerBaseUrl;
        $this->trackerSiteId = $trackerSiteId;
    }

    public function getName()
    {
        'progrupa_tracking_twig_extension';
    }


    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('progrupa_tracker_endpoint', [$this, 'getTrackerBaseUrl']),
            new \Twig_SimpleFunction('progrupa_tracker_site', [$this, 'getTrackerSiteId']),
        ];
    }

    /**
     * @return string
     */
    public function getTrackerBaseUrl()
    {
        return $this->trackerBaseUrl;
    }

    /**
     * @return string
     */
    public function getTrackerSiteId()
    {
        return $this->trackerSiteId;
    }
}
