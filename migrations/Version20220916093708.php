<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916093708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_frais_forfait ADD frais_forfais_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_frais_forfait ADD CONSTRAINT FK_BD293ECFE6A70FE7 FOREIGN KEY (frais_forfais_id) REFERENCES frais_forfais (id)');
        $this->addSql('CREATE INDEX IDX_BD293ECFE6A70FE7 ON ligne_frais_forfait (frais_forfais_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_frais_forfait DROP FOREIGN KEY FK_BD293ECFE6A70FE7');
        $this->addSql('DROP INDEX IDX_BD293ECFE6A70FE7 ON ligne_frais_forfait');
        $this->addSql('ALTER TABLE ligne_frais_forfait DROP frais_forfais_id');
    }
}
