<?php return array(
    'root' => array(
        'name' => 'root/app',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'project',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'monolog/monolog' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '479c936d2c230d8c467bdb3882afab45a6e6b8ad',
            'type' => 'library',
            'install_path' => __DIR__ . '/../monolog/monolog',
            'aliases' => array(
                0 => '3.x-dev',
            ),
            'dev_requirement' => false,
        ),
        'myclabs/php-enum' => array(
            'pretty_version' => '1.8.4',
            'version' => '1.8.4.0',
            'reference' => 'a867478eae49c9f59ece437ae7f9506bfaa27483',
            'type' => 'library',
            'install_path' => __DIR__ . '/../myclabs/php-enum',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'php-mqtt/client' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => '9c2156b54372225ab6a7158e526291d7d73120b9',
            'type' => 'library',
            'install_path' => __DIR__ . '/../php-mqtt/client',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'psr/log' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => 'fe5ea303b0887d5caefd3d431c3e61ad47037001',
            'type' => 'library',
            'install_path' => __DIR__ . '/../psr/log',
            'aliases' => array(
                0 => '3.x-dev',
            ),
            'dev_requirement' => false,
        ),
        'psr/log-implementation' => array(
            'dev_requirement' => false,
            'provided' => array(
                0 => '3.0.0',
            ),
        ),
        'root/app' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'project',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
