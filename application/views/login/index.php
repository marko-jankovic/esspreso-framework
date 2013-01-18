<?php
	$this->renderShared("header");
?>
		<form method="post" action="">
			<table>
				<tr>
					<td>
						<label for="password">Password:</label>
					</td>
					<td>
						<input type="password" name="password" id="password" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="email">Email:</label>
					</td>
					<td>
						<input type="text" name="email" id="email" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input style="float:right;" type="submit" name="submit" value="Login" />
					</td>
				</tr>			
			</table>
		</form>
<?php
	$this->renderShared("footer");
?>