<?php

namespace Yiisoft\Yii\Filesystem;

use League\Flysystem\FilesystemAdapter;
use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Factory\Factory;

final class FileStorageServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $factory = new Factory();
        $configs = $container->get(FileStorageConfigs::class)->getConfigs();
        foreach ($configs as $alias => $config) {
            $this->validateAdapter($alias, $config);
            $configParams = $config['config'] ?? [];
            $aliases = $config['aliases'] ?? [];
            $adapter = $factory->create($config['adapter']);
            $container->set($alias, fn () => new Filesystem($adapter, $aliases, $configParams));
        }
    }

    private function validateAdapter(string $alias, array $config): void
    {
        $adapter = $config['adapter']['__class'] ?? false;
        if (!$adapter) {
            throw new \RuntimeException("Adapter is not defined in the \"$alias\" storage config.");
        }

        if (!$adapter instanceof FilesystemAdapter) {
            throw new \RuntimeException('Adapter must implement \League\Flysystem\FilesystemAdapter interface.');
        }
    }
}
