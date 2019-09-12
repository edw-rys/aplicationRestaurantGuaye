<?php if(!isset($_SESSION)){
            session_start();
		} 
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href ="assets/img/isotipo.png">
    
	<title>Home:Guayé</title>
	<link rel="stylesheet" href="assets/css/base.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="./assets/css/operation.css"/>
	<style>
		a:hover{
			text-decoration: none;
		}
		.button{
			padding:10px;
		}
		header.index {
			position: relative;
			
			z-index: 2;
		}
		@media(min-width:750px){
			header.index{
				background: url(assets/img/bck/home.jpg);
				background-size: 100% 100%;
				background-repeat: no-repeat;
				height: 40em;
			}
        }
		

		a{
			text-decoration: none;
		}
		form.contact,form.diario{
			display: grid;
		}
		.contact{
			padding: 70px 0;
		}
		@media(min-width: 750px){
			.contact{
				width: 70%;
				margin: auto;
			}
        }



		    @import url('https://fonts.googleapis.com/css?family=Berkshire+Swash');
        </style>
        <!-- icons -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" />

    </head>

    <body>
		<?php require_once PANELS; ?>