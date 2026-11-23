<?php
// EXAMPLE configuration - replace the servers below with your own.
// UKAZKOVA konfigurace - nahradte servery nize vlastnimi.
return array(
    new AdminerLoginServers(array(
        // MariaDB / MySQL (driver 'server')
        'Server1 (MariaDB)' => array('server' => 'server1.example.com', 'driver' => 'server'),
        'Server2 (MariaDB)' => array('server' => 'server2.example.com', 'driver' => 'server'),
        'Server3 (MariaDB)' => array('server' => 'server3.example.com', 'driver' => 'server'),

        // MS SQL (driver 'mssql')
        'Server4 (MS SQL)' => array('server' => 'server4.example.com', 'driver' => 'mssql'),
        'Server5 (MS SQL)' => array('server' => 'server5.example.com', 'driver' => 'mssql'),
        'Server6 (MS SQL)' => array('server' => 'server6.example.com', 'driver' => 'mssql'),
        'Server7 (MS SQL)' => array('server' => 'server7.example.com', 'driver' => 'mssql'),
        'Server8 (MS SQL)' => array('server' => 'server8.example.com', 'driver' => 'mssql'),
        'Server9 (MS SQL)' => array('server' => 'server9.example.com', 'driver' => 'mssql'),
        'Server10 (MS SQL)' => array('server' => 'server10.example.com', 'driver' => 'mssql'),
        'Server11 (MS SQL)' => array('server' => 'server11.example.com', 'driver' => 'mssql'),
        'Server12 (MS SQL)' => array('server' => 'server12.example.com', 'driver' => 'mssql'),
        'Server13 (MS SQL)' => array('server' => 'server13.example.com', 'driver' => 'mssql'),
        'Server14 (MS SQL)' => array('server' => 'server14.example.com', 'driver' => 'mssql'),
        'Server15 (MS SQL)' => array('server' => 'server15.example.com', 'driver' => 'mssql'),
    )),
    new AdminerBreadcrumbConfirm(),
);
