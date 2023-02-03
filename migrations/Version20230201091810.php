<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201091810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hike ADD slug VARCHAR(255) NOT NULL, ADD cover VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD season VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE point_of_interest ADD poster VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_of_interest DROP poster, DROP updated_at');
        $this->addSql('ALTER TABLE hike DROP slug, DROP cover, DROP updated_at, DROP season');
    }
}
