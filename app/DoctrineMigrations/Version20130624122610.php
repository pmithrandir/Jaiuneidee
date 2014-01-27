<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130624122610 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("CREATE SEQUENCE alerte_idee_id_seq INCREMENT BY 1 MINVALUE 1 START 1");
        $this->addSql("CREATE TABLE alerte_idee (id INT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, activated BOOLEAN DEFAULT 'true' NOT NULL, PRIMARY KEY(id))");
        $this->addSql("CREATE INDEX IDX_1F78AD67D40D782A ON alerte_idee (idee_id)");
        $this->addSql("CREATE INDEX IDX_1F78AD67A76ED395 ON alerte_idee (user_id)");
        $this->addSql("ALTER TABLE alerte_idee ADD CONSTRAINT FK_1F78AD67D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE alerte_idee ADD CONSTRAINT FK_1F78AD67A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("DROP SEQUENCE alerte_idee_id_seq CASCADE");
        $this->addSql("DROP TABLE alerte_idee");
    }
}
