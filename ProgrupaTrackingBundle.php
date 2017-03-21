<?php

namespace Progrupa\TrackingBundle;

use Progrupa\MailjetBundle\DependencyInjection\Compiler\CustomHandlersPass;
use Progrupa\MailjetBundle\DependencyInjection\Compiler\RegisterEventListenersAndSubscribersPass;
use Progrupa\MailjetBundle\DependencyInjection\Compiler\ServiceMapPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ProgrupaTrackingBundle extends Bundle
{
}
