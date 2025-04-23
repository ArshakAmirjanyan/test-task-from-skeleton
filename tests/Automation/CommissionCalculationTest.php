<?php

namespace Automation;

use PHPUnit\Framework\TestCase;


final class CommissionCalculationTest extends TestCase
{
    public function testCommissionCalculationMatchesExpectedOutput(): void
    {
        $inputFile = __DIR__ . '/../../test-data/test-input.csv';
        $expectedOutputFile = __DIR__ . '/../../test-data/output.txt';
        $indexScript = realpath(__DIR__ . '/../../src/index.php');

        $this->assertFileExists($inputFile, "Input CSV file not found.");
        $this->assertFileExists($expectedOutputFile, "Expected output file not found.");

        $output = shell_exec("php \"$indexScript\" \"$inputFile\"");
        $this->assertNotFalse($output, "Failed to execute index.php");

        $actualLines = array_map('trim', explode("\n", trim($output)));
        $expectedLines = array_map('trim', file($expectedOutputFile));

        $this->assertCount(
            count($expectedLines),
            $actualLines,
            "Line count mismatch. Output was: \n" . implode("\n", $actualLines)
        );

        foreach ($expectedLines as $i => $expectedLine) {
            $this->assertEquals(
                $expectedLine,
                $actualLines[$i],
                "Mismatch at line " . ($i + 1) . ": Got '{$actualLines[$i]}', expected '{$expectedLine}'"
            );
        }
    }
}