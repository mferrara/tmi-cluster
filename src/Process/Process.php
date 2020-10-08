<?php

namespace GhostZero\TmiCluster\Process;

use Carbon\CarbonImmutable;
use Closure;
use GhostZero\TmiCluster\Events\UnableToLaunchProcess;
use GhostZero\TmiCluster\Events\WorkerProcessRestarting;
use Symfony\Component\Process\Exception\ExceptionInterface;
use Symfony\Component\Process\Process as SystemProcess;

class Process
{
    private SystemProcess $systemProcess;
    private Closure $output;
    private ?CarbonImmutable $restartAgainAt = null;

    public function __construct(SystemProcess $systemProcess)
    {
        $this->systemProcess = $systemProcess;
        $this->output = function () {
            //
        };
    }

    public function monitor(): void
    {
        if ($this->systemProcess->isRunning() || $this->coolingDown()) {
            return;
        }

        $this->restart();
    }

    protected function restart(): void
    {
        if ($this->systemProcess->isStarted()) {
            event(new WorkerProcessRestarting($this));
        }

        $this->start($this->output);
    }

    public function terminate(): void
    {
        $this->sendSignal(SIGTERM);
    }

    public function stop(): void
    {
        if ($this->systemProcess->isRunning()) {
            $this->systemProcess->stop();
        }
    }

    protected function sendSignal($signal): void
    {
        try {
            $this->systemProcess->signal($signal);
        } catch (ExceptionInterface $e) {
            if ($this->systemProcess->isRunning()) {
                throw $e;
            }
        }
    }

    public function start(Closure $output): Process
    {
        $this->handleOutputUsing($output)->cooldown();

        $this->systemProcess->start($output);

        return $this;
    }

    protected function cooldown()
    {
        if ($this->coolingDown()) {
            return;
        }

        if ($this->restartAgainAt) {
            $this->restartAgainAt = ! $this->systemProcess->isRunning()
                ? CarbonImmutable::now()->addMinute()
                : null;

            if (! $this->systemProcess->isRunning()) {
                event(new UnableToLaunchProcess($this));
            }
        } else {
            $this->restartAgainAt = CarbonImmutable::now()->addSecond();
        }
    }

    public function coolingDown(): bool
    {
        return isset($this->restartAgainAt) &&
            CarbonImmutable::now()->lt($this->restartAgainAt);
    }

    public function handleOutputUsing(Closure $callback): self
    {
        $this->output = $callback;

        return $this;
    }
}
