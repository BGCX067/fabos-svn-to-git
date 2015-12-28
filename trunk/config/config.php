<?php
return array(
    'root_dir'          => __DIR__.'/../',
    'config_dir'        => __DIR__.'/',
    'core_dir'          => __DIR__.'/../core/',
    'lib_dir'           => __DIR__.'/../lib/',
    'log_dir'           => __DIR__.'/../log/',
    'model_dir'         => __DIR__.'/../model/',
    'cache_dir'         => __DIR__.'/../cache/',
    'plugin_dir'        => __DIR__.'/../plugin/',
    'template_dir'      => __DIR__.'/../template/',
    'web_dir'           => __DIR__.'/../web/',

    'db_type'           => '',
    'db_name'           => '',
    'db_user'           => '',
    'db_pwd'            => '',
    'db_port'           => '',
    'db_prefix'         => 'fabos_',

    'is_debug'          => TRUE,
    'error_level'       => E_ALL^E_NOTICE,
    'timezone'          => 'Asia/Shanghai',

    'session_type'      => 'file',

    'cache_type'        => 'file',
    'cache_time'        => 86400,

    'mem_host'          => '',
    'mem_port'          => '',
    'mem_timeout'       => '',
    'mem_expire'        => '',

    'css_file'          => 'combo,jquery-ui-1.8.4.custom',
    'js_file'           => 'jquery-1.4.2.min,jquery-ui-1.8.4.custom.min',

    'page_charset'      => 'utf-8',
    'page_title'        => 'Fabos - PHP framework',
    'page_description'  => '',
    'page_keywords'     => '',
);