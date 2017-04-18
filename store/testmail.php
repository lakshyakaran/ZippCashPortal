<?php

				$from = "NGO Time";
				$to = "pratikraj26@gmail.com";
				$subject = "Verify your email";
				$content = '';
				$content .= 'Hello '.$user_data['first_name'].'\n';
				$content .= 'Welcome to NgoTime where you can post your complaints and suggestion for the betterment of th epeople of Delhi.\n';
				$content .= 'Please click on the following link to activate your account and start posting.\n\n';
				$content .= '<a href = "'.$apl->site_url.'/verify/'.$user_data["email_verification_code"].'"></a>\n\n';
				$content .= 'Thank you\nNgo Time';
				$headers = 'From: admin@ngotime.mobi' . "\r\n" .
					 'Reply-To: admin@ngotime.mobi' . "\r\n" .
					 'X-Mailer: PHP/' . phpversion();

mail( $to, $subject, $content );
