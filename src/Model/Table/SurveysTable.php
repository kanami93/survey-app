<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Survey;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Surveys Model
 *
 * @method \App\Model\Entity\Survey newEmptyEntity()
 * @method \App\Model\Entity\Survey newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Survey> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Survey get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Survey findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Survey patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Survey> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Survey|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Survey saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Survey>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Survey>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Survey>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Survey> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Survey>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Survey>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Survey>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Survey> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SurveysTable extends Table
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
        $this->addBehavior('Timestamp');

        $this->hasMany('SurveyImages', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER'
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
            ->scalar('thoughts')
            ->requirePresence('thoughts', 'create')
            ->notEmptyString('thoughts');

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
        $rules->addCreate(function ($entity, $option) {
            if (count($entity->survey_images) > Survey::MAX_NUMBER_OF_IMAGES) {
                return false;
            }
            return true;
        },[
            'errorField' => 'survey_images',
            'message' => '画像は' . Survey::MAX_NUMBER_OF_IMAGES . '枚までしか登録できません。'
        ]);

        return $rules;
    }

}
