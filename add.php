<?php  include 'db.php';
if(isset($_POST['submit'])){
	$question_number = $_POST['question_number'];
	$question_text = $_POST['question_text'];
	$correct_choice = $_POST['correct_choice'];
	// Choice Array
	$choice = array();
	$choice[1] = $_POST['choice1'];
	$choice[2] = $_POST['choice2'];
	$choice[3] = $_POST['choice3'];
	$choice[4] = $_POST['choice4'];


	$query = "ALTER table options AUTO_INCREMENT=1;";
	$result = mysqli_query($connection,$query);

 // First Query for Questions Table

	$query = "INSERT INTO questions (";
	$query .= "question_number, question_text )";
	$query .= "VALUES (";
	$query .= " '{$question_number}','{$question_text}' ";
	$query .= ")";

	$result = mysqli_query($connection,$query);

	//Validate First Query
	if($result){
		foreach($choice as $option => $value){
			if($value != ""){
				if($correct_choice == $option){
					$is_correct = 1;
				}else{
					$is_correct = 0;
				}
			

				//Second Query for Choices Table
				$query = "INSERT INTO options (";
				$query .= "question_number,is_correct,coption)";
				$query .= " VALUES (";
				$query .=  "'{$question_number}','{$is_correct}','{$value}' ";
				$query .= ")";

				$insert_row = mysqli_query($connection,$query);
				// Validate Insertion of Choices

				if($insert_row){
					continue;
				}else{
					die("2nd Query for Choices could not be executed" . $query);
					
				}

			}
		}
		$message = "Question has been added successfully";
	}

	




}

if(isset($_POST['delete'])){
	$query = "ALTER table options AUTO_INCREMENT=1;";
	$result = mysqli_query($connection,$query);
	$query = "DELETE FROM options";
	$result = mysqli_query($connection,$query);
	$query = "DELETE FROM questions";
	$result = mysqli_query($connection,$query);

}

		$query = "SELECT * FROM questions";
		$questions = mysqli_query($connection,$query);
		$total = mysqli_num_rows($questions);
		$next = $total+1;
		

?>
<html>

   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TRIVIA SPACE</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
        <link rel="stylesheet" href="assets/css/styles.css">
        </head>

        <body style="background-color: #F1F7FC;">
        <div class="login-clean">
			<form method="POST" action="add.php">
                        <h2> Add a question</h2>
						<hr>
						<p style="padding-right: 60px">
							<label>Question Number:</label>
							<input type="number" name="question_number" value="<?php echo $next;  ?>">
						</p>
						<p style="padding-right: 35px">
							<label>Question Text:</label>
							<input type="text" name="question_text">
						</p>
						<p>
							<label>Choice 1:</label>
							<input type="text" name="choice1">
						</p>
						<p>
							<label>Choice 2:</label>
							<input type="text" name="choice2">
						</p>
						<p>
							<label>Choice 3:</label>
							<input type="text" name="choice3">
						</p>
						<p>
							<label>Choice 4:</label>
							<input type="text" name="choice4">
						</p>

						<p>
							<label>Correct Option Number</label>
							<select type="number" name="correct_choice">
								<option value="1">Choice 1</option>
								<option value="2">Choice 2</option>
								<option value="3">Choice 3</option>
								<option value="4">Choice 4</option>
							</select>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" value ="Add">ADD</button>
                        </div>
               
                       
						<input class="btn btn-danger btn-block" type="submit" name="delete" value ="RESET QUESTIONS"><br><br>
                  
                        <a href="." class="forgot" style="font-size:large; color:#f4476b">Go Back</a>
                        <br>
                        
                </form>
                
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/drop-zone-.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- <script src="assets/js/bs-animation.js"></script> -->
        </body>

</html>