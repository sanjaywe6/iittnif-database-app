<?php if (!isset($Translation)) {
	@header('Location: index.php?signIn=1');
	exit;
} ?>
<?php if (MULTI_TENANTS) redirect(SaaS::loginUrl(), true); ?>
<?php include_once(__DIR__ . '/header.php'); ?>

<?php if (Request::val('loginFailed')) { ?>
	<div class="alert alert-danger"><?php echo $Translation['login failed']; ?></div>
<?php } ?>

<div class="row" style="display: flex; justify-content:center; flex-wrap:wrap;">


	<div class="col-sm-6 col-lg-4">
		<div class="panel panel-success" style="border-radius:10px; box-shadow: 0px 8px 15px 5px #848181;">

			<div class="panel-heading" style="background-color: #c2b28a; color:black;">
				<h1 class="panel-title"><strong><?php echo $Translation['sign in here']; ?></strong></h1>
			</div>

			<div>
				<div class="app-logos">
					<a href="https://iittnif.com"><div class="iittnif-logo"><img src="logos\IITTNiF_Logo.png" alt="" style="width: 100%;"></div></a>
				</div>
			</div>

			<div class="panel-body">
				<?php if (sqlValue("SELECT COUNT(1) from `membership_groups` WHERE `allowSignup`=1")) { ?>
					<a style="background-color:#c2b28a; color:black;" class="btn btn-lg pull-right" href="membership_signup.php"><?php echo $Translation['sign up']; ?></a>
					<div class="clearfix"></div>
				<?php } ?>

				<form method="post" action="index.php">
					<div class="form-group">
						<label class="control-label" for="username"><?php echo $Translation['username']; ?></label>
						<input class="form-control" name="username" id="username" type="text" placeholder="<?php echo $Translation['username']; ?>" required>
					</div>
					<div class="form-group">
						<label class="control-label" for="password"><?php echo $Translation['password']; ?></label>
						<input class="form-control" name="password" id="password" type="password" placeholder="<?php echo $Translation['password']; ?>" required>
						<span class="help-block"><?php echo $Translation['forgot password']; ?></span>
					</div>
					<div class="checkbox">
						<label class="control-label" for="rememberMe">
							<input type="checkbox" name="rememberMe" id="rememberMe" value="1">
							<?php echo $Translation['remember me']; ?>
						</label>
					</div>


					<div style="display: flex; justify-content:space-around; flex-wrap:wrap;">

						<div  style="margin: 10px;">
							<div>
								<button name="signIn" type="submit" id="submit" value="signIn" style="border: 1px solid #337ab7; border-radius:8px; padding:6px 15px; font-size:15px; background-color: #951b2a; color:white; min-width:100px;"><?php echo $Translation['sign in']; ?></button>
							</div>
						</div>

						<?php if (is_array(getTableList()) && count(getTableList())) { /* if anon. users can see any tables ... */ ?>
						<div  style="margin: 10px;">
							<div>
								<a href="index.php"><button type="button" style="border: 1px solid #337ab7; border-radius:8px; padding:6px 15px; font-size:15px; background-color: #c2b28a; color:black; min-width:100px; text-decoration:none"><i class="glyphicon glyphicon-user text-muted" style="color: #951b2a;"></i> <?php echo $Translation['continue browsing as guest']; ?></button></a>
							</div>
						</div>
						<?php } ?>

					</div>

				</form>

			</div>

		</div>
	</div>

	<!-- <div class="col-sm-6 col-lg-8" id="login_splash" style="display:flex;justify-content:center;">

	<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            text-align: center;
        }
        .card h1 {
            color: #ff6f61;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .card p {
            color: #333;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .card .balloons {
            font-size: 40px;
            margin-bottom: 20px;
        }
        .card button {
            background: #ff6f61;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 25px;
            cursor: pointer;
        }
        .card button:hover {
            background: #e55b50;
        }
    </style>

	<div class="card">
        <div class="balloons">🎈🎉🎂</div>
        <h1>Happy Birthday, Dr. Roshan K. Srivastav</h1>
        <h3>Project Director, Associate Professor, IIT Tirupati</h3>
        <p>Wishing you a day filled with love, laughter, and all your favorite things!</p>
        <button onclick="alert('Have an amazing day! 🎉')">Celebrate</button>
    </div>


	</div> -->

</div>

<script>
	document.getElementById('username').focus();
</script>
<?php include_once(__DIR__ . '/footer.php');
