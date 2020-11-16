<?php

namespace GhostZero\TmiCluster;

use GhostZero\TmiCluster\Contracts;
use GhostZero\TmiCluster\Twitch\Twitch;

trait ServiceBindings
{
    /**
     * All of the service bindings for our TMI Cluster.
     *
     * @var array
     */
    public $serviceBindings = [
        // General services...
        AutoScale::class,
        AutoCleanup::class,
        Contracts\ClusterClient::class => TmiClusterClient::class,
        Twitch::class,

        // Repository services...
        Contracts\SupervisorRepository::class => Repositories\SupervisorRepository::class,
        Contracts\CommandQueue::class => Repositories\RedisCommandQueue::class,
    ];
}
