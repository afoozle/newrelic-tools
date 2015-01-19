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

class DeploymentTest extends \PHPUnit_Framework_TestCase {

    public static function invalidApplicationIds() {
        return array(
            array(-1, 'Negative numbers are invalid application ids'),
            array('a', 'Strings are invalid application ids'),
            array(false, 'Bools are invalid application ids'),
            array(new \stdClass(), 'Objects are invalid application ids'),
        );
    }

    /** @dataProvider invalidApplicationIds */
    public function testConstructorFailsWithInvalidApplicationId($invalidAppId, $errorMessage)
    {
        try {
            new Deployment($invalidAppId, null);
            $this->fail("An expected InvalidArgumentException was not thrown for invalid application id $invalidAppId: ".$errorMessage);
        }
        catch(\InvalidArgumentException $expected) {}
    }

    public static function invalidApplicationNames() {
        return array(
            array(5, 'Numbers are invalid application ids'),
            array(false, 'Bools are invalid application names'),
            array(new \stdClass(), 'Objects are invalid application names'),
        );
    }

    /** @dataProvider invalidApplicationNames */
    public function testConstructorFailsWithInvalidApplicationName($invalidAppName, $errorMessage)
    {
        try {
            new Deployment(null, $invalidAppName);
            $this->fail("An expected InvalidArgumentException was not thrown for invalid application name $invalidAppName: ".$errorMessage);
        }
        catch(\InvalidArgumentException $expected) {}
    }

    public function testConstructorFailsWithBothAppIdAndNameSet()
    {
        try {
            new Deployment(12345, 'appName');
            $this->fail("An expected InvalidArgumentException was not thrown for supplying both appId and appName");
        }
        catch(\InvalidArgumentException $expected) {}
    }

    public function testAppIdAccessors() {
        $deployment = new Deployment(12345, null);
        $this->assertEquals(12345, $deployment->getApplicationId());
    }

    public function testAppNameAccessors() {
        $deployment = new Deployment(null, 'Test AppName');
        $this->assertEquals('Test AppName', $deployment->getAppName());
    }

    public function testChangelogAccessors() {
        $deployment = new Deployment(12345, null);
        $this->assertNull($deployment->getChangelog());
        $deployment->setChangelog('This is my Changelog');
        $this->assertEquals('This is my Changelog', $deployment->getChangelog());
        $deployment->setChangelog(null);
        $this->assertNull($deployment->getChangelog());
    }

    public function testDescriptionAccessors() {
        $deployment = new Deployment(12345, null);
        $this->assertNull($deployment->getDescription());
        $deployment->setDescription('This is my Description');
        $this->assertEquals('This is my Description', $deployment->getDescription());
        $deployment->setDescription(null);
        $this->assertNull($deployment->getDescription());
    }

    public function testRevisionAccessors() {
        $deployment = new Deployment(12345, null);
        $this->assertNull($deployment->getRevision());
        $deployment->setRevision('This is my Revision');
        $this->assertEquals('This is my Revision', $deployment->getRevision());
        $deployment->setRevision(null);
        $this->assertNull($deployment->getRevision());
    }

    public function testUserAccessors() {
        $deployment = new Deployment(12345, null);
        $this->assertNull($deployment->getUser());
        $deployment->setUser('Afoozle');
        $this->assertEquals('Afoozle', $deployment->getUser());
        $deployment->setUser(null);
        $this->assertNull($deployment->getUser());
    }
}
