<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href ="<?php echo IMAGES?>isotipo.png">
    
	<title><?php echo isset($data)?$data["title"]:"Inicio";?></title>
	<link rel="stylesheet" href="<?php echo CSS?>styles.css">
	<link rel="stylesheet" href="<?php echo CSS?>animate.css">
	<link rel="stylesheet" href="<?php echo CSS?>toastr.min.css">
	<link rel="stylesheet" href="<?php echo CSS?>calendar.min.css">
	<link href="https://cdn.rawgit.com/nizarmah/calendar-javascript-lib/master/calendarorganizer.min.css" rel="stylesheet" />
	
	<script>
		const url="<?php echo URL?>";
	</script>
	<script src="<?php echo JS?>pluggins/jquery.min.js"></script>
	<script src="<?php echo JS?>pluggins/toastr.min.js"></script>
	<script src="<?php echo JS?>pluggins/calendar.min.js"></script>
	

	<!-- <script src="https://cdn.jsdelivr.net/jquery/3.2.1/jquery.min.js"></script> -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->
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
		    /* @import url('https://fonts.googleapis.com/css?family=Berkshire+Swash'); */
        </style>
        <!-- icons -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" />

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- Scripts -->
    </head>

    <body>
		<?php include_once COMPONENTS."modal.php"?>