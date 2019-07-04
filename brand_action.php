<?php

//brand_action.php

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO brand (category_id, brand_name) 
		VALUES (:category_id, :brand_name)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_id'	=>	$_POST["category_id"],
				':brand_name'	=>	$_POST["brand_name"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Brand Name Added';
		}
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM brand WHERE brand_id = :brand_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':brand_id'	=>	$_POST["brand_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['category_id'] = $row['category_id'];
			$output['brand_name'] = $row['brand_name'];
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE brand set 
		category_id = :category_id, 
		brand_name = :brand_name 
		WHERE brand_id = :brand_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_id'	=>	$_POST["category_id"],
				':brand_name'	=>	$_POST["brand_name"],
				':brand_id'		=>	$_POST["brand_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Brand Name Edited';
		}
	}

	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE brand 
		SET brand_status = :brand_status 
		WHERE brand_id = :brand_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':brand_status'	=>	$status,
				':brand_id'		=>	$_POST["brand_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Brand status change to ' . $status;
		}
	}
}

?>