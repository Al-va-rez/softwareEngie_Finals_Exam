<div class="navbar_Content">
	<!-- greetings -->
	<h1>Welcome, <span style="color: blue;"><?= $_SESSION['username']; ?></span></h1>
</div>

<div class="navbar_Content">

	<!-- each link is encolsed in div so that they are all arranged in one line -->
	<div>
		<h3>
			<a href="index.php">Home</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="all_HR.php">View All HR Users</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="all_Applicants.php">View All Applicants</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="core/handleForms.php?btn_Logout=1">Logout</a>	
		</h3>
	</div>
</div>