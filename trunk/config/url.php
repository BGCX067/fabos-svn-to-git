<?php
return array(
    array('GET /', 'index'),
    array('GET /index/(\d+)/(\d+)', 'show'),
    array('GET /index/new', 'index::GET'),
    array('GET /index/tt', function(){echo 12323424;}),
    array('GET /index/cc', array('index', 'DELETE')),
);