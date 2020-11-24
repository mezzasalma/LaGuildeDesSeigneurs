<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124120415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players ADD gls_firstname VARCHAR(64) NOT NULL, ADD gls_lastname VARCHAR(64) NOT NULL, ADD gls_age INT NOT NULL, ADD gls_mirian INT NOT NULL, ADD gls_creation DATETIME NOT NULL, ADD gls_modification DATETIME NOT NULL, DROP firstname, DROP lastname, DROP mirian, DROP age, DROP creation, DROP modification, CHANGE email gls_email VARCHAR(128) NOT NULL, CHANGE identifier gls_identifier VARCHAR(40) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `players` ADD firstname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD lastname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD mirian INT NOT NULL, ADD age INT NOT NULL, ADD creation DATETIME NOT NULL, ADD modification DATETIME NOT NULL, DROP gls_firstname, DROP gls_lastname, DROP gls_age, DROP gls_mirian, DROP gls_creation, DROP gls_modification, CHANGE gls_email email VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_identifier identifier VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
