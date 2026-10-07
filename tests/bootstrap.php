<?php

$package = dirname(__DIR__);
$sharedVendor = dirname($package) . '/.ibtest/vendor';
$localVendor = $package . '/vendor';
$vendor = is_file($localVendor . '/autoload.php') ? $localVendor : $sharedVendor;

if (! is_file($vendor . '/autoload.php')) {
    throw new RuntimeException('Install development dependencies or use the shared .ibtest environment.');
}

$loader = require $vendor . '/autoload.php';

// The shared test environment resolves IlBronza dependencies to sibling checkouts.
if ($vendor === $sharedVendor) {
    foreach (glob(dirname($package) . '/*/composer.json') as $manifest) {
        $metadata = json_decode(file_get_contents($manifest), true, flags: JSON_THROW_ON_ERROR);
        foreach ($metadata['autoload']['psr-4'] ?? [] as $namespace => $paths) {
            $loader->addPsr4($namespace, array_map(
                fn ($path) => dirname($manifest) . '/' . $path, (array) $paths
            ), true);
        }
    }
    $compatibility = dirname($package) . '/Crud/src/Support/activitylog_compatibility.php';
    if (is_file($compatibility)) {
        require_once $compatibility;
    }
}

$loader->addPsr4('IlBronza\\Clients\\Tests\\', __DIR__, true);
$loader->addPsr4('App\\', __DIR__ . '/Fixtures/App', true);
