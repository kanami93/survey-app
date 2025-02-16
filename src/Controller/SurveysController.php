<?php
declare(strict_types=1);

namespace App\Controller;

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
            $data = $this->request->getData();
            if($data['survey_images'][0]['filename']->getSize() === 0){
                unset($data['survey_images']);
            }
            $survey = $this->Surveys->patchEntity($survey, $data, ['associated' => ['SurveyImages']]);
            if ($this->Surveys->save($survey, ['associated' => ['SurveyImages']])) {
                return $this->redirect(['action' => 'complete']);
            }
            $this->Flash->error(__('回答の登録に失敗しました。'));
        }
        $this->set(compact('survey'));
    }

    public function complete()
    {

    }
}
