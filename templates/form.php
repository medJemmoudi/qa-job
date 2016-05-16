<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Question Form</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Semantic -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
		</head>
		<body>
			<h1 class="text-center">Hello</h1>
			<form action="<?= $submitPath ?>" method="post">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">
							<div class="ui segment form">
								<div class="ui default message" style="display: block;">
									<div class="header">The question is:</div>
									<p id="questionId" data-id="<?= $questionId ?>"><?= $question ?></p>
								</div>
								<div class="field">
									<label>Your answer</label>
									<textarea rows="2" placeholder="Your answer goes here..." name="answer"></textarea>
								</div>
							</div>
							<div class="ui segment form">
								<div class="three fields">
									<div class="field">
										<label>First name</label>
										<input type="text" name="firstname" placeholder="Your first name">
									</div>
									<div class="field">
										<label>Last name</label>
										<input type="text" name="lastname" placeholder="Your last name">
									</div>
									<div class="field">
										<label>Email</label>
										<input type="text" name="email" placeholder="Your email">
									</div>
								</div>
								<div class="field">
									<label>Ask a question</label>
									<textarea rows="2" name="question" placeholder="leave a question to the next user..."></textarea>
								</div>
								<button type="submit" id="submit-answer" class="ui submit button blue">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			
			<!-- jQuery -->
			<script src="//code.jquery.com/jquery.js"></script>
			<!-- Bootstrap JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
			<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
			<script type="text/javascript">
				$(function(){

					$('form').on('submit', function(event) {
						event.preventDefault();
						$('.ui.form').addClass('loading');
						var form = $(this);
						var url  = document.location.origin + form.attr('action');  
						var formData = {
							firstName: $('input[name="firstname"]').val(),
							lastName: $('input[name="lastname"]').val(),
							email: $('input[name="email"]').val(),
							answer: $('textarea[name="answer"]').val(),
							question: $('textarea[name="question"]').val(),
							questionId: $('#questionId').attr('data-id')
						};

						$.post(url, formData, function(data, textStatus, xhr) {
							data = $.parseJSON(data);
							if ( data.success ) {
								$('.ui.form').removeClass('loading')
											 .find("input[type=text], textarea").val("");	
								$('#questionId').attr('data-id', data.questionId)
												.text( data.question );
								swal("Good job!", "Your answer has been saved!", "success");
							}
							else {
								swal("Cancelled", "Something went wrong!", "error");
							}
						});
					});

				});
			</script>
		</body>
		</html>