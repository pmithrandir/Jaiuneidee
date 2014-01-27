<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130630132334 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("CREATE SEQUENCE statistique_id_seq INCREMENT BY 1 MINVALUE 1 START 1");
        $this->addSql("CREATE TABLE statistique (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, nb_utilisateurs_connectes_24 INT DEFAULT 0 NOT NULL, nb_inscrits_24 INT DEFAULT 0 NOT NULL, nb_idees_24 INT DEFAULT 0 NOT NULL, nb_commentaires_24 INT DEFAULT 0 NOT NULL, nb_votes_24 INT DEFAULT 0 NOT NULL, nb_invitations_24 INT DEFAULT 0 NOT NULL, nb_inscrits_total INT DEFAULT 0 NOT NULL, nb_idees_total INT DEFAULT 0 NOT NULL, nb_votes_total INT DEFAULT 0 NOT NULL, nb_commentaires_total INT DEFAULT 0 NOT NULL, nb_invitations_total INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("DROP SEQUENCE statistique_id_seq CASCADE");
        $this->addSql("DROP TABLE statistique");
    }
}
