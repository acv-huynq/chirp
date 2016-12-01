<form id="headerForm" action="/p/chirp/logout" method="post">
	<nav class="navbar navbar-peach">
		<div class="container-fluid">
			<div id="main">
				<p id="logo"></p>
				<h1>Chirp <?= HTML::entities($header_title) ?>
					<button id="logoutButton" type="submit" class="btn navbar-btn btn-pink pull-right <?php echo $login_button_hidden ?>" onclick="return confirm('ログアウトします。よろしいですか？');">Log out</button>
				</h1>
			</div>
		</div>
	</nav>
</form>