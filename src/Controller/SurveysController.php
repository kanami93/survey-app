<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\SurveyImage;
use Cake\ORM\TableRegistry;

/**
 * Surveys Controller
 *
 * @property \App\Model\Table\SurveysTable $Surveys
 */
class SurveysController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('S3Client');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $survey = $this->Surveys->newEmptyEntity();
        if ($this->request->is('post')) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData(), ['associated' => ['SurveyImages']]);
            if ($this->Surveys->save($survey, ['associated' => ['SurveyImages']])) {
                return $this->redirect(['action' => 'complete']);
            }
            $this->Flash->error(__('エラーが発生したため、回答が登録できませんでした。'));
        }
        $this->set(compact('survey'));
    }

    public function complete()
    {

    }
}
