<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\File\Writer\AppWriter;
use Aws\S3\S3Client;
use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;

/**
 * SurveyImages Model
 *
 * @property \App\Model\Table\SurveysTable&\Cake\ORM\Association\BelongsTo $Surveys
 *
 * @method \App\Model\Entity\SurveyImage newEmptyEntity()
 * @method \App\Model\Entity\SurveyImage newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SurveyImage> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SurveyImage get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SurveyImage findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SurveyImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SurveyImage> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SurveyImage|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SurveyImage saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SurveyImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SurveyImage>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SurveyImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SurveyImage> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SurveyImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SurveyImage>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SurveyImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SurveyImage> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveyImagesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('survey_images');
        $this->setDisplayField('original_filename');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Surveys', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER',
        ]);

        $client = new S3Client(Configure::read('S3.config'));
        $bucket = Configure::read('S3.bucket');
        $adapter = new AwsS3V3Adapter($client, $bucket);
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'filename' => [
                'path' => '',
                'fields' => [
                    'size' => 'filesize',
                ],
                'filesystem' => [
                    'adapter' => $adapter,
                    'options' => [
                        'client' => 'S3',
                        'bucket' => $bucket,
                        'ACL' => 'public-read',
                    ],
                ],
                'writer' => AppWriter::class,
                'nameCallback' => function ($table, $entity, $data, $field, $settings) {
                    $entity->original_filename = $data->getClientFilename();
                    return Text::uuid().'.'.pathinfo($data->getClientFilename(),PATHINFO_EXTENSION);
                },
            ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('survey_id')
            ->notEmptyString('survey_id');

        $validator
            ->notEmptyString('original_filename');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['survey_id'], 'Surveys'), ['errorField' => 'survey_id']);

        return $rules;
    }
}
