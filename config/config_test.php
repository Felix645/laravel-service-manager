<?php

use Neon\ServiceManager\Mocks\AnotherInterface;
use Neon\ServiceManager\Mocks\ClientImplementation;
use Neon\ServiceManager\Mocks\DefaultImplementation;
use Neon\ServiceManager\Mocks\TestInterface;
use Neon\ServiceManager\Mocks\VersionImplementation;

return [

    /*
    |--------------------------------------------------------------------------
    | Version slug key
    |--------------------------------------------------------------------------
    |
    | This value specifies the route parameter key used in your application
    | for API versioning.
    |
    | Example: Route::get('/{version}');
    |
    */

    'version_slug_key' => 'version',

    /*
    |--------------------------------------------------------------------------
    | Client slug key
    |--------------------------------------------------------------------------
    |
    | This value specifies the route parameter key used in your application
    | for identifying different clients or tenants.
    |
    | Example: Route::get('/{client_id}');
    |
    */

    'client_slug_key' => 'client_id',

    /*
    |--------------------------------------------------------------------------
    | Interface list
    |--------------------------------------------------------------------------
    |
    | Here you can add interfaces which should be resolved by the Service Manager
    |
    | Example:
    |   'interfaces' => [
    |       SomeInterface::class,
    |       AnotherInterface::class
    |   ]
    */

    'interfaces' => [
        TestInterface::class,
        AnotherInterface::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default interface mapping
    |--------------------------------------------------------------------------
    |
    | Implementations specified under this key will be used when no other
    | implementation is found. (Lowest priority)
    |
    | Example:
    |   'default' => [
    |       SomeInterface::class => SomeImplementation::class,
    |       AnotherInterface::class => AnotherImplementation::class,
    |   ]
    */

    'default' => [
        TestInterface::class => DefaultImplementation::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Version interface mapping
    |--------------------------------------------------------------------------
    |
    | Implementations specified under this key will be used when no
    | client implementation was found and the interface is present under
    | the corresponding version
    |
    | Example:
    |   'versions' => [
    |       'v1' => [
    |           SomeInterface::class => SomeImplementation::class,
    |       ],
    |       'v2' => [
    |           AnotherInterface::class => AnotherImplementation::class,
    |       ]
    |   ]
    */

    'versions' => [
        'v2' => [
            TestInterface::class => VersionImplementation::class,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Client interface mapping
    |--------------------------------------------------------------------------
    |
    | Implementations specified under this key will only be used when an
    | implementation is present under the combination of the corresponding
    | version and client_id
    |
    | Example:
    |   'versions' => [
    |       'v1' => [
    |           'some_client' => [
    |               SomeInterface::class => SomeImplementation::class,
    |           ]
    |       ],
    |       'v2' => [
    |           'another_client' => [
    |               AnotherInterface::class => AnotherImplementation::class,
    |           ]
    |       ]
    |   ]
    */

    'clients' => [
        'v3' => [
            'test_client' => [
                TestInterface::class => ClientImplementation::class,
            ]
        ]
    ]
];
