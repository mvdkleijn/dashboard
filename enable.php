<?php

/*
 * Dashboard - Wolf CMS dashboard plugin
 *
 * Copyright (c) 2011 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (c) 2008-2011 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 */

/* Prevent direct access. */
if (!defined('IN_CMS')) { exit(); }

$pdo = Record::getConnection();
$driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
$table = TABLE_PREFIX."dashboard_log";

/* MySQL schema */
if ($driver == 'mysql') {
    $pdo->exec("CREATE TABLE $table (
        id          INT(11) NOT NULL AUTO_INCREMENT,
        ident       CHAR(16) NOT NULL,
        priority    INT NOT NULL,
        message     VARCHAR(255),
        username    VARCHAR(64),
        created_on  DATETIME DEFAULT NULL,
        PRIMARY KEY (id)
        ) DEFAULT CHARSET=utf8");
}

/* SQLite schema */
if ($driver == 'sqlite') {
    $pdo->exec("CREATE TABLE $table (
        id          INTEGER PRIMARY KEY AUTOINCREMENT,
        ident       CHAR(16) NOT NULL,
        priority    INT NOT NULL,
        message     VARCHAR(255),
        username    VARCHAR(64),
        created_on  DATETIME DEFAULT NULL
        )");
}

/* PostgreSQL schema */
if ($driver == 'pgsql') {
    $pdo->exec("CREATE TABLE $table (
        id          serial,
        ident       character varying(16) NOT NULL,
        priority    integer NOT NULL,
        message     character varying(255),
        username    character varying(64),
        created_on  timestamp DEFAULT NULL,
        PRIMARY KEY (id)
        )");
    
    $pdo->exec("ALTER SEQUENCE $table id_seq RESTART WITH 1");
}

