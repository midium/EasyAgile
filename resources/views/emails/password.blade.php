<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http‐equiv="Content‐Type" content="text/html; charset=UTF‐8" />
		<title>Easy Agile</title>
		<meta name="viewport" content="width=device‐width, initial‐scale=1. 0"/>
	</head>
	<body style="margin: 0; padding: 0;">
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
			<tr>
				<td align="center" bgcolor="#EF6D00" style="font-family: 'Open Sans', Verdana, sans-serif; font-size: 44px; color: black; line-height: 20px;">
					<img src="<?php echo $message->embed(base_path().'/assets/logo.png'); ?>">
				</td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td style="color: #153643; font-family: 'Open Sans', Verdana, sans-serif; font-size: 24px; padding: 0 0 10px 0;">
								<span style="padding: 20px 0 30px 0;">Password Reset</span>
							</td>
						</tr>
						<tr>
							<td style="color: #153643; font-family: 'Open Sans', Verdana, sans-serif; font-size: 16px; line-height: 20px;">
								To reset your password, complete this form: {{ url('password/reset/'.$token) }}
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td width="75%" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
								&reg; MiDiUm Software, 1998-<?= date('Y') ?>
							</td>
							<td align="right">
								<a href="mailto:matteo.loro@gmail.com">Mail Me!</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
