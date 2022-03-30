<?php

declare(strict_types=1);
include_once __DIR__ . '/stubs/Validator.php';
class SyncMySQLValidationTest extends TestCaseSymconValidation
{
    public function testValidateSyncMySQL(): void
    {
        $this->validateLibrary(__DIR__ . '/..');
    }
    public function testValidateSyncMySQLModule(): void
    {
        $this->validateModule(__DIR__ . '/../SyncMySQL');
    }
}
