<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141204231854 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Album (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, public TINYINT(1) DEFAULT '0' NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Image DROP FOREIGN KEY FK_4FC2B5BA76ED395");
        $this->addSql("ALTER TABLE Image DROP FOREIGN KEY FK_4FC2B5B1137ABCF");
        $this->addSql("DROP INDEX IDX_4FC2B5BA76ED395 ON Image");
        $this->addSql("ALTER TABLE Image ADD createdAt DATETIME NOT NULL, ADD updatedAt DATETIME NOT NULL, ADD createdBy VARCHAR(255) DEFAULT NULL, ADD updatedBy VARCHAR(255) DEFAULT NULL, DROP user_id, DROP created_at, DROP updated_at");
        $this->addSql("ALTER TABLE Image ADD CONSTRAINT FK_4FC2B5B1137ABCF FOREIGN KEY (album_id) REFERENCES Album (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Image DROP FOREIGN KEY FK_4FC2B5B1137ABCF");
        $this->addSql("DROP TABLE Album");
        $this->addSql("ALTER TABLE Image ADD user_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP createdAt, DROP updatedAt, DROP createdBy, DROP updatedBy");
        $this->addSql("ALTER TABLE Image ADD CONSTRAINT FK_4FC2B5BA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE Image ADD CONSTRAINT FK_4FC2B5B1137ABCF FOREIGN KEY (album_id) REFERENCES Image (id)");
        $this->addSql("CREATE INDEX IDX_4FC2B5BA76ED395 ON Image (user_id)");
    }
}
