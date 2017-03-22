<?php

namespace Progrupa\TrackingBundle\Tracking;

use GuzzleHttp\Exception\ClientException;
use JMS\Serializer\SerializerInterface;

class Client
{
    /** @var  \GuzzleHttp\ClientInterface */
    private $http;
    /** @var  SerializerInterface */
    private $serializer;

    /**
     * Client constructor.
     * @param \GuzzleHttp\ClientInterface $http
     * @param SerializerInterface $serializer
     */
    public function __construct(\GuzzleHttp\ClientInterface $http, SerializerInterface $serializer)
    {
        $this->http = $http;
        $this->serializer = $serializer;
    }

    /**
     * @param $identifier
     * @return Entry|null
     */
    public function getUniversalTracker($identifier)
    {
        try {
            $response = $this->http->request(
                'get',
                sprintf('pgut/%s', $identifier)
            );

            if ($response->getStatusCode() == 200) {
                $entry = $this->serializer->deserialize($response->getBody()->getContents(), Entry::class, 'json');

                return $entry;
            }
        } catch (ClientException $ge) {
            if ($ge->getCode() == 404) {
                return null;
            }
        }
        return null;
    }
}
