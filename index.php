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

define('DASHBOARD_LOG_EMERG',   0);
define('DASHBOARD_LOG_ALERT',   1);
define('DASHBOARD_LOG_CRIT',    2);
define('DASHBOARD_LOG_ERR',     3);
define('DASHBOARD_LOG_WARNING', 4);
define('DASHBOARD_LOG_NOTICE',  5);
define('DASHBOARD_LOG_INFO',    6);
define('DASHBOARD_LOG_DEBUG',   7);


Plugin::setInfos(array(
    'id'                    => 'dashboard',
    'title'                 => __('Dashboard'),
    'description'           => __('Keep up to date with what is happening with your site.'),
    'version'               => '1.0',
    'license'               => 'MIT',
    'author'                => 'Martijn van der Kleijn (original Mika Tuupola)',
//    'update_url'            => '',
    'website'               => 'https://github.com/mvdkleijn/dashboard',
    'require_wolf_version'  => '0.7.0'
));

    
AutoLoader::addFolder(dirname(__FILE__).'/models');

Observer::observe('log_event', 'dashboard_log_event');

function dashboard_log_event($message, $ident='misc', $priority=DASHBOARD_LOG_NOTICE) {
    /* BC. Order of parameters was swapped in 0.4.0. */
    if (is_integer($ident)) {
        $warning = __('Message below from <b>:ident</b> uses old Dashboard API.', array(':ident' => $priority));
        dashboard_log_event($warning, 'dashboard', DASHBOARD_LOG_WARNING);

        $data['ident'] = $priority;
        $data['priority'] = $ident;
    }
    else {
        $data['ident'] = $ident;
        $data['priority'] = $priority;
    }
    $data['message'] = $message;
    $entry = new DashboardLogEntry($data);
    $entry->save();
}
    
/* Stuff for backend. */
if (defined('CMS_BACKEND')) {

    AutoLoader::addFolder(dirname(__FILE__).'/lib');

    Plugin::addController('dashboard', __('Dashboard'), "admin_view", true);

    Observer::observe('page_edit_after_save', 'dashboard_log_page_edit');
    Observer::observe('page_add_after_save', 'dashboard_log_page_add');
    Observer::observe('page_delete', 'dashboard_log_page_delete');

    Observer::observe('layout_after_delete', 'dashboard_log_layout_delete');
    Observer::observe('layout_after_add', 'dashboard_log_layout_add');
    Observer::observe('layout_after_edit', 'dashboard_log_layout_edit');

    Observer::observe('snippet_after_delete', 'dashboard_log_snippet_delete');
    Observer::observe('snippet_after_add', 'dashboard_log_snippet_add');
    Observer::observe('snippet_after_edit', 'dashboard_log_snippet_edit');

    Observer::observe('comment_after_delete', 'dashboard_log_comment_delete');
    Observer::observe('comment_after_add', 'dashboard_log_comment_add');
    Observer::observe('comment_after_edit', 'dashboard_log_comment_edit');
    Observer::observe('comment_after_approve', 'dashboard_log_comment_approve');
    Observer::observe('comment_after_unapprove', 'dashboard_log_comment_unapprove');

    Observer::observe('plugin_after_enable', 'dashboard_log_plugin_enable');
    Observer::observe('plugin_after_disable', 'dashboard_log_plugin_disable');

    Observer::observe('admin_login_success', 'dashboard_log_admin_login');
    Observer::observe('admin_login_failed', 'dashboard_log_admin_login_failure');
    Observer::observe('admin_after_logout', 'dashboard_log_admin_logout');



    /* Page */
    function dashboard_log_page_add($page) {
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('page/edit/'.$page->id), $page->title);
        $message = __('Page <b>:title</b> was created by :name', array(':title' => $linked_title,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_page_edit($page) {
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('page/edit/'.$page->id), $page->title);
        $message = __('Page <b>:title</b> was revised by :name', array(':title' => $linked_title,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_page_delete($page) {
        $message = __('Page <b>:title</b> was deleted by :name', array(':title' => $page->title,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    
    /* Layout */
    function dashboard_log_layout_delete($layout) {
        $message = __('Layout <b>:title</b> was deleted by :name', array(':title' => $layout->name,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_layout_add($layout) {
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('layout/edit/'.$layout->id), $layout->name);
        $message = __('Layout <b>:title</b> was created by :name', array(':title' => $linked_title,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_layout_edit($layout) {
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('layout/edit/'.$layout->id), $layout->name);
        $message = __('Layout <b>:title</b> was revised by :name', array(':title' => $linked_title,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    
    /* Snippet */
    function dashboard_log_snippet_delete($snippet) {
        $message = __('Snippet <b>:title</b> was deleted by :name', array(':title' => $snippet->name,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_snippet_add($snippet) {
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('snippet/edit/'.$snippet->id), $snippet->name);
        $message = __('Snippet <b>:title</b> was created by :name', array(':title' => $linked_title,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_snippet_edit($snippet) {
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('snippet/edit/'.$snippet->id), $snippet->name);
        $message = __('Snippet <b>:title</b> was revised by :name', array(':title' => $linked_title,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    /* Comment */
    function dashboard_log_comment_add($comment) {

        /*
          FIXME - This does not get called with SVN version of Frog?
          TODO: Fetch page title.
         */
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('plugin/comment/edit/'.$comment->id), 'posted a comment');
        $message = __(':name :title.', array(':name' => $comment->author_name,
            ':title' => $linked_title));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_comment_delete($comment) {

        /* TODO: Fetch page title. */
        $message = __(':admin_name deleted a comment by :author_name.', array(':author_name' => $comment->author_name,
            ':admin_name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_comment_approve($comment) {

        /* TODO: Fetch page title. */
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('plugin/comment/edit/'.$comment->id), 'comment');
        $message = __(':admin_name approved :title by :author_name.', array(':author_name' => $comment->author_name,
            ':title' => $linked_title,
            ':admin_name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_comment_unapprove($comment) {

        /* TODO: Fetch page title. */
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('plugin/comment/edit/'.$comment->id), 'comment');
        $message = __(':admin_name rejected :title by :author_name.', array(':author_name' => $comment->author_name,
            ':title' => $linked_title,
            ':admin_name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_comment_edit($comment) {

        /* TODO: Fetch page title. */
        $linked_title = sprintf('<a href="%s">%s</a>', get_url('plugin/comment/edit/'.$comment->id), 'comment');
        $message = __(':admin_name edited :title by :author_name.', array(':author_name' => $comment->author_name,
            ':title' => $linked_title,
            ':admin_name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    /* Plugin */
    function dashboard_log_plugin_enable($plugin) {
        $message = __('Plugin <b>:title</b> was enabled by :name', array(':title' => $plugin,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_plugin_disable($plugin) {
        $message = __('Plugin <b>:title</b> was disabled by :name', array(':title' => $plugin,
            ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }


    /* Admin */
    function dashboard_log_admin_login($username) {
        $message = __('User <b>:name</b> logged in.', array(':name' => $username));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_admin_login_failure($username) {
        $message = __('User <b>:name</b> failed logging in.', array(':name' => $username));
        dashboard_log_event($message, 'core');
    }


    function dashboard_log_admin_logout($username) {
        $message = __('User <b>:name</b> logged out.', array(':name' => $username));
        dashboard_log_event($message, 'core');
    }




} 
