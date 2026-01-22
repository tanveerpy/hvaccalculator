<?php
require_once __DIR__ . '/src/Logic/ClimateData.php';
echo json_encode(\Logic\ClimateData::DATA, JSON_PRETTY_PRINT);
