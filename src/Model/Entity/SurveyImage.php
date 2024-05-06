<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyImage Entity
 *
 * @property int $id
 * @property int $survey_id
 * @property string $filename
 * @property string $original_filename
 * @property int $filesize
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\Survey $survey
 */
class SurveyImage extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        '*' => true,
    ];
}
