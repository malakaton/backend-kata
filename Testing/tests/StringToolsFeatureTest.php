<?php

declare(strict_types=1);

namespace App\Tests;

use App\libs\StringTools;
use Mockery\MockInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class StringToolsFeatureTest extends KernelTestCase
{
    private const string_to_test = 'hola caracola';
    private const uppercase_string_to_test = 'HOLA CARACOLA';
    private const success_response = 'Hola Caracola';
    private const invalid_argument_exception_message = 'Capitalize only accepts strings!';

    private StringTools $stringTools;
    private MockInterface $mockedStringTools;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stringTools = new StringTools();
        $this->mockedStringTools = \Mockery::mock(StringTools::class);
    }

    /**
     * @test
     */
    public function it_should_capitalize_works(): void
    {
        $this->mockedStringTools->shouldReceive('capitalize')
            ->with(self::string_to_test)
            ->once()
            ->andReturn(self::success_response);

        $result = $this->stringTools->capitalize(self::string_to_test);

        self::assertNotNull($result);
        self::assertSame(self::success_response, $result);
        self::assertSame(
            $this->mockedStringTools->capitalize(self::string_to_test),
            $result
        );
    }

    /**
     * @test
     */
    public function it_should_capitalize_throw_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->stringTools->capitalize(1);
    }

    /**
     * @test
     */
    public function it_should_capitalize_works_with_uppercase_string(): void
    {
        $result = $this->stringTools->capitalize(self::uppercase_string_to_test);

        self::assertNotNull($result);
        self::assertSame(self::success_response, $result);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_by_numeric_negative_parameter(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectErrorMessage(self::invalid_argument_exception_message);

        $this->stringTools->capitalize(1);
    }
}