<?php

declare(strict_types=1);

class SyncMySQL extends IPSModule
{
    //RegEx for validation of format
    //https://regex101.com/r/YwBrc0/1
    private $identFormats = [
        '', //Custom
        "^([A-Za-z0-9]+)-([_A-Za-z0-9]+)-([_A-Za-z0-9]+)-([_A-Za-z0-9]+)=([0-9]+)\+([_A-Za-z0-9]+)-([_A-Za-z0-9]+)-([0-9]+)([A-Z])([0-9]+)\/([A-Z]+)-([_A-Za-z0-9]+)-([_A-Za-z0-9]+)-([_A-Za-z0-9]*)-([_A-Za-z0-9]*)-([_A-Za-z0-9]*)-([_A-Za-z0-9]*)-([_A-Za-z0-9]*)$"
    ];

    //https://regex101.com/r/peWokG/2
    private $bksFormats = [
        '', //Custom
        "^([A-Za-z0-9]+)-([_A-Za-z0-9]+)-([_A-Z0-9]+)-([_A-Za-z0-9]+)=([0-9]+)\+([_A-Za-z0-9]+)-([_A-Za-z0-9]+)-([0-9]+)([A-Z])([0-9]+)$"
    ];

    private $tableIdent = [
        [
            'Field' => 'id',
            'Type'  => 'int(11)',
            'Extra' => 'AUTO_INCREMENT'
        ],
        [
            'Field' => 'active',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'variableid',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'aggregationtype',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'ident',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'unit',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'tariff',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'meterid',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'zoneid',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'usage_type',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'description',
            'Type'  => 'text'
        ],
    ];

    private $tableData = [
        [
            'Field' => 'id',
            'Type'  => 'int(11)',
            'Extra' => 'AUTO_INCREMENT'
        ],
        [
            'Field' => 'identid',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'timestamp',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'value',
            'Type'  => 'double'
        ]
    ];

    private $tableFormat = [
        [
            'Field' => 'id',
            'Type'  => 'int(11)',
            'Extra' => 'AUTO_INCREMENT'
        ],
        [
            'Field' => 'identid',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'property',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'property_detail',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'ifp_building_designation',
            'Type'  => 'varchar(5)'
        ],
        [
            'Field' => 'ifp_room_designation',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'system_number',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'component_building_designation',
            'Type'  => 'varchar(5)'
        ],
        [
            'Field' => 'component_room_designation',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'circuit_diagram_page',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'classification_scheme',
            'Type'  => 'varchar(5)'
        ],
        [
            'Field' => 'circuit_diagram_number',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'function_identifier',
            'Type'  => 'varchar(5)'
        ],
        [
            'Field' => 'data_point',
            'Type'  => 'varchar(5)'
        ],
        [
            'Field' => 'additional_field_01',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'additional_field_02',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'additional_field_03',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'additional_field_04',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'additional_field_05',
            'Type'  => 'varchar(10)'
        ],
        [
            'Field' => 'additional_field_06',
            'Type'  => 'varchar(10)'
        ]
    ];

    private $tableMeter = [
        [
            'Field' => 'id',
            'Type'  => 'int(11)',
            'Extra' => 'AUTO_INCREMENT'
        ],
        [
            'Field' => 'meter_number',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'timestamp',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'linkedid',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'bks',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'description',
            'Type'  => 'varchar(100)'
        ]
    ];

    private $tableZone = [
        [
            'Field' => 'id',
            'Type'  => 'int(11)',
            'Extra' => 'AUTO_INCREMENT'
        ],
        [
            'Field' => 'location',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'area',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'net_area',
            'Type'  => 'int(11)'
        ],
        [
            'Field' => 'economic_unit',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'building_unit',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'building_assignment',
            'Type'  => 'varchar(100)'
        ],
        [
            'Field' => 'construction_date',
            'Type'  => 'varchar(100)'
        ]
    ];

    public function  __construct($InstanceID)
    {
        //Never delete this line!
        parent::__construct($InstanceID);

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    public function Create()
    {
        //Never delete this line!
        parent::Create();

        $this->RegisterPropertyBoolean('Active', false);
        $this->RegisterPropertyString('Host', '');
        $this->RegisterPropertyInteger('Port', 3306);
        $this->RegisterPropertyString('Username', 'root');
        $this->RegisterPropertyString('Password', '');
        $this->RegisterPropertyString('Database', 'smartenergybox');
        $this->RegisterPropertyInteger('Format', 1);
        $this->RegisterPropertyInteger('Interval', 300);
        $this->RegisterPropertyBoolean('SSL', false);
        $this->RegisterPropertyBoolean('SSLDontVerify', false);

        $this->RegisterTimer('Sync', 0, "SSQL_Sync(\$_IPS['TARGET']);");
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();

        if ($this->ReadPropertyBoolean('Active')) {
            try {
                $this->dbConfigure($this->dbConnect());
                $this->SetBuffer('DatabaseStatus', '');
                $this->SetTimerInterval('Sync', $this->ReadPropertyInteger('Interval') * 1000);
                $this->SetStatus(IS_ACTIVE);

                //Due to some nice race conditions effects we want to send the list content also at this point
                $this->updateList();
            } catch (Exception $e) {
                $this->SetBuffer('DatabaseStatus', $e->getMessage());
                $this->SetTimerInterval('Sync', 0);
                $this->SetStatus(IS_EBASE);
            }
        } else {
            $this->SetBuffer('DatabaseStatus', '');
            $this->SetTimerInterval('Sync', 0);
            $this->SetStatus(IS_INACTIVE);
        }

        //Update Status
        $this->UpdateFormField('DatabaseStatus', 'visible', strlen($this->GetBuffer('DatabaseStatus')) > 0);
        $this->UpdateFormField('DatabaseStatus', 'caption', $this->Translate('Error') . ': ' . $this->GetBuffer('DatabaseStatus'));

        //Update Links
        $this->UpdateLinks();

        //Update Archive
        $this->UpdateArchive();
    }

    public function GetConfigurationForm()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/form.json'), true);

        $format = $this->identFormats[$this->ReadPropertyInteger('Format')];
        $values = $this->GetIdentListValues();

        //Only allow Create/Sync if active
        $data['elements'][1]['items'][7]['items'][2]['enabled'] = $this->ReadPropertyBoolean('Active');
        $data['elements'][1]['items'][8]['items'][2]['enabled'] = $this->ReadPropertyBoolean('Active');

        //Show error, if set
        $data['elements'][0]['visible'] = strlen($this->GetBuffer('DatabaseStatus')) > 0;
        $data['elements'][0]['caption'] = $this->Translate('Error') . ': ' . $this->GetBuffer('DatabaseStatus');

        //Disable format if we have datapoints
        $data['elements'][1]['items'][9]['visible'] = count($values) > 0;
        $data['elements'][1]['items'][10]['enabled'] = count($values) == 0;

        //Add validation for selected format
        $data['actions'][0]['columns'][2]['edit']['validate'] = $format;

        //Get values for IdentList
        $data['actions'][0]['values'] = $values;

        //Check values for error and make column wider
        foreach ($values as $value) {
            if ($value['State'] != 'OK') {
                $data['actions'][0]['columns'][11]['width'] = '160px';
                break;
            }
        }

        //Set format for BKS
        $data['actions'][1]['items'][0]['popup']['items'][0]['items'][1]['validate'] = $this->bksFormats[$this->ReadPropertyInteger('Format')];
        $data['actions'][1]['items'][0]['popup']['items'][1]['items'][2]['validate'] = $this->bksFormats[$this->ReadPropertyInteger('Format')];

        //Add initial zone and meter options
        if ($this->GetStatus() == IS_ACTIVE) {
            $data['actions'][1]['items'][1]['popup']['items'][1]['items'][0]['options'] = $this->getZoneOptions();
            $data['actions'][1]['items'][0]['popup']['items'][1]['items'][0]['options'] = $this->getMeterOptions();
            $data['actions'][1]['items'][0]['popup']['items'][2]['items'][0]['options'] = $this->getMeterOptions();
            $data['actions'][0]['columns'][6]['edit']['options'] = $this->getMeterOptions();
            $data['actions'][0]['columns'][8]['edit']['options'] = $this->getZoneOptions();
        }

        return json_encode($data);
    }

    public function Sync()
    {
        if (IPS_SemaphoreEnter('Sync' . $this->InstanceID, 100)) {
            $db = $this->dbConnect();
            $identList = $this->dbFetchIdentListWithLastData($db);

            $this->SendDebug('Sync', sprintf('Starting... Checking %d variables', count($identList)), 0);

            $archiveID = IPS_GetInstanceListByModuleID('{43192F0B-135B-4CE7-A0A7-1475603F3060}')[0];

            //Check each variable
            foreach ($identList as $ident) {
                //Skip disabled
                if (!$ident['active']) {
                    continue;
                }

                //Skip invalid
                if (!IPS_VariableExists($ident['variableid'])) {
                    continue;
                }

                //Skip not logged
                if (!AC_GetLoggingStatus($archiveID, $ident['variableid'])) {
                    continue;
                }

                //Fetch raw values
                $values = AC_GetLoggedValues($archiveID, $ident['variableid'], ($ident['timestamp'] == null) ? 0 : $ident['timestamp'] + 1, 0 /* Everything */, 0 /* No limit */);

                //Reverse array. We want the oldest values at the front
                $values = array_reverse($values);

                //Add some progress information
                if (count($values) > 0) {
                    $this->SendDebug('Sync', sprintf('Adding %d values to variable #%d', count($values), $ident['variableid']), 0);

                    //Insert each value into the database
                    foreach ($values as $value) {
                        $this->dbAddData($db, $ident['id'], $value['TimeStamp'], $value['Value']);
                    }
                }
            }
            IPS_SemaphoreLeave('Sync' . $this->InstanceID);
        } else {
            echo 'Aborting. Sync is still in progress...';
        }
    }

    public function CreateDatabase()
    {
        $this->dbCreateDatabase($this->dbConnect(true), $this->ReadPropertyString('Database'));
        $this->ApplyChanges();
    }

    public function GetIdentList()
    {
        if ($this->GetStatus() == IS_ACTIVE) {
            return $this->dbFetchIdentList($this->dbConnect());
        } else {
            return [];
        }
    }

    public function IdentAdd(bool $active, int $variableid, int $aggregationtype, string $ident, string $unit, int $meterid, string $tariff, int $zoneid, string $usageType, string $description)
    {
        $db = $this->dbConnect();

        $this->dbCheckIdent($db, $ident);

        $identid = $this->dbAddIdent($db, $active, $variableid, $aggregationtype, $ident, $unit, $meterid, $tariff, $zoneid, $usageType, $description);

        //Only add format if selected
        if ($this->ReadPropertyInteger('Format') > 0) {
            $this->dbAddFormat($db, $identid, $ident);
        }

        //Refresh IdentList values
        $this->updateList();

        //Update Links
        $this->UpdateLinks();

        //Update Archive
        $this->UpdateArchive();
    }

    public function IdentUpdate(int $identid, bool $active, int $variableid, int $aggregationtype, string $ident, string $unit, int $meterID, string $tariff, int $zoneID, string $usageType, string $description)
    {
        $db = $this->dbConnect();

        $this->dbCheckIdent($db, $ident, $identid);

        $this->dbUpdateIdent($db, $identid, $active, $variableid, $aggregationtype, $ident, $unit, $meterID, $tariff, $zoneID, $usageType, $description);

        //Only update format if selected
        if ($this->ReadPropertyInteger('Format') > 0) {
            $this->dbUpdateFormat($db, $identid, $ident);
        }

        //Refresh IdentList values
        $this->updateList();

        //Update Links
        $this->UpdateLinks();

        //Update Archive
        $this->UpdateArchive();
    }

    public function IdentDelete(int $identid)
    {
        $db = $this->dbConnect();
        $this->dbDeleteIdent($db, $identid);

        //Only delete format if selected
        if ($this->ReadPropertyInteger('Format') > 0) {
            $this->dbDeleteFormat($db, $identid);
        }

        //Refresh IdentList values
        $this->updateList();

        //Update Links
        $this->UpdateLinks();

        //Update Archive
        $this->UpdateArchive();
    }

    public function AddMeter(string $MeterNumber, string $MeterBKS, string $MeterDescription)
    {
        //Only create a new meter if there is a new number
        if ($MeterNumber == '' || $MeterBKS == '' || $MeterDescription == '') {
            return;
        }

        $db = $this->dbConnect();
        //Return if meter already exists
        $existingMeter = $this->dbMeterByNumber($db, $MeterNumber);
        if (!empty($existingMeter)) {
            echo $this->Translate('The meter number already exists');
            return;
        }
        $this->dbAddMeter($db, $MeterNumber, $MeterBKS, $MeterDescription, 0);
        //Update content of all meter selects
        $this->updateMeterSelect();

        //Reset fields
        $this->UpdateFormfield('NewMeterNumber', 'value', '');
        $this->UpdateFormfield('NewMeterBKS', 'value', '');
        $this->UpdateFormfield('NewMeterDescription', 'value', '');

        echo $this->Translate('Meter created');
    }

    public function ReplaceMeter(int $MeterID, string $NewMeterNumber, string $NewMeterBKS, string $NewMeterDescription)
    {
        //Only continue if we have a valid MeterID
        if ($MeterID == -1) {
            return;
        }
        $db = $this->dbConnect();

        //Add old meter as a new entry which is linked to the original MeterID
        $oldMeter = $this->dbFetchMeter($db, $MeterID);
        $this->dbAddMeter($db, $oldMeter['meter_number'], $oldMeter['bks'], $oldMeter['description'], $MeterID, $oldMeter['timestamp']);
        $this->dbUpdateMeter($db, $MeterID, $NewMeterNumber, $NewMeterBKS, $NewMeterDescription);
        //Update content of all meter selects
        $this->updateMeterSelect();
        echo $this->Translate('Meter replaced');
    }

    public function LoadMeterHistory(int $MeterID)
    {
        //Only continue if we have a valid MeterID
        if ($MeterID == -1) {
            $this->UpdateFormfield('MeterHistory', 'values', json_encode([]));
            return;
        }
        $db = $this->dbConnect();
        $meter = $this->dbFetchMeter($db, $MeterID);
        $history = [[
            'Timestamp'   => date('d.m.Y H:i:s', $meter['timestamp']),
            'MeterNumber' => $meter['meter_number']
        ]];

        $data = $this->dbFetchMeterHistory($db, $MeterID);
        foreach ($data as $entry) {
            $history[] =
            [
                'Timestamp'   => date('d.m.Y H:i:s', $entry['timestamp']),
                'MeterNumber' => $entry['meter_number']
            ];
        }
        $this->UpdateFormfield('MeterHistory', 'values', json_encode($history));
    }

    public function CreateZone(string $Location, int $Area, int $NetArea, string $EconomicUnit, string $BuildingUnit, string $BuildingAssignment, string $ConstructionDate)
    {
        //Only crate zone if all arguments are set
        foreach (func_get_args() as $argument) {
            if ($argument == '') {
                return;
            }
        }

        $db = $this->dbConnect();
        $this->dbAddZone($db, $Location, $Area, $NetArea, $EconomicUnit, $BuildingUnit, $BuildingAssignment, $ConstructionDate);
        //Update available zone options for editing
        $this->UpdateFormfield('EditZone', 'options', json_encode($this->getZoneOptions()));

        //Reset fields
        $this->UpdateFormfield('NewLocation', 'value', '');
        $this->UpdateFormfield('NewArea', 'value', 0);
        $this->UpdateFormfield('NewNetArea', 'value', 0);
        $this->UpdateFormfield('NewEconomicUnit', 'value', '');
        $this->UpdateFormfield('NewBuildingUnit', 'value', '');
        $this->UpdateFormfield('NewBuildingAssignment', 'value', '');
        $this->UpdateFormfield('NewConstructionDate', 'value', '');

        echo $this->Translate('Zone created');
    }

    public function EditZone(int $ZoneID, string $Location, int $Area, int $NetArea, string $EconomicUnit, string $BuildingUnit, string $BuildingAssignment, string $ConstructionDate)
    {
        //Only continue if we have a valid ZoneID
        if ($ZoneID == -1) {
            return;
        }
        $db = $this->dbConnect();
        $this->dbUpdateZone($db, $ZoneID, $Location, $Area, $NetArea, $EconomicUnit, $BuildingUnit, $BuildingAssignment, $ConstructionDate);
        //Update Select
        $this->UpdateFormfield('EditZone', 'options', json_encode($this->getZoneOptions()));
        echo $this->Translate('Zone saved');
    }

    public function LoadZoneInfo(int $EditZone)
    {
        if ($EditZone == -1) {
            $this->UpdateFormfield('EditLocation', 'value', '');
            $this->UpdateFormfield('EditArea', 'value', 0);
            $this->UpdateFormfield('EditNetArea', 'value', 0);
            $this->UpdateFormfield('EditEconomicUnit', 'value', '');
            $this->UpdateFormfield('EditBuildingUnit', 'value', '');
            $this->UpdateFormfield('EditBuildingAssignment', 'value', '');
            $this->UpdateFormfield('EditConstructionDate', 'value', '');
            return;
        }
        $db = $this->dbConnect();
        $zone = $this->dbFetchZone($db, $EditZone);
        $this->UpdateFormfield('EditLocation', 'value', $zone['location']);
        $this->UpdateFormfield('EditArea', 'value', $zone['area']);
        $this->UpdateFormfield('EditNetArea', 'value', $zone['net_area']);
        $this->UpdateFormfield('EditEconomicUnit', 'value', $zone['economic_unit']);
        $this->UpdateFormfield('EditBuildingUnit', 'value', $zone['building_unit']);
        $this->UpdateFormfield('EditBuildingAssignment', 'value', $zone['building_assignment']);
        $this->UpdateFormfield('EditConstructionDate', 'value', $zone['construction_date']);
    }

    public function LoadMeterInfo(int $EditMeter)
    {
        if ($EditMeter == -1) {
            $this->UpdateFormfield('ReplaceMeterNumber', 'value', '');
            $this->UpdateFormfield('ReplaceMeterBKS', 'value', '');
            $this->UpdateFormfield('ReplaceMeterDescription', 'value', '');
            return;
        }
        $db = $this->dbConnect();
        $meter = $this->dbFetchMeter($db, $EditMeter);
        $this->UpdateFormfield('ReplaceMeterBKS', 'value', $meter['bks']);
        $this->UpdateFormfield('ReplaceMeterDescription', 'value', $meter['description']);
    }

    private function dbConnect($noDatabase = false)
    {
        $db = mysqli_init();
        if (!$db) {
            throw new Exception('MySQL init failed');
        }
        $flags = 0;
        if ($this->ReadPropertyBoolean('SSL')) {
            $flags = MYSQLI_CLIENT_SSL;
        }
        if ($this->ReadPropertyBoolean('SSLDontVerify')) {
            $flags += MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
        }
        if (!@mysqli_real_connect(
            $db,
            $this->ReadPropertyString('Host'),
            $this->ReadPropertyString('Username'),
            $this->ReadPropertyString('Password'),
            $noDatabase ? '' : $this->ReadPropertyString('Database'),
            $this->ReadPropertyInteger('Port'),
            null,
            $flags
        )) {
            throw new Exception(mysqli_connect_error());
        }
        return $db;
    }

    private function dbCreateDatabase($db, $name)
    {
        $status = @mysqli_query($db, 'CREATE DATABASE ' . $name);
        if (!$status) {
            throw new Exception(mysqli_error($db));
        }
    }

    private function dbAddColumn($column)
    {
        return sprintf('%s %s %s %s', $column['Field'], $column['Type'], ((!isset($column['Null']) || $column['Null']) == 'NO' ? 'NOT NULL' : 'NULL'), (isset($column['Extra']) ? $column['Extra'] : ''));
    }

    private function dbCreateTable($db, $name, $columns, $primaryKey)
    {
        $queryParts = [];
        foreach ($columns as $column) {
            $queryParts[] = $this->dbAddColumn($column);
        }
        $queryParts[] = sprintf('PRIMARY KEY (%s)', $primaryKey);

        if (!@mysqli_query($db, sprintf('CREATE TABLE %s (%s)', $name, implode(',', $queryParts)))) {
            throw new Exception(mysqli_error($db));
        }
    }

    private function dbDescribeTable($db, $name)
    {
        $rows = @mysqli_query($db, 'DESCRIBE ' . $name);
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        $columns = [];
        while ($row = mysqli_fetch_assoc($rows)) {
            $items = [];
            foreach ($row as $key => $value) {
                $items[$key] = $value;
            }
            $columns[] = $items;
        }
        return $columns;
    }

    private function dbUpgradeTable($db, $name, $columns)
    {
        $tableColumns = $this->dbDescribeTable($db, $name);

        $getTableColumn = function ($field) use ($tableColumns)
        {
            foreach ($tableColumns as $column) {
                if ($column['Field'] == $field) {
                    return $column;
                }
            }
            return null;
        };

        $getColumn = function ($field) use ($columns)
        {
            foreach ($columns as $column) {
                if ($column['Field'] == $field) {
                    return $column;
                }
            }
            return null;
        };

        foreach ($columns as $column) {
            $tableColumn = $getTableColumn($column['Field']);

            //Add missing fields
            if (!$tableColumn) {
                $this->SendDebug('MIGRATE', 'Add column: ' . $column['Field'], 0);
                if (!@mysqli_query($db, sprintf('ALTER TABLE %s ADD %s', $name, $this->dbAddColumn($column)))) {
                    throw new Exception(mysqli_error($db));
                }
            }
        }

        foreach ($tableColumns as $tableColumn) {
            $column = $getColumn($tableColumn['Field']);

            //Remove missing fields
            if (!$column) {
                $this->SendDebug('MIGRATE', 'Remove column: ' . $tableColumn['Field'], 0);
                if (!@mysqli_query($db, sprintf('ALTER TABLE %s DROP COLUMN %s', $name, $tableColumn['Field']))) {
                    throw new Exception(mysqli_error($db));
                }
            }
        }

        foreach ($tableColumns as $tableColumn) {
            $column = $getColumn($tableColumn['Field']);

            //Skip already deleted columns
            if (!$column) {
                continue;
            }

            //Update field type
            if ($column['Type'] != $tableColumn['Type']) {
                $this->SendDebug('MIGRATE', 'Change type: ' . $tableColumn['Field'] . ' from ' . $column['Type'] . ' to ' . $tableColumn['Type'], 0);
                if (!@mysqli_query($db, sprintf('ALTER TABLE %s CHANGE %s %s %s', $name, $tableColumn['Field'], $tableColumn['Field'], $column['Type']))) {
                    throw new Exception(mysqli_error($db));
                }
            }
        }
    }

    private function dbHasIdentTable($db)
    {
        $rows = @mysqli_query($db, "SHOW TABLES LIKE 'ident'");
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        return mysqli_num_rows($rows) > 0;
    }

    private function dbHasDataTable($db)
    {
        $rows = @mysqli_query($db, "SHOW TABLES LIKE 'data'");
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        return mysqli_num_rows($rows) > 0;
    }

    private function dbHasFormatTable($db)
    {
        $rows = @mysqli_query($db, "SHOW TABLES LIKE 'format'");
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        return mysqli_num_rows($rows) > 0;
    }

    private function dbHasMeterTable($db)
    {
        $rows = @mysqli_query($db, "SHOW TABLES LIKE 'meter'");
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        return mysqli_num_rows($rows) > 0;
    }

    private function dbHasZoneTable($db)
    {
        $rows = @mysqli_query($db, "SHOW TABLES LIKE 'zone'");
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        return mysqli_num_rows($rows) > 0;
    }

    private function dbCreateIdentTable($db)
    {
        $this->dbCreateTable($db, 'ident', $this->tableIdent, 'id');
    }

    private function dbCreateDataTable($db)
    {
        $this->dbCreateTable($db, 'data', $this->tableData, 'id');
    }

    private function dbCreateFormatTable($db)
    {
        $this->dbCreateTable($db, 'format', $this->tableFormat, 'id');
    }

    private function dbCreateMeterTable($db)
    {
        $this->dbCreateTable($db, 'meter', $this->tableMeter, 'id');
    }

    private function dbCreateZoneTable($db)
    {
        $this->dbCreateTable($db, 'zone', $this->tableZone, 'id');
    }

    private function dbUpgradeIdentTable($db)
    {
        $this->dbUpgradeTable($db, 'ident', $this->tableIdent);
    }

    private function dbUpgradeDataTable($db)
    {
        $this->dbUpgradeTable($db, 'data', $this->tableData);
    }

    private function dbUpgradeMeterTable($db)
    {
        $this->dbUpgradeTable($db, 'meter', $this->tableMeter);
    }

    private function dbUpgradeZoneTable($db)
    {
        $this->dbUpgradeTable($db, 'zone', $this->tableZone);
    }

    private function dbUpgradeFormatTable($db)
    {
        $this->dbUpgradeTable($db, 'format', $this->tableFormat);
    }

    private function dbDropFormatTable($db)
    {
        if (!@mysqli_query($db, 'DROP TABLE format')) {
            throw new Exception(mysqli_error($db));
        }
    }

    private function dbFetchIdentList($db)
    {
        $rows = @mysqli_query($db, 'SELECT * FROM ident');
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        $result = [];
        while ($row = mysqli_fetch_assoc($rows)) {
            $result[] = $row;
        }
        return $result;
    }

    private function dbFetchIdentListWithLastData($db)
    {
        $rows = @mysqli_query($db, 'SELECT *, (SELECT timestamp FROM data WHERE identid = ident.id ORDER BY id DESC LIMIT 1) as timestamp FROM ident');
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        $result = [];
        while ($row = mysqli_fetch_assoc($rows)) {
            $result[] = $row;
        }
        return $result;
    }

    public function dbCheckIdent($db, string $ident, int $identid = 0)
    {
        //Make Precheck if ident is unique
        if ($identid == 0) {
            $stmt = mysqli_prepare($db, 'SELECT * FROM ident WHERE ident = ?');
            if (!$stmt) {
                throw new Exception(mysqli_error($db));
            }
            mysqli_stmt_bind_param($stmt, 's', $ident);
        }
        else {
            $stmt = mysqli_prepare($db, 'SELECT * FROM ident WHERE ident = ? AND id != ?');
            if (!$stmt) {
                throw new Exception(mysqli_error($db));
            }
            mysqli_stmt_bind_param($stmt, 'si', $ident, $identid);
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            throw new Exception('Ident has to be unique');
        }

        mysqli_stmt_close($stmt);
    }

    private function dbAddIdent($db, $active, $variableID, $aggregationType, $ident, $unit, $meterid, $tariff, $zoneid, $usageType, $description)
    {
        $stmt = mysqli_prepare($db, 'INSERT INTO ident (active, variableid, aggregationtype, ident, unit, meterid, tariff, zoneid, usage_type, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'iiissisiss', $active, $variableID, $aggregationType, $ident, $unit, $meterid, $tariff, $zoneid, $usageType, $description);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return mysqli_insert_id($db);
    }

    private function dbUpdateIdent($db, $identid, $active, $variableID, $aggregationType, $ident, $unit, $meterID, $tariff, $zoneID, $usageType, $description)
    {
        $stmt = mysqli_prepare($db, 'UPDATE ident SET active = ?, variableid = ?, aggregationtype = ?, ident = ?, unit = ?, meterid = ?, tariff = ?, zoneid  = ?, usage_type = ?, description = ? WHERE id = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'iiissisissi', $active, $variableID, $aggregationType, $ident, $unit, $meterID, $tariff, $zoneID, $usageType, $description, $identid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    private function dbDeleteIdent($db, $identid)
    {
        $stmt = mysqli_prepare($db, 'DELETE FROM ident WHERE id = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'i', $identid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    private function dbAddData($db, $identid, $timeStamp, $value)
    {
        $stmt = mysqli_prepare($db, 'INSERT INTO data (identid, timestamp, value) VALUES (?, ?, ?)');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'iid', $identid, $timeStamp, $value);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return mysqli_insert_id($db);
    }

    private function dbAddFormat($db, $identid, $ident)
    {
        $format = $this->identFormats[$this->ReadPropertyInteger('Format')];

        if (!preg_match('/' . $format . '/', $ident, $matches)) {
            echo 'Ident does not match format';
        }

        $stmt = mysqli_prepare($db, 'INSERT INTO format (identid, property, property_detail, ifp_building_designation, ifp_room_designation, system_number, component_building_designation, component_room_designation, circuit_diagram_page, classification_scheme, circuit_diagram_number, function_identifier, data_point, additional_field_01, additional_field_02, additional_field_03, additional_field_04, additional_field_05, additional_field_06) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'issssissisissssssss', $identid, $matches[1], $matches[2], $matches[3], $matches[4], $matches[5], $matches[6], $matches[7], $matches[8], $matches[9], $matches[10], $matches[11], $matches[12], $matches[13], $matches[14], $matches[15], $matches[16], $matches[17], $matches[18]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return mysqli_insert_id($db);
    }

    private function dbUpdateFormat($db, $identid, $ident)
    {
        $format = $this->identFormats[$this->ReadPropertyInteger('Format')];

        if (!preg_match('/' . $format . '/', $ident, $matches)) {
            echo 'Ident does not match format';
        }

        $stmt = mysqli_prepare($db, 'UPDATE format SET property = ?, property_detail = ?, ifp_building_designation = ?, ifp_room_designation = ?, system_number = ?, component_building_designation = ?, component_room_designation = ?, circuit_diagram_page = ?, classification_scheme = ?, circuit_diagram_number = ?, function_identifier = ?, data_point = ?, additional_field_01 = ?, additional_field_02 = ?, additional_field_03 = ?, additional_field_04 = ?, additional_field_05 = ?, additional_field_06 = ? WHERE identid = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'ssssissisissssssssi', $matches[1], $matches[2], $matches[3], $matches[4], $matches[5], $matches[6], $matches[7], $matches[8], $matches[9], $matches[10], $matches[11], $matches[12], $matches[13], $matches[14], $matches[15], $matches[16], $matches[17], $matches[18], $identid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    private function dbDeleteFormat($db, $identid)
    {
        $stmt = mysqli_prepare($db, 'DELETE FROM format WHERE identid = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'i', $identid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    private function dbAddZone($db, $location, $area, $netArea, $economicUnit, $buildingUnit, $buildingAssignment, $constructionDate)
    {
        $stmt = mysqli_prepare($db, 'INSERT INTO zone (location, area, net_area, economic_unit, building_unit, building_assignment, construction_date) VALUES (?, ?, ?, ?, ?, ?, ?)');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'siissss', $location, $area, $netArea, $economicUnit, $buildingUnit, $buildingAssignment, $constructionDate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return mysqli_insert_id($db);
    }

    private function dbUpdateZone($db, $zoneID, $location, $area, $netArea, $economicUnit, $buildingUnit, $buildingAssignment, $constructionDate)
    {
        $stmt = mysqli_prepare($db, 'UPDATE zone SET location = ?, area = ?, net_area = ?, economic_unit = ?, building_unit = ?, building_assignment = ?, construction_date = ? WHERE id = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, 'siissssi', $location, $area, $netArea, $economicUnit, $buildingUnit, $buildingAssignment, $constructionDate, $zoneID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    private function dbFetchZones($db)
    {
        $rows = @mysqli_query($db, 'SELECT id, location, area FROM zone');
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        $result = [];
        while ($row = mysqli_fetch_assoc($rows)) {
            $result[] = $row;
        }
        return $result;
    }

    private function dbFetchZone($db, $zoneID)
    {
        $stmt = mysqli_prepare($db, 'SELECT * FROM zone WHERE id = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }
        mysqli_stmt_bind_param($stmt, 'i', $zoneID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $location, $area, $netArea, $economicUnit, $buildingUnit, $buildingAssignment, $constructionDate);

        $result = [];
        while ($rows = mysqli_stmt_fetch($stmt)) {
            $result = [
                'location'            => $location,
                'area'                => $area,
                'net_area'            => $netArea,
                'economic_unit'       => $economicUnit,
                'building_unit'       => $buildingUnit,
                'building_assignment' => $buildingAssignment,
                'construction_date'   => $constructionDate
            ];
        }
        return $result;
    }

    private function dbAddMeter($db, $meterNumber, $meterBKS, $meterDescription, $linkedID, $timestamp = 0)
    {
        $stmt = mysqli_prepare($db, 'INSERT INTO meter (meter_number, bks, description, timestamp, linkedid) VALUES (?, ?, ?, ?, ?)');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }
        if ($timestamp == 0) {
            $timestamp = time();
        }
        mysqli_stmt_bind_param($stmt, 'sssii', $meterNumber, $meterBKS, $meterDescription, $timestamp, $linkedID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return mysqli_insert_id($db);
    }

    private function dbUpdateMeter($db, $meterID, $meterNumber, $meterBKS, $meterDescription)
    {
        $stmt = mysqli_prepare($db, 'UPDATE meter SET meter_number = ?, bks = ?, description = ?, timestamp = ? WHERE id = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }

        $timestamp = time();
        mysqli_stmt_bind_param($stmt, 'sssii', $meterNumber, $meterBKS, $meterDescription, $timestamp, $meterID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    private function dbFetchMeters($db)
    {
        $rows = @mysqli_query($db, 'SELECT id, meter_number, bks FROM meter WHERE linkedid = 0');
        if (!$rows) {
            throw new Exception(mysqli_error($db));
        }
        $result = [];
        while ($row = mysqli_fetch_assoc($rows)) {
            $result[] = $row;
        }
        return $result;
    }

    private function dbFetchMeter($db, $meterID)
    {
        $stmt = mysqli_prepare($db, 'SELECT * FROM meter WHERE id = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }
        mysqli_stmt_bind_param($stmt, 'i', $meterID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $meterNumber, $timestamp, $linkedid, $bks, $description);

        $result = [];
        while ($rows = mysqli_stmt_fetch($stmt)) {
            $result = [
                'meter_number' => $meterNumber,
                'timestamp'    => $timestamp,
                'linkedid'     => $linkedid,
                'bks'          => $bks,
                'description'  => $description
            ];
        }
        return $result;
    }

    private function dbMeterByNumber($db, $meterNumber)
    {
        $stmt = mysqli_prepare($db, 'SELECT id FROM meter WHERE meter_number = ?');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }
        mysqli_stmt_bind_param($stmt, 's', $meterNumber);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id);

        $result = [];
        while ($rows = mysqli_stmt_fetch($stmt)) {
            $result = [
                'id' => $id
            ];
        }
        return $result;
    }

    private function dbFetchMeterHistory($db, $meterID)
    {
        $stmt = mysqli_prepare($db, 'SELECT id, meter_number, timestamp, linkedid FROM meter WHERE linkedid = ? ORDER BY timestamp DESC');
        if (!$stmt) {
            throw new Exception(mysqli_error($db));
        }
        mysqli_stmt_bind_param($stmt, 'i', $meterID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $meterNumber, $timestamp, $linkedid);

        $result = [];
        while ($rows = mysqli_stmt_fetch($stmt)) {
            $result[] = [
                'meter_number' => $meterNumber,
                'timestamp'    => $timestamp,
                'linkedid'     => $linkedid
            ];
        }
        return $result;
    }

    private function dbConfigure($db)
    {
        //Create table if not existent
        if (!$this->dbHasIdentTable($db)) {
            $this->dbCreateIdentTable($db);
        } else {
            $this->dbUpgradeIdentTable($db);
        }
        if (!$this->dbHasDataTable($db)) {
            $this->dbCreateDataTable($db);
        } else {
            $this->dbUpgradeDataTable($db);
        }
        if (!$this->dbHasMeterTable($db)) {
            $this->dbCreateMeterTable($db);
        } else {
            $this->dbUpgradeMeterTable($db);
        }
        if (!$this->dbHasZoneTable($db)) {
            $this->dbCreateZoneTable($db);
        } else {
            $this->dbUpgradeZoneTable($db);
        }

        //We only need a format table if we have a supported format
        if ($this->ReadPropertyInteger('Format') == 0) {
            if ($this->dbHasFormatTable($db)) {
                $this->dbDropFormatTable($db);
            }
        } else {
            if (!$this->dbHasFormatTable($db)) {
                $this->dbCreateFormatTable($db);
            } else {
                $this->dbUpgradeFormatTable($db);
            }
        }
    }

    private function GetIdentListValues()
    {

        //Populate Variables tables
        if ($this->GetStatus() == IS_ACTIVE) {
            $format = $this->identFormats[$this->ReadPropertyInteger('Format')];

            $identList = $this->dbFetchIdentList($this->dbConnect());

            $values = [];
            foreach ($identList as $ident) {
                $state = $this->Translate('OK');
                if (!IPS_VariableExists(intval($ident['variableid']))) {
                    $state = $this->Translate('Variable missing');
                } elseif (!preg_match('/' . $format . '/', $ident['ident'])) {
                    $state = $this->Translate('Format mismatch');
                }

                $values[] = [
                    'IdentID'         => intval($ident['id']),
                    'Active'          => boolval($ident['active']),
                    'VariableID'      => intval($ident['variableid']),
                    'Unit'            => $ident['unit'],
                    'AggregationType' => intval($ident['aggregationtype']),
                    'MeterID'         => intval($ident['meterid']),
                    'Tariff'          => $ident['tariff'],
                    'ZoneID'          => intval($ident['zoneid']),
                    'UsageType'       => $ident['usage_type'],
                    'Description'     => $ident['description'],
                    'Ident'           => $ident['ident'],
                    'State'           => $state
                ];
            }

            return $values;
        }

        return [];
    }

    private function UpdateArchive()
    {

        //Only update if database connection is active
        if ($this->GetStatus() == IS_ACTIVE) {
            //Ensure our ident table is in sync with selected variables/formats
            $identList = $this->dbFetchIdentList($this->dbConnect());

            //Ensure we have every variable logged, which is used for sync
            $archiveID = IPS_GetInstanceListByModuleID('{43192F0B-135B-4CE7-A0A7-1475603F3060}')[0];
            $needApplyChanges = false;
            foreach ($identList as $ident) {
                if (IPS_VariableExists($ident['variableid'])) {
                    $logged = AC_GetLoggingStatus($archiveID, $ident['variableid']);
                    if (!$logged) {
                        AC_SetLoggingStatus($archiveID, $ident['variableid'], true);
                        $needApplyChanges = true;
                    }
                    $type = AC_GetAggregationType($archiveID, $ident['variableid']);
                    if ($type != $ident['aggregationtype']) {
                        AC_SetAggregationType($archiveID, $ident['variableid'], $ident['aggregationtype']);
                        $needApplyChanges = true;
                    }
                }
            }
            if ($needApplyChanges) {
                IPS_ApplyChanges($archiveID);
            }
        }
    }

    private function UpdateLinks()
    {

        //Only update if database connection is active
        if ($this->GetStatus() == IS_ACTIVE) {
            $identList = $this->dbFetchIdentList($this->dbConnect());

            $idList = [];

            //Create new ones
            foreach ($identList as $ident) {
                //Create/Update links
                if (IPS_VariableExists(intval($ident['variableid']))) {
                    //Maintain IdList which we need later on
                    $idList[] = intval($ident['variableid']);

                    $lid = @IPS_GetObjectIDByIdent('Link' . $ident['variableid'], $this->InstanceID);
                    if (!$lid) {
                        $lid = IPS_CreateLink();
                        IPS_SetParent($lid, $this->InstanceID);
                        IPS_SetIdent($lid, 'Link' . $ident['variableid']);
                        IPS_SetLinkTargetID($lid, intval($ident['variableid']));
                    }
                    $name = $ident['ident'] . ' (' . IPS_GetName(intval($ident['variableid'])) . ')';
                    if (IPS_GetName($lid) != $name) {
                        IPS_SetName($lid, $name);
                    }
                }
            }

            //Delete removed ones
            foreach (IPS_GetChildrenIDs($this->InstanceID) as $id) {
                if (IPS_LinkExists($id)) {
                    if (!in_array(IPS_GetLink($id)['TargetID'], $idList)) {
                        IPS_DeleteLink($id);
                    }
                }
            }
        }
    }

    private function getZoneOptions()
    {
        $db = $this->dbConnect();
        $zones = $this->dbFetchZones($db);
        $options = [['caption' => $this->Translate('(none)'), 'value' => -1]];
        foreach ($zones as $zone) {
            $options[] =
            [
                'caption' => sprintf('%s (%sm²)', $zone['location'], $zone['area']),
                'value'   => intval($zone['id'])
            ];
        }

        return $options;
    }

    private function getMeterOptions()
    {
        $db = $this->dbConnect();
        $meters = $this->dbFetchMeters($db);
        $options = [['caption' => $this->Translate('(none)'), 'value' => -1]];
        foreach ($meters as $meter) {
            $options[] =
            [
                'caption' => sprintf('%s (%s)', $meter['meter_number'], $meter['bks']),
                'value'   => intval($meter['id'])
            ];
        }

        return $options;
    }

    private function updateMeterSelect()
    {
        $this->UpdateFormfield('EditMeter', 'options', json_encode($this->getMeterOptions()));
        $this->UpdateFormfield('HistoryMeter', 'options', json_encode($this->getMeterOptions()));
    }

    private function updateList()
    {
        $data = json_decode($this->GetConfigurationForm(), true);
        $data['actions'][0]['columns'][6]['edit']['options'] = $this->getMeterOptions();
        $data['actions'][0]['columns'][8]['edit']['options'] = $this->getZoneOptions();
        $data['actions'][0]['values'] = $this->getIdentListValues();

        $this->UpdateFormField('IdentList', 'values', json_encode($this->GetIdentListValues()));
        $this->UpdateFormField('IdentList', 'columns', json_encode($data['actions'][0]['columns']));
    }
}
