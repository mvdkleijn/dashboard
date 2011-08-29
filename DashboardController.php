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

class DashboardController extends PluginController {


    function __construct() {
        AuthUser::load();
        if (!(AuthUser::isLoggedIn())) {
            redirect(get_url('login'));
        }

        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/dashboard/views/sidebar'));
    }


    function index() {
        $this->display('dashboard/views/index', array(
            'log_entries' => Record::findAllFrom('DashboardLogEntry', 'created_on=created_on ORDER BY created_on DESC'),
        ));
    }


    function clear() {
        // TODO: replace this in future by Record's deleteAll routine.
        $pdo = Record::getConnection();
        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        
        if ($driver == 'mysql' || $driver == 'pgsql') {
            $sql = 'TRUNCATE '.Record::tableNameFromClassName('DashboardLogEntry');
        }
        
        if ($driver == 'sqlite') {
            $sql = 'DELETE FROM '.Record::tableNameFromClassName('DashboardLogEntry');
        }
        
        $pdo->exec($sql);

        redirect(get_url('plugin/dashboard/'));
    }

}
