<?php

namespace Yiisoft\Yii\Filesystem;

final class FileStorageConfigs
{
    private array $storageConfigs = [];

    public function __construct(array $storageConfigs)
    {
        $this->storageConfigs = $storageConfigs;
    }

    public function getConfigs(): array
    {
        return $this->storageConfigs;
    }
}
