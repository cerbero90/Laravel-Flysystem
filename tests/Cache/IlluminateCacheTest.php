<?php

/**
 * This file is part of Laravel Flysystem by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\Flysystem\Cache;

use Mockery;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the illuminate cache test class.
 *
 * @package    Laravel-Flysystem
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Flysystem/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Flysystem
 */
class IlluminateCacheTest extends AbstractTestCase
{
    public function testload()
    {
        $cache = $this->getIlluminateCache('foobarkey');

        $cache->getClient()->shouldReceive('get')->once()->with('foobarkey')->andReturn('herro');

        $cache->shouldReceive('setFromStorage')->once()->with('herro');

        $cache->load();
    }

    public function testloadEmpty()
    {
        $cache = $this->getIlluminateCache('foobarkey');

        $cache->getClient()->shouldReceive('get')->once()->with('foobarkey');

        $cache->load();
    }

    public function testSave()
    {
        $cache = $this->getIlluminateCache('foobarkey', 95);

        $cache->shouldReceive('getForStorage')->once()->andReturn('herro');

        $cache->getClient()->shouldReceive('put')->once()->with('foobarkey', 'herro', 2);

        $cache->save();
    }

    public function testSaveForever()
    {
        $cache = $this->getIlluminateCache('foobarkey');

        $cache->shouldReceive('getForStorage')->once()->andReturn('herro');

        $cache->getClient()->shouldReceive('forever')->once()->with('foobarkey', 'herro');

        $cache->save();
    }

    protected function getIlluminateCache($key, $ttl = null)
    {
        $client = Mockery::mock('Illuminate\Cache\StoreInterface');

        return Mockery::mock(
            'GrahamCampbell\Flysystem\Cache\IlluminateCache[setFromStorage,getForStorage]',
            array($client, $key, $ttl)
        );
    }
}