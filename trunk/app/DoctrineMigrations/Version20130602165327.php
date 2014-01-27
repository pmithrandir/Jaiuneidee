<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130602165327 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("CREATE SEQUENCE idee_lue_id_seq INCREMENT BY 1 MINVALUE 1 START 1");
        $this->addSql("CREATE TABLE idee_lue (id INT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY(id))");
        $this->addSql("CREATE INDEX IDX_61A75F0FD40D782A ON idee_lue (idee_id)");
        $this->addSql("CREATE INDEX IDX_61A75F0FA76ED395 ON idee_lue (user_id)");
        $this->addSql("ALTER TABLE idee_lue ADD CONSTRAINT FK_61A75F0FD40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE idee_lue ADD CONSTRAINT FK_61A75F0FA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("DROP SEQUENCE idee_lue_id_seq CASCADE");
        $this->addSql("DROP TABLE idee_lue");
    }
}
