<div class="navbar">
	<h1>Welcome, <span style="color: blue;"><?= $_SESSION['username']; ?></span></h1>
</div>

<div class="navbar">
	<div>
		<h3>
			<a href="dashboard.php">Home</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="create_Job.php">Create New Job</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="messages.php">Messages</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="../core/handleForms.php?btn_Logout=1">Logout</a>	
		</h3>
	</div>
</div>