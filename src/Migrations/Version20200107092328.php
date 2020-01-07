<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107092328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absence_user (absence_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FA8218D62DFF238F (absence_id), INDEX IDX_FA8218D6A76ED395 (user_id), PRIMARY KEY(absence_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absence_classroom (absence_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_F1233F1F2DFF238F (absence_id), INDEX IDX_F1233F1F6278D5A8 (classroom_id), PRIMARY KEY(absence_id, classroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence_user ADD CONSTRAINT FK_FA8218D62DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_user ADD CONSTRAINT FK_FA8218D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_classroom ADD CONSTRAINT FK_F1233F1F2DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_classroom ADD CONSTRAINT FK_F1233F1F6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE absence_user DROP FOREIGN KEY FK_FA8218D62DFF238F');
        $this->addSql('ALTER TABLE absence_classroom DROP FOREIGN KEY FK_F1233F1F2DFF238F');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE absence_user');
        $this->addSql('DROP TABLE absence_classroom');
    }
}
