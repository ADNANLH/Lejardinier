
	<?php
		require('navbar.php');
		require('../connection.php');
		
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $openpart = "<script>openCity(event, 'sign-in');</script>";
	if (isset($_POST['signup'])) {
        $nom = $_POST['nom'] ?? '';
        $cin = $_POST['cin'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmpass = $_POST['confirmpass'] ?? '';

        // Conditions for validation
        if (empty($nom) || empty($cin) || empty($email) || empty($password) || empty($confirmpass)) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Veuillez remplir tous les champs.</div>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Format email invalide.</div>";
        } elseif ($password != $confirmpass) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Les mots de passe ne correspondent pas.</div>";
        } else {
            $select = "SELECT * FROM client WHERE email = :email";
            $stmt = $pdo->prepare($select);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Cet Email existe déjà.</div>";
            } else {
                $hashedPassword = md5($password);

                $insert = "INSERT INTO client (nom_client, cin, email, password) VALUES (:nom, :cin, :email, :password)";
                $stmt = $pdo->prepare($insert);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':cin', $cin);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $result = $stmt->execute();

                if (!$result) {
                    $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Erreur lors de l'inscription. Veuillez réessayer plus tard.</div>";
                } else {
                    $_SESSION['signup_success'] = true;
                    echo $openpart;
                }
            }
        }
    }
	if (isset($_POST['signin'])) {
        $email_1 = $_POST['email_1'] ?? '';
        $password_1 = $_POST['password_1'] ?? '';

        if (empty($email_1) || !filter_var($email_1, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Votre adresse e-mail est requise ou invalide, veuillez réessayer.</div>";
            echo $openpart;
        } elseif (empty($password_1)) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Le mot de passe est requis.</div>";
            echo $openpart;
        } else {
            $hashedPassword_1 = md5($password_1);
            $stmt = $pdo->prepare('SELECT * FROM `client` WHERE email=:email AND password=:password');
            $stmt->bindParam(':email', $email_1);
            $stmt->bindParam(':password', $hashedPassword_1);
            $stmt->execute();

			if ($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$_SESSION['id_client'] = $row['id_client'];
				header("Location: profile.php");
				exit; // Add an exit statement after the header redirection
			} else {
				$_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Identifiants incorrects. Veuillez réessayer.</div>";
				
			}
        }
    }
}
?>
	
	<div class="page-content">
		<div class="form-v8-content">
			<div class="form-left">
				<img src="../images/planting.jpg" alt="form">
			</div>
			<div class="form-right">
				<div class="tab">
					<div class="tab-inner">
						<button class="tablinks" onclick="openCity(event, 'sign-up')" id="defaultOpen">Créer compte</button>
					</div>
					<div class="tab-inner">
						<button class="tablinks" onclick="openCity(event, 'sign-in')">Connexion</button>
					</div>
				</div>
				<form class="form-detail" action="" method="post">
					<div class="tabcontent" id="sign-up">
						<div class="form-row">
							<label class="form-row-inner">
								<input type="text" name="nom" id="full_name" class="input-text" required>
								<span class="label">Nom et Prénom</span>
		  						<span class="border"></span>
							</label>
						</div>
						<div class="form-row">
							<label class="form-row-inner">
								<input type="text" name="cin" id="full_name" class="input-text" required>
								<span class="label">CIN</span>
		  						<span class="border"></span>
							</label>
						</div>
						<div class="form-row">
							<label class="form-row-inner">
								<input type="text" name="email" id="your_email" class="input-text" required>
								<span class="label">E-Mail</span>
		  						<span class="border"></span>
							</label>
						</div>
						<div class="form-row">
							<label class="form-row-inner">
								<input type="password" name="password" id="password" class="input-text" required>
								<span class="label">Mot de passe</span>
								<span class="border"></span>
							</label>
						</div>
						<div class="form-row">
							<label class="form-row-inner">
								<input type="password" name="confirmpass" id="comfirm_password" class="input-text" required>
								<span class="label">Confirmer Mot de passe</span>
								<span class="border"></span>
							</label>
						</div>
						<div class="form-row-last">
							<input type="submit" name="signup" class="register" value="Crée votre compte">
						</div>
					</div>
				</form>
				<form class="form-detail" action="" method="post">
					<div class="tabcontent" id="sign-in">
						
						<div class="form-row">
							<label class="form-row-inner">
								<input type="email" name="email_1" id="your_email_1" class="input-text" required>
								<span class="label">E-Mail</span>
		  						<span class="border"></span>
							</label>
						</div>
						<div class="form-row">
							<label class="form-row-inner">
								<input type="password" name="password_1" id="password_1" class="input-text" required>
								<span class="label">Password</span>
								<span class="border"></span>
							</label>
						</div>
						
						<div class="form-row-last">
							<input type="submit" name="signin" class="register" value="Connexion">
						</div>
					</div>
				</form>
					<?php
					if (!empty($_SESSION['error'])) {
						echo $_SESSION['error'];
						unset($_SESSION['error']);
					}
					if (!empty($_SESSION['signup_success'])) {
						echo "<div class='success alert alert-success' role='alert'>Inscription réussie. Connectez-vous maintenant.</div>";
						unset($_SESSION['signup_success']);
					
					}
					?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function openCity(evt, cityName) {
		    var i, tabcontent, tablinks;
		    tabcontent = document.getElementsByClassName("tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
		    }
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace(" active", "");
		    }
		    document.getElementById(cityName).style.display = "block";
		    evt.currentTarget.className += " active";
		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>
</body>


</html>
<style>
	body {
	margin:  0;
}
.page-content {
	width: 100%;
	margin:  0 auto;
	background-color: #F6F4E8;
	display: flex;
	display: -webkit-flex;
	justify-content: center;
	-o-justify-content: center;
	-ms-justify-content: center;
	-moz-justify-content: center;
	-webkit-justify-content: center;
	align-items: center;
	-o-align-items: center;
	-ms-align-items: center;
	-moz-align-items: center;
	-webkit-align-items: center;
}
.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
    position: absolute;
    left: -460px;
    top: 583px;
    padding: 10px;
    border-radius: 4px;
    width: 418px;
    margin: 0px 0px 0px 21px;
}
.alert-success {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
    position: absolute;
    left: -460px;
    top: 583px;
    padding: 10px;
    border-radius: 4px;
    width: 418px;
    margin: 0px 0px 0px 21px;
}
.form-v8-content  {
	background: #fff;
	width: 1141px;
	border-radius: 8px;
	-o-border-radius: 8px;
	-ms-border-radius: 8px;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
	box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
	-o-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
	-ms-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
	-moz-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
	-webkit-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
	margin: 177px 0;
	font-family: 'Source Sans Pro', sans-serif;
	color: #fff;
	position: relative;
	display: flex;
	display: -webkit-flex;
}
.form-v8-content .form-left {
	margin-bottom: -4px;
}
.form-v8-content .form-left img {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
    width: 460px;
    height: auto;
}
.form-v8-content .form-right {
    padding: 30px 0;
    position: relative;
    width: 100%;
    height: 690px;
    background: #419387;
    border-top-right-radius: 9px;
    border-bottom-right-radius: 9px;
}
.form-v8-content .tab {
	margin: 5px 0 48px;
	width: 100%;
    display: flex;
    display: -webkit-flex;
    justify-content: space-between;
    -o-justify-content: space-between;
    -ms-justify-content: space-between;
    -moz-justify-content: space-between;
    -webkit-justify-content: space-between;
}
.form-v8-content .tab .tab-inner {
	width: 100%;
}
.form-v8-content .tab .tablinks {
	background: transparent;
	border: none;
	outline: none;
	-o-outline: none;
	-ms-outline: none;
	-moz-outline: none;
	-webkit-outline: none;
	font-family: 'Source Sans Pro', sans-serif;
	font-size: 28px;
	font-weight: 400;
	color: #ccc;
	padding-bottom: 22px;
	border-bottom: 3px solid;
	border-bottom-color: rgba(255, 255, 255, 0.2);
	width: 100%;
}
.form-v8-content .tab .tablinks.active {
	font-weight: 700;
	color: #fff;
	border-bottom-color: #30e1df;
}
.form-v8-content .form-detail {
	padding:  0 40px;
}
.form-v8-content .form-row {
    width: 100%;
    position: relative;
}
.form-v8-content .form-row .form-row-inner {
	position: relative;
	width: 100%;
}
.form-v8-content .form-row .form-row-inner .label {
	position: absolute;
    top: -2px;
    left: 10px;
    font-size: 18px;
    color: #f2f2f2;
    font-weight: 400;
    transform-origin: 0 0;
    transition: all .2s ease;
    -moz-transition: all .2s ease;
    -webkit-transition: all .2s ease;
    -o-transition: all .2s ease;
    -ms-transition: all .2s ease;
}
.form-v8-content .form-row .form-row-inner .border {
	position: absolute;
    bottom: 31px;
    left: 0;
    height: 1px;
    width: 100%;
    background: #53c83c;
    transform: scaleX(0);
    -moz-transform: scaleX(0);
    -webkit-transform: scaleX(0);
    -o-transform: scaleX(0);
    -ms-transform: scaleX(0);
    transform-origin: 0 0;
    transition: all .15s ease;
    -moz-transition: all .15s ease;
    -webkit-transition: all .15s ease;
    -o-transition: all .15s ease;
    -ms-transition: all .15s ease;
}
.form-v8-content .form-detail .input-text {
	margin-bottom: 31px;
}
.form-v8-content .form-detail input {
	width: 100%;
    padding: 0px 10px 15px 10px;
    border: 1px solid transparent;
    border-bottom: 1px solid;
    border-bottom-color: rgba(255, 255, 255, 0.2);
    background: transparent;
    appearance: unset;
    -moz-appearance: unset;
    -webkit-appearance: unset;
    -o-appearance: unset;
    -ms-appearance: unset;
    outline: none;
    -moz-outline: none;
    -webkit-outline: none;
    -o-outline: none;
    -ms-outline: none;
    font-size: 18px;
    color: #fff;
    font-weight: 300;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -o-box-sizing: border-box;
    -ms-box-sizing: border-box;
}
.form-v8-content .form-detail .form-row .input-text:focus{
	border-bottom: 1px solid #53c83c;
	background: transparent;
}
.form-v8-content .form-detail .form-row .input-text:focus + .label, 
.form-v8-content .form-detail .form-row .input-text:valid + .label {
	transform: translateY(-26px) scale(1);
	-moz-transform: translateY(-26px) scale(1);
    -webkit-transform: translateY(-26px) scale(1);
    -o-transform: translateY(-26px) scale(1);
    -ms-transform: translateY(-26px) scale(1);

}
.form-v8-content .form-detail .form-row .input-text:focus  + .border, 
.form-v8-content .form-detail .form-row .input-text:valid  + .border {
	transform: scaleX(1);
	-moz-transform: scaleX(1);
    -webkit-transform: scaleX(1);
    -o-transform: scaleX(1);
    -ms-transform: scaleX(1);

}
.form-v8-content .form-detail .register {
	background: #53a69a ;
	border-radius: 5px;
	-o-border-radius: 5px;
	-ms-border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	width: 202px;
	border: 1px white ;
	margin: 5px 0 50px 0px;
	cursor: pointer;
	font-family: 'Source Sans Pro', sans-serif;
	color: white;
	font-weight: 700;
	font-size: 18px;
}
.form-v8-content .form-detail .register:hover {
	background: #3fa697;
}
.form-v8-content .form-detail .form-row-last input {
	padding: 11px;
}
/* Responsive */
@media screen and (max-width: 991px) {
	.form-v8-content {
		margin: 180px 20px;
		flex-direction:  column;
		-o-flex-direction:  column;
		-ms-flex-direction:  column;
		-moz-flex-direction:  column;
		-webkit-flex-direction:  column;
	}
	.form-v8-content .form-left {
		width: 100%;
	}
	.form-v8-content .form-left img {
		width: 100%;
		border-bottom-left-radius: 0px;
	    border-top-right-radius: 8px;
	}
	.form-v8-content .form-right {
		width: auto;
		border-top-right-radius: 0;
		border-bottom-left-radius: 8px;
	}
	.form-v8-content .tab {
		margin-top: 45px;
	}
	.form-v8-content .form-detail .register {
		margin-bottom: 80px;
	}
}

@media screen and (max-width: 325px) {
	.form-v8-content .tab {
		flex-direction: column;
		-o-flex-direction: column;
		-ms-flex-direction: column;
		-moz-flex-direction: column;
		-webkit-flex-direction: column;
	}
}

</style>