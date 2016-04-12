<style>
	body{
		background: radial-gradient(circle, #222, #333333) repeat scroll 0 0 #fff;
		height:100px;
	}
	
	div#login{
		background-color: #fff;
		width:400px;
		height:300px;
		border:2px solid #444444;
		border-radius:10px;
		margin:125px auto;
		overflow:hidden;
		text-align:center;
		
	}
	
	#heading{
		padding:30px;
		background-color: #428bca;
		font-size: 26px;
		font-family: "Arial";
	}
	
	#controls{
		margin-top:20px;
	}
	
	.title{
		color:#fff;
	}
</style>
<div class="container">
	<div id="login">
		<div id="heading">
			<span class="title">Login</span>
		</div>
		<div id="controls">
			<div class="login-ctrls">
				<form name="login" action="login/validate_credentials" method="post">
				<div class="control-group">
				  <div class="controls">
					<div class="input-prepend">
					  <span class="add-on"><i class="icon-user"></i></span>
					  <input type="text" required=true placeholder="Username" id="username" name="username" value="" class="span2">
					</div>
				  </div>
				</div>
				<div class="control-group">
				  <div class="controls">
					<div class="input-prepend">
					  <span class="add-on"><i class="icon-lock"></i></span>
					  <input type="password" required=true placeholder="Password" id="password" name="password" class="span2">
					</div>
				  </div>
				</div>
				<div id="centerbtn" >
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-success tm_style_1">Log In <span class="add-on"><i class="icon-hand-left"></i></span></button>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>