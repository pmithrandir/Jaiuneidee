<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130403153444 extends AbstractMigration
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
        $this->addSql("ALTER TABLE fos_user ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL");
        $this->addSql("ALTER TABLE fos_user ALTER date_de_naissance_public SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE fos_user ALTER sexe_public SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE fos_user ALTER localisation_public SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE fos_user ALTER tendance_politique_public SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE localisation ALTER niveau SET  DEFAULT 0");
        $this->addSql("ALTER TABLE localisation ALTER population SET  DEFAULT 0");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("ALTER TABLE theme ALTER is_moderated SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE localisation ALTER niveau SET  DEFAULT 0");
        $this->addSql("ALTER TABLE localisation ALTER population SET  DEFAULT 0");
        $this->addSql("ALTER TABLE fos_user DROP created_at");
        $this->addSql("ALTER TABLE fos_user ALTER date_de_naissance_public SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE fos_user ALTER sexe_public SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE fos_user ALTER localisation_public SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE fos_user ALTER tendance_politique_public SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE Invitation ALTER sent SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE commentaire ALTER is_validated_by_admin SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE commentaire ALTER life SET  DEFAULT 500");
        $this->addSql("ALTER TABLE commentaire ALTER is_removed SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE commentaire ALTER is_moderated SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER is_published SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER is_removed SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER is_validated_by_admin SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER is_moderated SET  DEFAULT 'false'");
        $this->addSql("ALTER TABLE idee ALTER life SET  DEFAULT 2000");
    }
}
