<?php
/*
 * This file is part of Newrelic Tools.
 *
 * (c) Matthew Wheeler <matt@yurisko.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Afoozle\NewrelicTools\Test\Deployments;

use Afoozle\NewrelicTools\Deployments\Deployment;
use Afoozle\NewrelicTools\Deployments\DeploymentNotifier;
use Mockery as m;

class DeploymentNotifierTest extends \PHPUnit_Framework_TestCase {

    public function tearDown() {
        m::close();
    }

    public function testNotifySendsAllPostFields() {

        $testDeployment = new Deployment(null, 'testAppName');
        $testDeployment->setRevision('testRevision');
        $testDeployment->setDescription('testDescription');
        $testDeployment->setChangelog('testChangelog');
        $testDeployment->setUser('testUser');

        $mockedClient = $this->createMockedHttpClient($testDeployment);
        $deploymentNotifier = new DeploymentNotifier('abc-123-def-456-ghi-789');

        $deploymentNotifier->notify($testDeployment, $mockedClient);
    }

    /**
     * @param \Afoozle\NewrelicTools\Deployments\Deployment $testDeployment
     * @return \GuzzleHttp\ClientInterface
     */
    private function createMockedHttpClient(Deployment $testDeployment)
    {
        $mockedRequestBody = m::mock('\GuzzleHttp\Stream\StreamInterface');

        if ($testDeployment->getAppName() !== null) {
            $mockedRequestBody->shouldReceive('setField')->with('app_name', $testDeployment->getAppName());
        }

        if ($testDeployment->getApplicationId() !== null) {
            $mockedRequestBody->shouldReceive('setField')->with('application_id', $testDeployment->getApplicationId());
        }

        if ($testDeployment->getRevision() !== null) {
            $mockedRequestBody->shouldReceive('setField')->with('revision', $testDeployment->getRevision());
        }

        if ($testDeployment->getDescription() !== null) {
            $mockedRequestBody->shouldReceive('setField')->with('description', $testDeployment->getDescription());
        }

        if ($testDeployment->getChangelog() !== null) {
            $mockedRequestBody->shouldReceive('setField')->with('changelog', $testDeployment->getChangelog());
        }

        if ($testDeployment->getUser() !== null) {
            $mockedRequestBody->shouldReceive('setField')->with('user', $testDeployment->getUser());
        }

        $mockedRequest = m::mock('\GuzzleHttp\Message\Request');
        $mockedRequest->shouldReceive('setHeader')->with('x-api-key', m::any())->once();
        $mockedRequest->shouldReceive('getBody')->once()->andReturn($mockedRequestBody);

        $mockedClient = m::mock('\GuzzleHttp\ClientInterface');
        $mockedClient
          ->shouldReceive('createRequest')
          ->with('POST', m::any())
          ->once()
          ->andReturn($mockedRequest);

        $mockedClient
          ->shouldReceive('send')
          ->withAnyArgs()
          ->once()
          ->andReturn();

        return $mockedClient;
    }

}
