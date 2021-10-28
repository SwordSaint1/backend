<nav class="navbar fixed-top navbar-expand-lg navbar-dark info-color">
	<!--img src="logo/fas.png" width="100px" class="mr-3 ml-2"-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2 mb-2" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<h1 class="h2-responsive font-weight-bold text-white"><?php echo $_SESSION['scooter_area'];?> | Tube Cutting </h1>
			<li id="nav_request_section" class="nav-item">
				<a class="nav-link" id="nav_request_link" href="request.php"> <i class="fas fa-cogs"></i> Request Parts </a>
			</li>
			<li id="nav_request_section" class="nav-item">
				<a class="nav-link" id="nav_notification_link" href="notification_station.php"><i class="fas fa-bell"></i> Notification <span class="badge badge-danger" id="badge_notification"></span></a>
			</li>
			<!-- <li class="nav-item dropdown" id="notification_page">
				<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bell"></i> Notification <span class="badge badge-danger" id="badge_notification"></span></a>
				<div class="dropdown-menu dropdown-primary info-color" aria-labelledby="navbarDropdownMenuLink" style="width:500px;">
					<div id="content_page_notification" style="cursor:pointer;">
					</div>
				</div>
			</li> -->
			<li id="nav_history_section" class="nav-item">
				<a class="nav-link" href="history_station.php"> <i class="fas fa-history"></i> History </a>
			</li>
		</ul>
	</div>
</nav>
<br>
<br>
<br>