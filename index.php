<?php
	if(isset($_POST['input']))
	{
		$input = $_POST['input'];
		if(!empty($input))
		{
			output_without_dubles($input);
		}
		else
		{
			echo "Fill the empty field";
		}
	}

	function output_without_dubles($input)
	{
		//Split elements of array by space
		$array = explode(" ", $input);

		foreach ($array as $number) 
		{
			//compare the indexes of the first entrance of element with current 
			if(array_search($number, $array) == key($array))
			{
				echo $number . " ";
			}
			next($array);
		}
	}
?>




<form action="index.php" method="POST">
	<input type="text" name="input">
	<input type="submit" value="">
</form>