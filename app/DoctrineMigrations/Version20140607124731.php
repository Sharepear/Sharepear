<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140607124731 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Image (id INT AUTO_INCREMENT NOT NULL, album_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, orientation VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, public TINYINT(1) NOT NULL, INDEX IDX_4FC2B5B1137ABCF (album_id), INDEX IDX_4FC2B5BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Image ADD CONSTRAINT FK_4FC2B5B1137ABCF FOREIGN KEY (album_id) REFERENCES Image (id)");
        $this->addSql("ALTER TABLE Image ADD CONSTRAINT FK_4FC2B5BA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE Image DROP FOREIGN KEY FK_4FC2B5BA76ED395");
        $this->addSql("ALTER TABLE Image DROP FOREIGN KEY FK_4FC2B5B1137ABCF");
        $this->addSql("DROP TABLE fos_user");
        $this->addSql("DROP TABLE Image");
    }
}
