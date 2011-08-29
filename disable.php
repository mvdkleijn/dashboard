<?php

/*
 * Dashboard - Wolf CMS dashboard plugin
 *
 * Copyright (c) 2008-2011 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 */

/* Prevent direct access. */
if (!defined('IN_CMS')) { exit(); }

$pdo = Record::getConnection();

$table = TABLE_PREFIX."dashboard_log";
$pdo->exec("DROP TABLE $table");
