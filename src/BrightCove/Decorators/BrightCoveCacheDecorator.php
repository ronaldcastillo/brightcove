<?php

namespace ContemporaryVA\BrightCove\Decorators;

/**
 * BrightCoveCacheDecorator
 *
 * Adds cache functionality to the BrightCove library
 *  - Saves the bearer after authenticating, avoiding to authenticate for every request
 *
 * @extends AbstractBrightCoveDecorator
 * @author Ronald Castillo <ronaldcastillo@gmail.com>
 */
class BrightCoveCacheDecorator extends AbstractBrightCoveDecorator
{

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $repository;

    /**
     * Duration in minutes
     * @var int
     */
    protected $duration = 5;

    /**
     * @param \Illuminate\Contracts\Cache\Repository $repository
     * @return $this
     */
    public function setRepository(\Illuminate\Contracts\Cache\Repository $repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * Set the duration of the cache, in minutes
     * @param int $duration
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return string Access token
     */
    public function authenticate()
    {
        if ( ! $this->repository->has('brightcove.bearer')) {
            $this->repository->put('brightcove.bearer', $this->brightcove->authenticate(), $this->duration);
        }

        return $this->repository->get('brightcove.bearer');
    }

}