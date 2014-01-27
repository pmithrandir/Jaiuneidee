<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130427150408 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("ALTER TABLE moderation DROP CONSTRAINT FK_C0EA6AA4D40D782A");
        $this->addSql("ALTER TABLE moderation DROP CONSTRAINT FK_C0EA6AA4A76ED395");
        $this->addSql("ALTER TABLE moderation ADD CONSTRAINT FK_C0EA6AA4D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE moderation ADD CONSTRAINT FK_C0EA6AA4A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE vote DROP CONSTRAINT FK_5A108564A76ED395");
        $this->addSql("ALTER TABLE vote DROP CONSTRAINT FK_5A108564D40D782A");
        $this->addSql("ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE vote ADD CONSTRAINT FK_5A108564D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BCD40D782A");
        $this->addSql("ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BCA76ED395");
        $this->addSql("ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCD40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE moderation_commentaire DROP CONSTRAINT FK_68C10569BA9CD190");
        $this->addSql("ALTER TABLE moderation_commentaire DROP CONSTRAINT FK_68C10569A76ED395");
        $this->addSql("ALTER TABLE moderation_commentaire ADD CONSTRAINT FK_68C10569BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE moderation_commentaire ADD CONSTRAINT FK_68C10569A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE idee DROP CONSTRAINT FK_DE60E5CA76ED395");
        $this->addSql("ALTER TABLE idee ADD CONSTRAINT FK_DE60E5CA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");
        
        $this->addSql("ALTER TABLE moderation DROP CONSTRAINT fk_c0ea6aa4d40d782a");
        $this->addSql("ALTER TABLE moderation DROP CONSTRAINT fk_c0ea6aa4a76ed395");
        $this->addSql("ALTER TABLE moderation ADD CONSTRAINT fk_c0ea6aa4d40d782a FOREIGN KEY (idee_id) REFERENCES idee (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE moderation ADD CONSTRAINT fk_c0ea6aa4a76ed395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE moderation_commentaire DROP CONSTRAINT fk_68c10569ba9cd190");
        $this->addSql("ALTER TABLE moderation_commentaire DROP CONSTRAINT fk_68c10569a76ed395");
        $this->addSql("ALTER TABLE moderation_commentaire ADD CONSTRAINT fk_68c10569ba9cd190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE moderation_commentaire ADD CONSTRAINT fk_68c10569a76ed395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE vote DROP CONSTRAINT fk_5a108564d40d782a");
        $this->addSql("ALTER TABLE vote DROP CONSTRAINT fk_5a108564a76ed395");
        $this->addSql("ALTER TABLE vote ADD CONSTRAINT fk_5a108564d40d782a FOREIGN KEY (idee_id) REFERENCES idee (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE vote ADD CONSTRAINT fk_5a108564a76ed395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE idee DROP CONSTRAINT fk_de60e5ca76ed395");
        $this->addSql("ALTER TABLE idee ADD CONSTRAINT fk_de60e5ca76ed395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE commentaire DROP CONSTRAINT fk_67f068bcd40d782a");
        $this->addSql("ALTER TABLE commentaire DROP CONSTRAINT fk_67f068bca76ed395");
        $this->addSql("ALTER TABLE commentaire ADD CONSTRAINT fk_67f068bcd40d782a FOREIGN KEY (idee_id) REFERENCES idee (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
        $this->addSql("ALTER TABLE commentaire ADD CONSTRAINT fk_67f068bca76ed395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE");
    }
}
