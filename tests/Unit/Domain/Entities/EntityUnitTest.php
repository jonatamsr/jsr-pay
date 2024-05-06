<?php

namespace Tests\Unit\Domain\Entities;
use App\Domain\Entities\Entity;
use Tests\TestCase;

class EntityUnitTest extends TestCase
{
    private $mockImplementedClass;

    protected function setUp(): void
    {
        parent::setUp();

        $constructArgs = [
            'fakeProperty' => 'some-value',
            'fakeProperty2' => 'some-value2',
        ];

        $this->mockImplementedClass = new class($constructArgs) extends Entity {
            protected $fakeProperty;
            protected $fakeProperty2;

            public function getFakeProperty(): string
            {
                return $this->fakeProperty;
            }

            public function getFakeProperty2(): string
            {
                return $this->fakeProperty2;
            }
        };
    }

    public function testEntityImplementedClassIsAttatchingPropertiesCorrectly(): void
    {
        $this->assertEquals('some-value', $this->mockImplementedClass->getFakeProperty());
        $this->assertEquals('some-value2', $this->mockImplementedClass->getFakeProperty2());
    }

    public function testEntityImplementedClassIsExportingToArrayCorrectly(): void
    {
        $expectedResult = [
            'fakeProperty' => 'some-value',
            'fakeProperty2' => 'some-value2',
        ];

        $this->assertEquals($expectedResult, $this->mockImplementedClass->toArray());
    }
}
