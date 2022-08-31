<!DOCTYPE html >

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CRM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.print.css" media="print">
 <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
 <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <script type="text/javascript" src="old/includes/jscript.js"></script>
  
  <link rel="stylesheet" href="old/includes/fcss.css"> 
     <style type="text/css" media="print">
	@page{
		size: auto;
		margin: 10;
	}
	@media print 
{
  @page { margin: 0; }
  body  { margin: 1.6cm; }
}
  </style>
  
  
  <style type="text/css">
	topdiv{
		position:fixed;
		top:0px;
		left:0px;
		width:100%;
		//background:#333;
		//padding:8px;
		//margin-bottom: 100px;
	}
	div#bottomdiv{
		position:fixed;
		bottom:0px;
		left:0px;
		width:100%;
		//background:#333;
		//padding:8px;
	}
	
	@page {
    @top-center { content: element(topdiv) }
	}
	@page { 
		@bottom-center { content: element(footer) }
	}
	
  </style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
	

		
	<table id="topdiv">
        <tr>
            <td>
                @php
                $image = explode('public/', $entreprise->entete);
             @endphp
           <img src="{{ public_path('storage/'.$image[1]) }}" width="100%" height="150px"/>
			</td>
        </tr>
	</table>	
      
	<table cellspacing="0" cellpadding="0" align="right">
        <tr>
            <td class="100p" style="text-align: right;">Ouagadougou le <?php echo date('d/m/Y'); ?></td>
		</tr>
	
	</table>
<br>
	<table cellspacing="0" cellpadding="0" align="right">
		<tr>
            <td class="100p" style="text-align: right; padding-right:25px"><strong>LA Direction Commerciale</strong></td>
        </tr>
	</table>
	<table cellspacing="0" cellpadding="0" align="right">
		<tr>
            <td class="100p" style="text-align: right; padding-right:100px"><strong>A</strong></td>
        </tr>
	</table>
	<table cellspacing="0" cellpadding="0" align="right">
		<tr>
            <td class="100p" style="text-align: right;"><strong>Mr/Mme Directeur Général de {{ $offreService->client->name }}</strong></td>
        </tr>
	</table>
	<table>
		<tr>
            <td class="100p" style="text-align: right;"><strong></strong></td>
        </tr>
	</table>
    <table style="margin-bottom: 10px;">
        <tr>
            <strong>Réf: {{ $offreService->numero_offre }}</strong>
        </tr>
	</table>
	
	<table style="margin-top: 10px;">
		<tr>
            <td><strong style="padding-top: 15px; text-decoration: underline;" colspan="2">Objet: {{ $offreService->objet }} </td>
        </tr>
	</table>

	<br>
	<table>
		<tr>
            <td class="100p">Monsieur/Madame le Directeur Général, </td>
        </tr>
	</table>
	<br>

	<table>
		<tr>
            <td class="100p">{!! $offreService->contenu !!}</td>
        </tr>
	</table>
 
	<table style="margin-top: 10px; height:auto;">
        <tr>
            <td class="100p" >
             </td>
		
		</tr>
    </table>

	<table cellspacing="0" cellpadding="0" align="right" style="vertical-align: top;">
        <tr>
		   <td class="25p">
                <p>
				<div align="right"><strong> La direction commerciale &nbsp;&nbsp;</strong></div>
                @php
                $imageSignature = explode('public/', $entreprise->signature);
                @endphp
                <img src="{{ public_path('storage/'.$imageSignature[1]) }}"  style="width: 245px; height: 120px;">
				</p>
            </td>
		</tr>
    </table>


	<div style="display: flex; justify-content: flex-end; margin-right: 50px">
	<strong> </strong></div>

	<div style="display: flex; justify-content: flex-end; margin-right: 30px">
    <strong></strong></div>
</body>
</html>
<script type="text/javascript">
     window.print() ;
 </script>
 
 

