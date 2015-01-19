<?php
/*
 * This file is part of Newrelic Tools.
 *
 * (c) Matthew Wheeler <matt@yurisko.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Afoozle\NewrelicTools\Deployments;

/**
 * Class Deployment
 *
 * This is a value object which represents a single deployment
 *
 * @package Afoozle\NewrelicTools\Deployments
 */
class Deployment {

    /** @var string The application Name from New Relic */
    private $appName = null;

    /** @var int The application ID from New Relic */
    private $applicationId = null;

    /** @var string A text description for this deployment */
    private $description = null;

    /** @var null The revision id for this deployment */
    private $revision = null;

    /** @var string A textual changelog for this deployment */
    private $changelog = null;

    /** @var string The user running this deployment */
    private $user = null;

    /**
     * @param null|int $applicationId
     * @param null|string $appName
     * @throws \InvalidArgumentException
     */
    public function __construct($applicationId = null, $appName = null) {

        if ($applicationId !== null && $appName !== null) {
            throw new \InvalidArgumentException('Setting only application name or id is required, choose one');
        }

        if ($applicationId !== null) {
            if (false === is_int($applicationId) || $applicationId <= 0) {
                throw new \InvalidArgumentException('Application ID must be null or an integer');
            }

            $this->applicationId = $applicationId;
        }

        if ($appName !== null) {
            if (false === is_string($appName)) {
                throw new \InvalidArgumentException('App Name must be null or a string');
            }
            $this->appName = (string)$appName;
        }
    }

    /**
     * The application Name from New Relic
     *
     * @return string
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * The application ID from New Relic
     *
     * @return int
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * A textual changelog for this deployment
     *
     * @return string
     */
    public function getChangelog()
    {
        return $this->changelog;
    }

    /**
     * A textual changelog for this deployment
     *
     * @param string $changelog
     */
    public function setChangelog($changelog)
    {
        $this->changelog = $changelog;
    }

    /**
     * A text description for this deployment
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * A text description for this deployment
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * The revision id for this deployment
     *
     * @return null
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * The revision id for this deployment
     *
     * @param null $revision
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
    }

    /**
     * The user running this deployment
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * The user running this deployment
     *
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}