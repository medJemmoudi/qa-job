<?php 

namespace App\Repository;

use App\Model\Question;

/**
* @package App\Repository
* @author Mohammed JEMMOUDI
*/
class QuestionRepository implements QuestionRepositoryInterface {
	
	private $orm;

	function __construct()
	{
		$Application = \RKA\Slim::getInstance();
		$this->orm = $Application->container->get('ORM');
	}

	public function getAllQuestions () {
		return $this->orm->question()->orderBy('id', 'DESC')->find();
	}

	public function gestTheLastQuestion() {
		$lastQuestion = $this->orm->question()->orderBy('id', 'DESC')->findOne();
		if ( !$lastQuestion ) {
			$defaultUser = $this->createUser(array(
				'email' => 'default@testing.io',
				'firstname' => 'default',
				'lastname'  => 'default',
			));

			$lastQuestion = $this->addQuestion($defaultUser, 'Be the first to ask a question!');
		}

		return $lastQuestion;
	}

	public function getAllAnswers() {
		return $this->orm->answer()
			->join('user', 'answer.user_id = u.id', 'u')
			->join('question', 'answer.question_id = q.id', 'q')
			->find();
	}

	public function createUser ($userData) {
		return $this->orm->user()->insert($userData);
	}

	public function addAnswer ($user, $answer, $questionId) {
		$question = $this->orm->question()->findOne( $questionId );
		if ( $question ) {
			$this->orm->answer()->insert(array(
				'user_id' => $user->id,
				'question_id' => $questionId,
				'answer_sentence' => $answer,
				'created_at' => date('Y-m-d H:i:s'),
			));

			return true;
		}

		return false;
	}

	public function addQuestion ($user, $question) {
		return $this->orm->question()->insert(array(
			'user_id' => $user->id,
			'question_sentence' => $question,
			'created_at' => date('Y-m-d H:i:s'),
		));
	}
}