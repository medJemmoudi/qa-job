<?php 
namespace App\Repository;

/**
* @package App\Repository
* @author Mohammed JEMMOUDI
*/
interface QuestionRepositoryInterface {

	public function getAllQuestions ();
	public function createUser ($userData);
	public function addAnswer ($user, $answer, $questionId);
	public function addQuestion ($user, $question);
	public function gestTheLastQuestion();
	public function getAllAnswers();

}