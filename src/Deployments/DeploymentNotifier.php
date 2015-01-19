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

use Afoozle\NewrelicTools\Deployments\Deployment;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class DeploymentNotifier {

    /** @var string The API key from New Relic */
    private $apiKey;

    private $apiUrl = 'https://api.newrelic.com/deployments.xml';

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function notify(Deployment $deployment, ClientInterface $client = null) {

        if ($client == null) {
            $client = new Client();
        }
        $request = $this->buildRequest($deployment, $client);
        $response = $client->send($request);
    }

    /**
     * @param Deployment $deployment
     * @param ClientInterface $client
     * @return \GuzzleHttp\Message\RequestInterface
     */
    private function buildRequest(Deployment $deployment, ClientInterface $client) {
        $request = $client->createRequest('POST', $this->apiUrl);
        $request->setHeader('x-api-key', $this->apiKey);
        $postBody = $request->getBody();

        $postFields = $this->getDeploymentFields($deployment);
        foreach ($postFields as $fieldName => $fieldValue) {
            $postBody->setField($fieldName, $fieldValue);
        }
        return $request;
    }

    /**
     * @param Deployment $deployment
     * @return array
     */
    private function getDeploymentFields(Deployment $deployment) {

        $fields = array();

        if (null !== $deployment->getRevision()) {
            $fields['revision'] = $deployment->getRevision();
        }

        if (null !== $deployment->getDescription()) {
            $fields['description'] = $deployment->getDescription();
        }

        if (null !== $deployment->getApplicationId()) {
            $fields['application_id'] = $deployment->getApplicationId();
        }

        if (null !== $deployment->getAppName()) {
            $fields['app_name'] = $deployment->getAppName();
        }

        if (null !== $deployment->getChangelog()) {
            $fields['changelog'] = $deployment->getChangelog();
        }

        if (null !== $deployment->getUser()) {
            $fields['user'] = $deployment->getUser();
        }

        return $fields;
    }

}