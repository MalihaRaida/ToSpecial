<?php include ( "./inc/connect.inc.php"); ?>
<?php  
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header('location: signin.php');
}
else {
	$user = $_SESSION['user_login'];
}
?>
<?php 
	$username ="";
	$firstname ="";
	if (isset($_GET['u'])) {
		$username = ($_GET['u']);
		if (ctype_alnum($username)) {
			//check user exists
			$check = mysqli_query($conn,"SELECT username, first_name FROM users WHERE username='$username'");
			if (mysqli_num_rows($check)===1) {
				$get = mysqli_fetch_assoc($check);
				$username = $get['username'];
				$firstname = $get['first_name'];
			}
			else {
				die();
			}
		}
	}

	$get_title_info = mysqli_query($conn,"SELECT * FROM users WHERE username='$user'");
	$get_title_fname = mysqli_fetch_assoc($get_title_info);
	$title_fname = $get_title_fname['first_name'];
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title_fname; ?> </title>
	<link rel="icon" href="./img/tlogo.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="./css/header.css">
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>

	<?php 

	$result = mysqli_query($conn,"SELECT * FROM users WHERE username='$username'");
	$num = mysqli_num_rows($result);
	if ($num == 1) {

	include ( "./inc/header.inc.php");
	include ( "./inc/profile.inc.php");
	echo '<li style="float: right;">
							
							
					<div >
						<nav>
						<ul>
						<li><a href="photo.php?u='.$username.'">Photo</a></li>
						<li><a href="friends.php?u='.$username.'">Friend</a></li>
						<li><a href="family_about.php?u='.$username.'" style="background-color: #cdcdcd; color: #505050">About</a></li>
						<li><a href="profile.php?u='.$username.'" >Post</a></li>
						</ul>
						</nav>
					</div>
					
				</li>
			</ul>
			
			</div>
		</div>
	</div>';
	$get_msg_num = mysqli_query($conn,"SELECT * FROM pvt_messages WHERE user_from='$username' AND user_to='$user' LIMIT 2");
	$msg_count = mysqli_num_rows($get_msg_num);
	if (($msg_count >=0 ) || ($username == $user)) {

	$about_query = mysqli_query($conn,"SELECT family.academic,users.city,users.hometown,users.queote,users.bio,family.work_in,family.work_as,users.mobile,users.pub_email FROM users,family WHERE users.username='$username' and family.username='$username'");
					$get_result = mysqli_fetch_assoc($about_query);
					$academic_name_user = $get_result['academic'];
					$city_name_user = $get_result['city'];
					$hometown_name_user = $get_result['hometown'];
					$user_queote = $get_result['queote'];
					$user_bio = $get_result['bio'];
					$user_work_in = $get_result['work_in'];
					$user_work_as = $get_result['work_as'];
					$user_mobile = $get_result['mobile'];
					$user_pub_email = $get_result['pub_email'];
					
	
	echo '<div class="uiaccountstyle" style="text-align: left; height: auto; width: 507px; padding: 25px; margin: 15px auto;">
		<div>
			<p style="font-size: 13px; font-weight: bold; color: #959695;">WORK AND EDUCATION';
				if ($user==$username) {
					echo '<a href="workedu_update.php" style="float: right; text-decoration: none; font-size: 12px; color: #505050">Edit</a>';	
				}else {
					
				}
			echo '</p>

			<hr style="background-color: #ddd;">';
			
					echo '
					<p style="font-size: 15px; margin-left: 25px; font-weight: bold; color: #505050;">'.$user_work_in.'<br></p>
			<p style=" font-weight: bold; margin-left: 25px; ">'.$user_work_as.'<br></p></br>
			<p style="font-size: 15px; margin-left: 25px; font-weight: bold; color: #505050;">'.$academic_name_user.'<br></p>
				';
			
		echo '</div>
		<div>
		</br><p style="font-size: 13px; font-weight: bold; color: #959695;">MOBILE AND EMAIL';
				if ($user==$username) {
					echo '<a href="cbinfo_update.php" style="float: right; text-decoration: none; font-size: 12px; color: #505050">Edit</a>';	
				}else {
					
				}
		echo '</p>
			<hr style="background-color: #ddd;">
			<p style="font-size: 15px; margin-left: 25px; font-weight: bold; color: #505050;">'.$user_mobile.'</p>
			<p style=" font-weight: bold; margin-left: 25px; ">Mobile</P><br>
			<p style="font-size: 15px; margin-left: 25px; font-weight: bold; color: #505050;">'.$user_pub_email.'</p>
			<p style=" font-weight: bold; margin-left: 25px; ">Public Email</p>
		</div>
		<div>
		</br><p style="font-size: 13px; font-weight: bold; color: #959695;">CURRENT CITY AND HOMETOWN';
				if ($user==$username) {
					echo '<a href="location_update.php" style="float: right; text-decoration: none; font-size: 12px; color: #505050">Edit</a>';	
				}else {
					
				}
		echo '</p>
			<hr style="background-color: #ddd;">
			<p style="font-size: 15px; margin-left: 25px; font-weight: bold; color: #505050;">'.$city_name_user.'</p>
			<p style=" font-weight: bold; margin-left: 25px; ">Current City</P><br>
			<p style="font-size: 15px; margin-left: 25px; font-weight: bold; color: #505050;">'.$hometown_name_user.'</p>
			<p style=" font-weight: bold; margin-left: 25px; ">Hometown</p>
		</div>
		<div>
		<br><p style="font-size: 13px; font-weight: bold; color: #959695;">DETAILS ABOUT';
				if ($user==$username) {
					echo '<a href="details_update.php" style="float: right; text-decoration: none; font-size: 12px; color: #505050">Edit</a>';	
				}else {
					
				}
		echo '</p>
			<hr style="background-color: #ddd;">
			<p style=" color: #505050; margin-left: 25px; font-size: 14px; line-height: 18px; "> '.nl2br($user_bio).'<br></p>
		<br><p style="font-size: 13px; font-weight: bold; color: #959695;">FAVORITE QUOTE';
				if ($user==$username) {
					echo '<a href="details_update.php" style="float: right; text-decoration: none; font-size: 12px; color: #505050">Edit</a>';	
				}else {
					
				}
		echo '</p>
			<hr style="background-color: #ddd;">
			<p style=" color: #505050; margin-left: 25px; font-size: 14px; line-height: 18px; ">'.nl2br($user_queote).'<br></p>
		</div>
	</div>';
	}else {
		echo "<p style='text-align: center; color: #4A4848; margin: 30px; font-weight: bold; font-size: 36px;'>Sorry! Nothing to view. </p>";
	}
}else {
	header("location: profile.php?u=$user");
} 

?>
</body>
</html>