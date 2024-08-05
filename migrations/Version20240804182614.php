<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240804182614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coupon ADD tax_number VARCHAR(14) NOT NULL, ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F024584665A FOREIGN KEY (product_id) REFERENCES `product` (id)');
        $this->addSql('CREATE INDEX IDX_64BF3F024584665A ON coupon (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `coupon` DROP FOREIGN KEY FK_64BF3F024584665A');
        $this->addSql('DROP INDEX IDX_64BF3F024584665A ON `coupon`');
        $this->addSql('ALTER TABLE `coupon` DROP tax_number, DROP product_id');
    }
}
