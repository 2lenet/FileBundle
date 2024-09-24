# FileBundle

[![Validate](https://github.com/2lenet/FileBundle/actions/workflows/validate.yml/badge.svg)](https://github.com/2lenet/FileBundle/actions/workflows/validate.yml)
[![.github/workflows/test.yml](https://github.com/2lenet/FileBundle/actions/workflows/test.yml/badge.svg)](https://github.com/2lenet/FileBundle/actions/workflows/test.yml)
[![SymfonyInsight](https://insight.symfony.com/projects/79583c27-dbb5-4610-accd-1ee16b92008d/mini.svg)](https://insight.symfony.com/projects/79583c27-dbb5-4610-accd-1ee16b92008d)


Symfony bundle that standardize the way of handling data file associated with an entity

- [Installation](#Installation)
- [Customization](#Customization)
- [Usage](#Usage)

## Installation

The bundle is not yet on packagist make sure to add the following to your `composer.json` file:

```json
{
    "url": "https://github.com/2lenet/FileBundle",
    "type": "git"
}
```

Install with composer:

```shell
composer require 2lenet/file-bundle
```

## Usage

in your controller or service juste use the fileManager to get the db and absolute path to use to store your data.

```php
        $fileSpec = $this->fileManager->getLocalFilename(
            ENTITY::PDFSTORAGENAME,
            $object,
            "pdf"
        );
```

- This function take a first parameter which is the name of the store. Une one store for each field in each entity. It's a good practice to set a constant in the entitiy Class
- The second parameter is an object ( good to have a getId on it but not required ). Optionnally you can have a getDateForFilename to get the date to use for creating the folders.
- The third optionnal parameter is the extension to add to the file ( default .bin). Don't set the .

The function return a FileSpec object with two attribute
- dbPath is the path to use to store in your database ( relative from the projectDir )
- absPath is the filename to use to write your data ( open it with standard functions )

Path are build this way ( $projectDir / data / $storeName / Y / M / D / $objet->getId() . $ext )
if the folder does not exist it is created with the right right.
Y/M/D is the year, month and day from the $object->getDateForFilename() if it exist, instead it use the today date.

```php
        file_put_contents($fileSpec->absPath,$youdata);
        $object->setLocalPdf($fileSpec->dbPath);
```

