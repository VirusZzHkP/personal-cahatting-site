<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<style>
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

	body {
		line-height: 1.5;
		font-family: 'Poppins', sans-serif;
	}

	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.container {
		max-width: 1170px;
		margin: auto;
	}

	.row {
		display: flex;
		flex-wrap: wrap;
	}

	ul {
		list-style: none;
	}

	.footer {
		/* margin-top: -10px; */
		background-color: black;
		padding: 10vh 0;
		height: 260px;

	}

	.footer-col {
		width: 33%;
		padding: 0 25px;
	}

	.footer-col h4 {
		font-size: 18px;
		color: #ffffff;
		text-transform: capitalize;
		margin-bottom: 35px;
		font-weight: 500;
		position: relative;
	}

	.footer-col h4::before {
		content: '';
		position: absolute;
		left: 0;
		bottom: -10px;
		background-color: #e91e63;
		height: 2px;
		box-sizing: border-box;
		width: 50px;
	}

	.footer-col ul li:not(:last-child) {
		margin-bottom: 10px;
	}

	.footer-col ul li a {
		font-size: 16px;
		text-transform: capitalize;
		color: #ffffff;
		text-decoration: none;
		font-weight: 300;
		color: #bbbbbb;
		display: block;
		transition: all 0.3s ease;
	}

	.footer-col ul li a:hover {
		color: #ffffff;
		padding-left: 8px;
	}

	.footer-col .social-links a {
		display: inline-block;
		height: 40px;
		width: 40px;
		background-color: rgba(255, 255, 255, 0.2);
		margin: 0 10px 10px 0;
		text-align: center;
		line-height: 40px;
		border-radius: 50%;
		color: #ffffff;
		transition: all 0.5s ease;
	}

	.footer-col .social-links a:hover {
		color: #24262b;
		background-color: #ffffff;
	}

	/*responsive*/
	@media(max-width: 767px) {
		.footer-col {
			width: 50%;
			margin-bottom: 30px;
		}
	}

	@media(max-width: 574px) {
		.footer-col {
			width: 100%;
		}
	}
</style>
</div>
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="footer-col">
				<h4>Details</h4>
				<ul>
					<li><a href="https://officialhrisikesh.000webhostapp.com/" target="_blank">about developer</a></li>
					<li><a href="privacypolicy.php" target="_blank">privacy policy</a></li>
				</ul>
			</div>
			<div class="footer-col">
				<h4>get help</h4>
				<ul>
					<li><a href="faq.php">FAQ</a></li>
					<li><a href="mailto:custoomers.info@gmail.com">Mail Us</a></li>
				</ul>
			</div>

			<div class="footer-col">
				<h4>follow</h4>
				<div class="social-links">
					<a href="https://www.facebook.com/therealhrisikesh" target="_blank"><i class="fab fa-facebook-f"></i></a>
					<a href="https://twitter.com/hrisikesh_pal" target="_blank"><i class="fab fa-twitter"></i></a>
					<a href="https://github.com/VirusZzHkP" target="_blank"><i class="fab fa-github"></i></a>
					<a href="https://viruszzwarning.medium.com/" target="_blank"><i class="fab fa-readme"></i></a>
				</div>
			</div>
		</div>
		<p style="text-align:center; color:white;">©VirusZzWarning 2022</p>
	</div>
</footer>