<?php 
namespace App\Controller;

use App\Repository\QuestionRepositoryInterface;
/**
 * 
 *
 * @package App\Controller
 * @author Mohammed JEMMOUDI
 **/
class QuestionController {

	private $repository;
	private $context;
	private $request;
	private $response;

	public function setRequest ( $req ) {
		$this->request = $req;
	}

	public function setResponse ( $resp ) {
		$this->response = $resp;
	}
    
    public function __construct (QuestionRepositoryInterface $repository, $context) {
    	$this->repository = $repository;
    	$this->context = $context;
    }

    public function index ()
    {
    	$url = $this->context->urlFor('submitForm');
    	$question = $this->repository->gestTheLastQuestion();

    	$this->context->render( './form.php', array(
    		'submitPath' => $url,
    		'question'   => $question->question_sentence,
    		'questionId' => $question->id,
    	));
    }

    public function answers ()
    {
    	$answers = $this->repository->getAllAnswers();
    	$this->context->render( './answers.php', array(
    		'answers' => $answers,
    	));
    }

    public function submitForm ()
    {
    	// receiving data
    	$userData = array(
			'firstname' => $this->request->post('firstName'),
    		'lastname' => $this->request->post('lastName'),
    		'email' => $this->request->post('email'),
    	);
    	
    	$answer = $this->request->post('answer');
    	$questionId = $this->request->post('questionId');
    	$question = $this->request->post('question');

    	// create new user
    	$user = $this->repository->createUser($userData);

    	// add answer
    	$flag = $this->repository->addAnswer($user, $answer, $questionId);

    	if ( $flag ) {
    		// create next question
	    	$newQuestion = $this->repository->addQuestion($user, $question);

	    	// give back the last created question
	    	echo json_encode(array(
	    		'success' => true,
	    		'questionId' => $newQuestion->id,
	    		'question'   => $newQuestion->question_sentence, 
	    	));	
    	}

    	else {
    		echo json_encode(array(
	    		'success' => false, 
	    	));
    	}

    	exit();
    }
} 