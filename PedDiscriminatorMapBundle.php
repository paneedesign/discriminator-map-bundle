<?php

namespace PaneeDesign\DiscriminatorMapBundle;

use Doctrine\ORM\Events;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PedDiscriminatorMapBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        $listener = $this->container->get('ped_discriminator.listener');
        $em = $this->container
            ->get('doctrine.orm.default_entity_manager');

        $evm = $em->getEventManager();
        $evm->addEventListener(Events::loadClassMetadata, $listener);
    }
}
