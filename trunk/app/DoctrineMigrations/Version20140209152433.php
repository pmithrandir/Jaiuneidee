<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20140209152433 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("CREATE SEQUENCE type_mandat_id_seq INCREMENT BY 1 MINVALUE 1 START 1");
        $this->addSql("CREATE SEQUENCE action_elu_id_seq INCREMENT BY 1 MINVALUE 1 START 1");
        $this->addSql("CREATE SEQUENCE mandat_id_seq INCREMENT BY 1 MINVALUE 1 START 1");
        $this->addSql("CREATE SEQUENCE parti_id_seq INCREMENT BY 1 MINVALUE 1 START 1");
        $this->addSql("CREATE TABLE type_mandat (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))");
        $this->addSql("CREATE TABLE action_elu (id INT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_jaime TIMESTAMP(0) WITHOUT TIME ZONE, jaime BOOLEAN DEFAULT 'false' NOT NULL, date_jemengage TIMESTAMP(0) WITHOUT TIME ZONE, jemengage BOOLEAN DEFAULT 'false' NOT NULL, date_jairealise TIMESTAMP(0) WITHOUT TIME ZONE, jairealise BOOLEAN DEFAULT 'false' NOT NULL, PRIMARY KEY(id))");
        $this->addSql("CREATE INDEX IDX_6580EF81D40D782A ON action_elu (idee_id)");
        $this->addSql("CREATE INDEX IDX_6580EF81A76ED395 ON action_elu (user_id)");
        $this->addSql("CREATE TABLE mandat (id INT NOT NULL, localisation_id INT DEFAULT NULL, type_mandat_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_election DATE NOT NULL, date_prise_de_fonction DATE NOT NULL, PRIMARY KEY(id))");
        $this->addSql("CREATE INDEX IDX_1E53EFD5C68BE09C ON mandat (localisation_id)");
        $this->addSql("CREATE INDEX IDX_1E53EFD572419C88 ON mandat (type_mandat_id)");
        $this->addSql("CREATE INDEX IDX_1E53EFD5A76ED395 ON mandat (user_id)");
        $this->addSql("CREATE TABLE parti (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))");
        $this->addSql("ALTER TABLE action_elu ADD CONSTRAINT FK_6580EF81D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE action_elu ADD CONSTRAINT FK_6580EF81A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE mandat ADD CONSTRAINT FK_1E53EFD5C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE mandat ADD CONSTRAINT FK_1E53EFD572419C88 FOREIGN KEY (type_mandat_id) REFERENCES type_mandat (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE mandat ADD CONSTRAINT FK_1E53EFD5A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("ALTER TABLE mandat DROP CONSTRAINT FK_1E53EFD572419C88");
        $this->addSql("DROP SEQUENCE type_mandat_id_seq CASCADE");
        $this->addSql("DROP SEQUENCE action_elu_id_seq CASCADE");
        $this->addSql("DROP SEQUENCE mandat_id_seq CASCADE");
        $this->addSql("DROP SEQUENCE parti_id_seq CASCADE");
        $this->addSql("DROP TABLE type_mandat");
        $this->addSql("DROP TABLE action_elu");
        $this->addSql("DROP TABLE mandat");
        $this->addSql("DROP TABLE parti");
        
    }
}
