<?php

namespace OpenSkill\Datatable;


use Mockery;
use OpenSkill\Datatable\Data\ResponseData;

class DatatableServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testMethods()
    {
        $rspData = Mockery::mock('OpenSkill\Datatable\Data\ResponseData');

        $provider = Mockery::mock('OpenSkill\Datatable\Providers\Provider');
        $provider->shouldReceive('prepareForProcessing')->andReturn();

        $provider->shouldReceive('process')->andReturn($rspData);

        $version = Mockery::mock('OpenSkill\Datatable\Versions\Version');

        $versionEngine = Mockery::mock('OpenSkill\Datatable\Versions\VersionEngine');
        $versionEngine->shouldReceive('hasVersion')->andReturn(true);
        $versionEngine->shouldReceive('setVersion')->andReturn();
        $versionEngine->shouldReceive('getVersion')->andReturn($version);

        $queryConfig = Mockery::mock('OpenSkill\Datatable\Queries\QueryConfiguration');

        $version->shouldReceive('parseRequest')->andReturn($queryConfig);
        $version->shouldReceive('createResponse')->andReturn();

        $dts = new DatatableService($provider, [], $versionEngine);

        $dts->setVersion($version);

        $dts->shouldHandle();

        $dts->handleRequest();

        $dts->view();
    }
}