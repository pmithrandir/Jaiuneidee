<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130316104402 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("ALTER TABLE commentaire ALTER is_validated_by_admin SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE commentaire ALTER life SET  DEFAULT 500");
        $this->addSql("ALTER TABLE commentaire ALTER is_removed SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE commentaire ALTER is_moderated SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE theme ALTER is_moderated SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER is_published SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER is_removed SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER is_validated_by_admin SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER is_moderated SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER life SET  DEFAULT 2000");
        $this->addSql("ALTER TABLE invitation ALTER sent SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE localisation ADD niveau INT DEFAULT 0 NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("ALTER TABLE commentaire ALTER is_validated_by_admin SET ");
        $this->addSql("ALTER TABLE commentaire ALTER life SET ");
        $this->addSql("ALTER TABLE commentaire ALTER is_removed SET ");
        $this->addSql("ALTER TABLE commentaire ALTER is_moderated SET ");
        $this->addSql("ALTER TABLE idee ALTER is_published SET ");
        $this->addSql("ALTER TABLE idee ALTER is_removed SET ");
        $this->addSql("ALTER TABLE idee ALTER is_validated_by_admin SET ");
        $this->addSql("ALTER TABLE idee ALTER is_moderated SET ");
        $this->addSql("ALTER TABLE idee ALTER life SET ");
        $this->addSql("ALTER TABLE Invitation ALTER sent SET ");
        $this->addSql("ALTER TABLE theme ALTER is_moderated SET ");
        $this->addSql("ALTER TABLE localisation DROP niveau");
    }
}
