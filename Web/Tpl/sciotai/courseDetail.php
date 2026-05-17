<include file="./head_inner"/>

	<?php
		
		$courseid=$_GET['courseid'];
		$type1 = M('course');
		$result = $type1->where('id='.$courseid)->select();	
		$arr[]=array('courseName'=>$result['course_name'],'price'=>$result['price']);
			echo json_encode($arr);
		echo "ok";
		?>
  