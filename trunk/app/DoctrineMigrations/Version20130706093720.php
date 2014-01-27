<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130706093720 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");

        $this->addSql("ALTER TABLE statistique ADD nb_alertes_24 INT DEFAULT 0 NOT NULL");
        $this->addSql("ALTER TABLE statistique ADD nb_alertes_total INT DEFAULT 0 NOT NULL");
        $this->addSql("ALTER TABLE alerte_idee ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL");
     }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("ALTER TABLE alerte_idee DROP created_at");
        $this->addSql("ALTER TABLE statistique DROP nb_alertes_24");
        $this->addSql("ALTER TABLE statistique DROP nb_alertes_total");
    }
}
