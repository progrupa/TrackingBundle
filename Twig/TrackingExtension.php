<?php

namespace Progrupa\TrackingBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TrackingExtension extends AbstractExtension
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

    public function getFunctions()
    {
        return [
            new TwigFunction('progrupa_tracker_endpoint', [$this, 'getTrackerBaseUrl']),
            new TwigFunction('progrupa_tracker_site', [$this, 'getTrackerSiteId']),
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
