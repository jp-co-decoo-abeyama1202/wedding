<?php

return array(
    'default' => 'redis',
    'connections' => array(
            'redis' => array(
                'driver' => 'redis',
                'queue'  => 'default',
            ),
    ),
    'failed' => array(
        'database' => 'mysql', 'table' => 'failed_jobs',
    ),
);
