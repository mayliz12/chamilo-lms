<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Migrations\Schema\V110;

use Chamilo\CoreBundle\Migrations\AbstractMigrationChamilo;
use Doctrine\DBAL\Schema\Schema;

/**
 * Set null to post_parent_id when it is 0 on c_forum_post table.
 */
class Version20160808110200 extends AbstractMigrationChamilo
{
    public function up(Schema $schema)
    {
        $this->addSql("UPDATE c_forum_post SET post_parent_id = NULL WHERE post_parent_id = 0");
    }

    public function down(Schema $schema)
    {
        $this->addSql('UPDATE c_forum_post SET post_parent_id = 0 WHERE post_parent_id = NULL');
    }
}
