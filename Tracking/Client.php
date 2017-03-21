<?php

namespace Progrupa\TrackingBundle\Tracking;

use JMS\Serializer\SerializerInterface;

class Client
{
    /** @var  \GuzzleHttp\ClientInterface */
    private $http;
    /** @var  SerializerInterface */
    private $serializer;

    public function getUniversalTracker($identifier)
    {
        $response = $this->http->request(
            'get',
            sprintf('/pgut/%s', $identifier)
        );

        if ($response->getStatusCode() == 200) {
            $entry = $this->serializer->deserialize($response->getBody()->getContents(), Entry::class, 'json');
            return $entry;
        }
        return null;
    }
}
