<?php

use Codeception\Test\Unit;
use Insly\QmtApiClient\Api\Models\Interfaces\HasSetFields;
use Insly\QmtApiClient\Api\Models\Traits\SetsFields;
use Insly\QmtApiClient\Api\Transformers\AbstractTransformer;
use Insly\QmtApiClient\Api\Transformers\ResultsTransformer;

class TransformerTest extends Unit
{
    public function testTransformingValues(): void
    {
        $inputData = [
            'foo' => 'foo value',
            'bar' => [
                'bar' => 123
            ]
        ];

        $testTransformer = new class() extends AbstractTransformer {
            protected $fieldsMap = [
                'foo' => 'fooField',
                'bar' => 'barField',
                'oof' => 'oofField',
            ];
        };

        $this->assertEquals(
            [
                'fooField' => 'foo value',
                'barField' => [
                    'bar' => 123
                ],
            ],
            $testTransformer->transform($inputData)
        );
    }

    public function testTransformingResultsValues(): void
    {
        $inputData = [
            'results' => [
                [
                    'foo' => 'foo0',
                    'bar' => 'bar0'
                ],
                [
                    'foo' => 'foo1',
                    'bar' => 'bar1'
                ],
            ]
        ];

        $resultClass = new class implements HasSetFields {
            use SetsFields;
            public $fooField;
            public $barField;
        };


        $transformerClass = new class() extends AbstractTransformer {
            protected $fieldsMap = [
                'foo' => 'fooField',
                'bar' => 'barField',
            ];
        };


        $resultTransformer = new ResultsTransformer($resultClass, $transformerClass);

        $results = $resultTransformer->transform($inputData);

        $this->assertCount(2, $results);
        foreach ($results as $index => $result) {
          $this->assertInstanceOf(get_class($resultClass), $result);
          $this->assertEquals('foo' . $index, $result->fooField);
          $this->assertEquals('bar' . $index, $result->barField);
        }
    }
}
