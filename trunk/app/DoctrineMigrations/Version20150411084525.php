<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150411084525 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type_mandat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_elu (id INT AUTO_INCREMENT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_jaime DATETIME DEFAULT NULL, jaime TINYINT(1) DEFAULT \'0\' NOT NULL, date_jemengage DATETIME DEFAULT NULL, jemengage TINYINT(1) DEFAULT \'0\' NOT NULL, date_jairealise DATETIME DEFAULT NULL, jairealise TINYINT(1) DEFAULT \'0\' NOT NULL, date_jenaimepas DATETIME DEFAULT NULL, jenaimepas TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_6580EF81D40D782A (idee_id), INDEX IDX_6580EF81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moderation (id INT AUTO_INCREMENT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_C0EA6AA4D40D782A (idee_id), INDEX IDX_C0EA6AA4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, note INT NOT NULL, created_at DATETIME DEFAULT \'1990-01-01 00:00:00\' NOT NULL, is_removed TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_5A108564D40D782A (idee_id), INDEX IDX_5A108564A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, moderations_id INT DEFAULT NULL, content LONGTEXT NOT NULL, is_validated_by_admin TINYINT(1) DEFAULT \'0\' NOT NULL, life INT DEFAULT 500 NOT NULL, is_removed TINYINT(1) DEFAULT \'0\' NOT NULL, is_moderated TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT \'1990-01-01 00:00:00\' NOT NULL, updated_at DATETIME DEFAULT \'1990-01-01 00:00:00\' NOT NULL, INDEX IDX_67F068BCD40D782A (idee_id), INDEX IDX_67F068BCA76ED395 (user_id), INDEX IDX_67F068BC7972D53E (moderations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moderation_commentaire (id INT AUTO_INCREMENT NOT NULL, commentaire_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_68C10569BA9CD190 (commentaire_id), INDEX IDX_68C10569A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mandat (id INT AUTO_INCREMENT NOT NULL, localisation_id INT DEFAULT NULL, type_mandat_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_election DATE DEFAULT NULL, date_prise_de_fonction DATE DEFAULT NULL, INDEX IDX_1E53EFD5C68BE09C (localisation_id), INDEX IDX_1E53EFD572419C88 (type_mandat_id), INDEX IDX_1E53EFD5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE idee (id INT AUTO_INCREMENT NOT NULL, theme_id INT DEFAULT NULL, user_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, is_published TINYINT(1) DEFAULT \'0\' NOT NULL, is_removed TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, last_action_at DATETIME DEFAULT \'1990-01-01 00:00:00\' NOT NULL, is_validated_by_admin TINYINT(1) DEFAULT \'0\' NOT NULL, is_moderated TINYINT(1) DEFAULT \'0\' NOT NULL, life INT DEFAULT 2000 NOT NULL, INDEX IDX_DE60E5C59027487 (theme_id), INDEX IDX_DE60E5CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE idee_localisation (idee_id INT NOT NULL, localisation_id INT NOT NULL, INDEX IDX_A5F713E6D40D782A (idee_id), INDEX IDX_A5F713E6C68BE09C (localisation_id), PRIMARY KEY(idee_id, localisation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistique (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, nb_utilisateurs_connectes_24 INT DEFAULT 0 NOT NULL, nb_utilisateurs_connectes_week INT DEFAULT 0 NOT NULL, nb_inscrits_24 INT DEFAULT 0 NOT NULL, nb_idees_24 INT DEFAULT 0 NOT NULL, nb_commentaires_24 INT DEFAULT 0 NOT NULL, nb_votes_24 INT DEFAULT 0 NOT NULL, nb_invitations_24 INT DEFAULT 0 NOT NULL, nb_alertes_24 INT DEFAULT 0 NOT NULL, nb_inscrits_total INT DEFAULT 0 NOT NULL, nb_idees_total INT DEFAULT 0 NOT NULL, nb_votes_total INT DEFAULT 0 NOT NULL, nb_commentaires_total INT DEFAULT 0 NOT NULL, nb_invitations_total INT DEFAULT 0 NOT NULL, nb_alertes_total INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parti (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alerte_idee (id INT AUTO_INCREMENT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, activated TINYINT(1) DEFAULT \'1\' NOT NULL, created_at DATETIME DEFAULT \'1990-01-01 00:00:00\' NOT NULL, INDEX IDX_1F78AD67D40D782A (idee_id), INDEX IDX_1F78AD67A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, userFrom_id INT DEFAULT NULL, userTo_id INT DEFAULT NULL, INDEX IDX_B6BD307F2B121C29 (userFrom_id), INDEX IDX_B6BD307FD65059B3 (userTo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE idee_lue (id INT AUTO_INCREMENT NOT NULL, idee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_61A75F0FD40D782A (idee_id), INDEX IDX_61A75F0FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, descriptif VARCHAR(255) NOT NULL, is_moderated TINYINT(1) DEFAULT \'0\' NOT NULL, ordre INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, is_validated_by_admin TINYINT(1) DEFAULT \'0\' NOT NULL, is_removed TINYINT(1) DEFAULT \'0\' NOT NULL, publication_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, invitation_code VARCHAR(6) DEFAULT NULL, sexe_id INT DEFAULT NULL, tendance_politique_id INT DEFAULT NULL, dommage_id INT DEFAULT NULL, localisation_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT \'1990-01-01 00:00:00\' NOT NULL, last_activity DATETIME DEFAULT \'1990-01-01 00:00:00\' NOT NULL, date_de_naissance DATE NOT NULL, date_de_naissance_public TINYINT(1) DEFAULT \'0\' NOT NULL, approbation_charte TINYINT(1) NOT NULL, sexe_public TINYINT(1) DEFAULT \'0\' NOT NULL, localisation_public TINYINT(1) DEFAULT \'0\' NOT NULL, tendance_politique_public TINYINT(1) DEFAULT \'0\' NOT NULL, newsletter TINYINT(1) DEFAULT \'1\' NOT NULL, avatar VARCHAR(255) DEFAULT \'\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479BA14FCCC (invitation_code), INDEX IDX_957A6479448F3B3C (sexe_id), INDEX IDX_957A64797A96CF6F (tendance_politique_id), INDEX IDX_957A6479649176F7 (dommage_id), INDEX IDX_957A6479C68BE09C (localisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sexe (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation (id VARCHAR(6) NOT NULL, inviteur_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, sent TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT \'1990-01-01 00:00:00\' NOT NULL, INDEX IDX_F11D61A2EA375D06 (inviteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tendance_politique (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dommage (id INT AUTO_INCREMENT NOT NULL, level INT NOT NULL, value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, min INT NOT NULL, max INT NOT NULL, niveau INT DEFAULT 0 NOT NULL, population INT DEFAULT 0 NOT NULL, urlName VARCHAR(255) DEFAULT NULL, footer LONGTEXT DEFAULT NULL, css VARCHAR(255) DEFAULT NULL, INDEX IDX_BFD3CE8F727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_elu ADD CONSTRAINT FK_6580EF81D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id)');
        $this->addSql('ALTER TABLE action_elu ADD CONSTRAINT FK_6580EF81A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE moderation ADD CONSTRAINT FK_C0EA6AA4D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE moderation ADD CONSTRAINT FK_C0EA6AA4A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCD40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC7972D53E FOREIGN KEY (moderations_id) REFERENCES moderation_commentaire (id)');
        $this->addSql('ALTER TABLE moderation_commentaire ADD CONSTRAINT FK_68C10569BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE moderation_commentaire ADD CONSTRAINT FK_68C10569A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mandat ADD CONSTRAINT FK_1E53EFD5C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE mandat ADD CONSTRAINT FK_1E53EFD572419C88 FOREIGN KEY (type_mandat_id) REFERENCES type_mandat (id)');
        $this->addSql('ALTER TABLE mandat ADD CONSTRAINT FK_1E53EFD5A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE idee ADD CONSTRAINT FK_DE60E5C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE idee ADD CONSTRAINT FK_DE60E5CA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE idee_localisation ADD CONSTRAINT FK_A5F713E6D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id)');
        $this->addSql('ALTER TABLE idee_localisation ADD CONSTRAINT FK_A5F713E6C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE alerte_idee ADD CONSTRAINT FK_1F78AD67D40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alerte_idee ADD CONSTRAINT FK_1F78AD67A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2B121C29 FOREIGN KEY (userFrom_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FD65059B3 FOREIGN KEY (userTo_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE idee_lue ADD CONSTRAINT FK_61A75F0FD40D782A FOREIGN KEY (idee_id) REFERENCES idee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE idee_lue ADD CONSTRAINT FK_61A75F0FA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A6479BA14FCCC FOREIGN KEY (invitation_code) REFERENCES invitation (id)');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A6479448F3B3C FOREIGN KEY (sexe_id) REFERENCES sexe (id)');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A64797A96CF6F FOREIGN KEY (tendance_politique_id) REFERENCES tendance_politique (id)');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A6479649176F7 FOREIGN KEY (dommage_id) REFERENCES dommage (id)');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A6479C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2EA375D06 FOREIGN KEY (inviteur_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8F727ACA70 FOREIGN KEY (parent_id) REFERENCES localisation (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mandat DROP FOREIGN KEY FK_1E53EFD572419C88');
        $this->addSql('ALTER TABLE moderation_commentaire DROP FOREIGN KEY FK_68C10569BA9CD190');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC7972D53E');
        $this->addSql('ALTER TABLE action_elu DROP FOREIGN KEY FK_6580EF81D40D782A');
        $this->addSql('ALTER TABLE moderation DROP FOREIGN KEY FK_C0EA6AA4D40D782A');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564D40D782A');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCD40D782A');
        $this->addSql('ALTER TABLE idee_localisation DROP FOREIGN KEY FK_A5F713E6D40D782A');
        $this->addSql('ALTER TABLE alerte_idee DROP FOREIGN KEY FK_1F78AD67D40D782A');
        $this->addSql('ALTER TABLE idee_lue DROP FOREIGN KEY FK_61A75F0FD40D782A');
        $this->addSql('ALTER TABLE idee DROP FOREIGN KEY FK_DE60E5C59027487');
        $this->addSql('ALTER TABLE action_elu DROP FOREIGN KEY FK_6580EF81A76ED395');
        $this->addSql('ALTER TABLE moderation DROP FOREIGN KEY FK_C0EA6AA4A76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE moderation_commentaire DROP FOREIGN KEY FK_68C10569A76ED395');
        $this->addSql('ALTER TABLE mandat DROP FOREIGN KEY FK_1E53EFD5A76ED395');
        $this->addSql('ALTER TABLE idee DROP FOREIGN KEY FK_DE60E5CA76ED395');
        $this->addSql('ALTER TABLE alerte_idee DROP FOREIGN KEY FK_1F78AD67A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2B121C29');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FD65059B3');
        $this->addSql('ALTER TABLE idee_lue DROP FOREIGN KEY FK_61A75F0FA76ED395');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2EA375D06');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A6479448F3B3C');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A6479BA14FCCC');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A64797A96CF6F');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A6479649176F7');
        $this->addSql('ALTER TABLE mandat DROP FOREIGN KEY FK_1E53EFD5C68BE09C');
        $this->addSql('ALTER TABLE idee_localisation DROP FOREIGN KEY FK_A5F713E6C68BE09C');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A6479C68BE09C');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8F727ACA70');
        $this->addSql('DROP TABLE type_mandat');
        $this->addSql('DROP TABLE action_elu');
        $this->addSql('DROP TABLE moderation');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE moderation_commentaire');
        $this->addSql('DROP TABLE mandat');
        $this->addSql('DROP TABLE idee');
        $this->addSql('DROP TABLE idee_localisation');
        $this->addSql('DROP TABLE statistique');
        $this->addSql('DROP TABLE parti');
        $this->addSql('DROP TABLE alerte_idee');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE idee_lue');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE sexe');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP TABLE tendance_politique');
        $this->addSql('DROP TABLE dommage');
        $this->addSql('DROP TABLE localisation');
    }
}
