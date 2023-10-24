# Upgrade from versions 2.x to 3.0

## Upgrade to PHP 7.4 or higher

In order to use this bundle, you will need PHP 7.4 or higher.

## Move from fsi/doctrine-extensions-bundle to fsi/files for file upload

1. Configure `fsi/files` Symfony integration.
2. Replace all `fsi_file`, `fsi_image` and `fsi_removable_file` with `web_file`.
3. Replace `FSi\Bundle\ResourceRepositoryBundle\Model\ResourceFSiFile` with `FSi\Bundle\ResourceRepositoryBundle\Model\ResourceWebFile`
as the base class for your Resource entity class.
4. If you have existing files, you will need to correct the database path:

```php
<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

// Do not copy-paste the class itself, generate a new migration class via console
// command and only use the SQL statements.

final class Version20230320151333 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('SET SQL_SAFE_UPDATES = 0');

        // or whatever table / column name combination you have
        $this->addSql('UPDATE fsi_resource SET file_key_value = SUBSTRING(file_key_value, 2)');

        $this->addSql('SET SQL_SAFE_UPDATES = 1');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('SET SQL_SAFE_UPDATES = 0');

        $this->addSql('UPDATE fsi_resource SET file_key_value = CONCAT("/", file_key_value)');

        $this->addSql('SET SQL_SAFE_UPDATES = 1');
    }
}
```
