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
$table = TABLE_PREFIX."dashboard_log";

if ($pdo->exec("DROP TABLE IF EXISTS $table") === false) {
    Flash::set('error', __('Unable to drop table :tablename', array(':tablename' => $table)));
    redirect(get_url('setting'));
}