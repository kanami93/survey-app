<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSurveyImages extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table('survey_images')
            ->addColumn('survey_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('filename', 'string', ['null' => false])
            ->addColumn('original_filename', 'string', ['null' => false])
            ->addColumn('filesize', 'integer', ['null' => false])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addForeignKey('survey_id', 'surveys', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->save();
    }
}
