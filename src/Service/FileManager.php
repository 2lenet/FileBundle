<?php

namespace Lle\FileBundle\Service;

use Lle\FileBundle\FileSpec;
use Symfony\Component\HttpKernel\KernelInterface;

class FileManager
{
    public function __construct(KernelInterface $kernel)
    {
        $this->rootDir = $kernel->getProjectDir();
    }

    public function getLocalFilename(string $storageKey, object $entity, string $ext = ".bin"): FileSpec
    {
        if (method_exists($entity, 'getId')) {
            $id = $entity->getId();
        } else {
            $id = uniqid();
        }
        if (method_exists($entity, 'getDateForFilename')) {
            $date = $entity->getDateForFilename();
        } else {
            $date = new \DateTime();
        }
        $y = $date->format('Y');
        $m = $date->format('m');
        $d = $date->format('d');
        $dbPath = "data/" . $storageKey . "/$y/$m/$d/" . $id . "." . $ext;
        $absPath = $this->rootDir . DIRECTORY_SEPARATOR . $dbPath;

        if (!is_dir($absPath)) {
            mkdir($absPath, 0777, true);
        }
        $spec = new FileSpec();
        $spec->dbPath = $dbPath;
        $spec->absPath = $absPath;
        return $spec;
    }
}
