<?php echo $this->renderShared('header'); ?>


		
		<form method="post" action="">			
			<div class="reg_form">
				<ul>
					<li>
						<?=$this->form->label("First Name:","firstName");?>
						<span class="error"><?=$info['error']['firstName']?></span>
						<?=$this->form->inputText("firstName",$info['data']['firstName'],"firstName");?>
					</li>
					<li>
						<?=$this->form->label("Last Name:","firstName");?>
						<span class="error"><?=$info['error']['lastName']?></span>
						<?=$this->form->inputText("lastName",$info['data']['lastName'],"text","lastName");?>
					</li>
					<li>
						<?=$this->form->label("Email:","email");?>
						<span class="error"><?=$info['error']['email']?></span>
						<?=$this->form->inputText("email",$info['data']['email'],"email");?>
						
					</li>
					<li>
						<?=$this->form->label("Password","password");?>
						<span class="error"><?=$info['error']['password']?></span>
						<?=$this->form->inputPassword("password","password");?>
					</li>
					<li>
						<?=$this->form->label("Password2","password2");?>
						<?=$this->form->inputPassword("password2","password");?>
					</li>
					<li class="clearfix">
						<?=$this->form->submit("Sign Up","register","sign_up");?>
					</li>
				</ul>
			</div>
		</form>
		
<?php echo $this->renderShared('footer'); ?>