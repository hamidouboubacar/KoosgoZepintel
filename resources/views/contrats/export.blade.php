<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Contrat</title>
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
		@page {
			size: auto;
			margin: 10;
		}

		@media print {
			@page {
				margin: 0;
			}

			body {
				margin: 1.6cm;
			}
		}
	</style>


	<style type="text/css">
		topdiv {
			position: fixed;
			top: 0px;
			left: 0px;
			width: 100%;
			/* //background:#333;
			//padding:8px;
			//margin-bottom: 100px; */
		}

		div#bottomdiv {
			position: fixed;
			bottom: 0px;
			left: 0px;
			width: 100%;
			/* //background:#333;
			//padding:8px; */
		}

		#contentg {
			font-size: 12px;
			font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
			font-weight: normal;
		}

		@page {
			@top-center {
				content: element(topdiv)
			}
		}

		@page {
			@bottom-center {
				content: element(footer)
			}
		}
	</style>

</head>

<body class="hold-transition skin-blue sidebar-mini">

	<table id="topdiv">
		<tr>
			<td>
				<div align="left">
					@if($avecEntete)
						<img src="../../../assets/images/netforce/netforceN.png" width="1000px">
					@else
						<hr />
					@endif
				</div>
			</td>
		</tr>
	</table>

	<div id='contentg' style="display:flex; overflow-wrap: break-word; text-align:left; width:100%; flex-wrap: wrap;">
		<div style="width: 48%;">
			<h3 style="color:orange">CONTRAT D'ABONNEMENT INTERNET</h3>
			<h3> {{ $num_contrat }} </h3>
			<!-- TODO: changer le code -->

			<span><strong>CONDITIONS PARTICULIERES</strong> </span> <br>
			<span><strong>INTERVENU</strong></span> <br>
			<span><strong>ENTRE: </strong> </span><br>

			<p>
				La Société <strong>Groupe NetForce</strong>  à responsabilité limitée (SARL), avec un captal d’Un million (1.000.000) de francs CFA ayant son siège social à Ouagadougou, 01 BP 248 Ouagadougou 01, Tél (+226) 74266200 immatriculé au registre de commerce et du crédit immobilier sous le numéro RCCM-BF OUA 2019 B 3987, représentée par BOUDA Y. Barkwendé,
				<br> ci-après nommé : <strong>Groupe NetForce</strong>.
				<!-- TODO: Changer des info ici -->
			</p>
			<br>
			<p>Et</p>
			<br>
			<p>
				{{ $client->name }} , Adresse : {{ $client->adresse }} – Tel: {{ $client->telephone }} <br>
			</p> <br>
			<strong>IL A ETE CONVENU ET ARRETE CE QUI SUIT :</strong> <br> <br>

			<p><strong style="text-decoration: underline;">Préambule :</strong></p> <br>
			<p>
				Le présent contrat est régi par les conditions générales ci-après ainsi que par les conditions particulières ci-dessus.
			</p>
			<p>
				ci-après nommé : <strong>Client</strong>
			</p>
			<h4><strong><u>CONDITIONS GENERALES</u> </strong></h4>
			<p>
				
			</p>
			<br>
			<h4><strong><u>ARTICLE 1 : OBJET DU CONTRAT </u></strong></h4>
			<p>
				Les présentes dispositions régissent les conditions d’offre de service fourni par le fournisseur.
			</p>
		</div>

		<div style="width: 48%;">
			Le service objet du présent contrat consiste en la fourniture d’une connectivité internet, {{ $packages_fournis }}
			<h4><strong><u>ARTICLE 2 : PRIX ET MODALITES DE REGLEMENT</u></strong></h4>
			<p>
				Les montants du présent contrat est de {{ $somme_contrat_package }} francs CFA par mois. Avec des frais d’installation de 100000 francs CFA.
			</p>
			<p>
				Les redevances mensuelles feront l’objet d’une facture mensuelle adressée au client par mail et ou physiquement. Les redevances sont en prépayées et sont dues au plus tard 10 jours à partir de la date de présentation de la facture. Les paiements seront effectués par orange money au +226 64 19 79 79, chèque ou par virement bancaire au bénéfice du fournisseur.
			</p>

			<h4><strong><u>ARTICLE 3 : DUREE DU CONTRAT</u></strong></h4>

			<p>
				L'abonnement prend effet lorsque le service est installé et en service chez le client. L'abonnement est souscrit pour une période minimale d’une année.
				Il est renouvelable par tacite reconduction pour une durée indéterminée sauf instruction contraire de l’une ou l’autre partie par écrit au moins trois (3) mois avant l’expiration de la période initiale d’un (01) ans.

			</p>
			<h4><strong><u>ARTICLE 4 : MODIFICATIONS</u></strong></h4>
			<p>
				Le fournisseur s’engage à informer l’abonné, un mois à l’avance, de toute modification portant sur le contenu des prestations fournies, de leur durée et de leur prix. En cas d’acceptation de ces modifications par le client, les nouvelles dispositions s’appliqueront à la date du changement effectif. En cas de non acceptation de ces modifications, l’abonné aura la faculté de résilier son abonnement. Il devra procéder à cette résiliation par courrier, dans le mois précédant la date du changement effectif.
			</p>
			<h4><strong><u>ARTICLE 5 : RESILIATION</u></strong></h4>
			<h6><strong>5.1 Résiliation normale par l’abonné</strong></h6>
			<p>
				Le client peut, au terme de l’année contractuel, le résilier. La résiliation prend effet si elle est reçue au moins trois (03) mois avant la fin du présent contrat.
			</p>
			<p>
				Si le client, avant le terme du présent, met fin ou résilie son contrat, il restera redevable de tous les frais restants dus, jusqu’à l’échéance du contrat
			</p>
			<br><br><br><br>
			<br><br><br><br>

		</div>
		<table id="topdiv">
			<tr>
				<td>
					<div align="left">
						@if($avecEntete)
							<img src="../../../assets/images/netforce/netforceN.png" width="1000px">
						@else
							<hr />
						@endif
					</div>
				</td>
			</tr>
		</table>
		<div style="width: 48%;">
			<br> 
			<p>
				plus profiter du service Internet (Indisponibilité totale du service pendant au moins 15 jours) sans préjudice de tous dommages et intérêts. <br>
			</p>
			<p>
				En cas de reconduction pour une période indéterminée, il peut être dénoncé à tout moment par l’une ou l’autre partie, sous réserve du respect du préavis de trois (3) mois notifié par écrit.
			</p>
			<h6><strong>5.2 Résiliation par le fournisseur</strong></h6>

			<p>
				Tout manquement de l’abonné aux conditions du présent contrat est de nature à entrainer la résiliation immédiate de l’abonnement sans préjudice de tous dommages et intérêts. En cas de retard dans les paiements et faute de régularisation dans les délais prévue par la lettre de mise en demeure adressée par le <strong>fournisseur</strong>, l’abonnement sera immédiatement résiliable de plein droit par le fournisseur. Dans tous les cas, les sommes dont l’abonné est redevable à la date de la résiliation restent dues par ce dernier.
				En cas d’impayés, les frais y afférents ainsi que ceux nécessaires à leur recouvrement, sont également à la charge de l’abonné

			</p>
			<h6><strong>5.3 Résiliation automatique en cas d’impossibilité technique de raccordement</strong></h6>
			<p>
				Dans certains cas, la fourniture du service peut s’avérer techniquement impossible. Si une telle situation est constatée, le présent contrat deviendra automatiquement caduc. Le fournisseur en informera l’abonné par courrier ou par téléphone et lui signalera ultérieurement toute évolution du réseau ou des conditions techniques qui permettrait d’envisager à nouveau le raccordement.
			</p>
			<h4><strong><u> ARTICLE 8 : OBLIGATIONS DES PARTIES</u></strong></h4>
			<h6><strong>8.1 OBLIGATIONS DU CLIENT</strong></h6>
			<h6>8.1.1 PROPRIETE ET PROTECTION DE L’EQUIPEMENT</h6>
			<p>
				L’équipement fourni aux termes des présentes demeure la propriété du fournisseur, toutefois, le client en a l’entière responsabilité. Il doit protéger l’équipement du fournisseur contre la détérioration, l’altération ou les dommages et n’autoriser personne, sauf un représentant du fournisseur, à effectuer des travaux ou une quelconque manipulation sur cet équipement. Le client devra rembourser au fournisseur le coût intégral de la réparation ou du remplacement de l’équipement perdu, volé, endommagé, non retourné à
			</p>
			<br>
		</div>

		<div style="width: 48%;">
				<br>
				<p>l’échéance, hypothéqué, vendu, loué, cédé ou transféré, en totalité ou en partie.</p>
				<h6><strong>8.1.2 USAGE CONFORME</strong></h6>
				<p>
					Le présent contrat n’exonère pas le client de sa responsabilité civile et pénale dans le cadre des droits liés à l’utilisation de logiciels informatiques. L’abonné est responsable des informations qu’il fait transiter par le réseau du fournisseur, en diffusion ou en lecture, même s’il n’en est pas le créateur.
				</p>

				<p>
					Le client est responsable de sa propre sécurité informatique. L’abonnement et les éléments de reconnaissance, fournis par le fournisseur, sont personnels et ne peuvent en aucun cas être transférés à un tiers sous peine de résiliation immédiate selon les dispositions de l’article 7alinéas 2 des présentes.
				</p>
				<p>
					Il est expressément convenu que l’abonné qui cède son contrat en violation de l’interdiction ci-dessus, reste tenu du règlement du prix de l’abonnement et de l’intégralité des consommations liées à la formule de fourniture souscrite.
				</p>

				<p>
				Restent également à la charge de l’abonné, sans que puisse être recherchée la responsabilité du fournisseur, les conséquences dommageables de ses fautes ou négligences ainsi que de celles des personnes ou des choses dont il a la garde.
				</p>
				<br><br>
				<h6><strong>8.1.3 INTERDICTIONS</strong></h6>
				<p>
					Il est formellement interdit au client, sous peine de résiliation de son abonnement et sans préjudice de tous dommages et intérêts et poursuites, d’introduire dans le réseau des perturbations de toute nature. Dans ce cas, le client sera tenu pour responsable de ces perturbations tant à l’égard du fournisseur qu’à l’égard des tiers.
				</p>
				<h6><strong>8.2 OBLIGATION DU FOURNISSEUR</strong></h6>
				<p>
					Le fournisseur est responsable de la qualité de la connexion depuis le nœud d’accès jusqu’au point d’entrée du réseau, propriété du fournisseur, côté client.
				</p>

				<p>
				Le fournisseur ne saurait être tenu responsable des pannes, coupures de lignes, mauvaise configuration de matériel, des équipements, etc., qui ne sont pas sous son contrôle direct 
				</p>
				<br>
				<br><br><br><br>
				<br><br><br><br>

		</div>
		<br>
		
		<table id="topdiv">
			<tr>
				<td>
					<div align="left">
						@if($avecEntete)
							<img src="../../../assets/images/netforce/netforceN.png" width="1000px">
						@else
							<hr />
						@endif
					</div>
				</td>
			</tr>
		</table>
		
		
		<div style="width: 48%;">
				<br>
				<p>
					ou qu’elle n’a pas fourni, et notamment des liaisons de tous types assurés par d’autres prestataires.
				</p>

				<p>
					Le fournisseur ne garantit pas les taux de transfert et les temps de réponse des informations circulant dans le réseau Internet.
				</p>
				<p>
					L’accès au réseau sera en principe assuré en permanence, sous réserve de contraintes et aléas indépendants de la volonté du fournisseur, affectant la continuité et la qualité du service, et ne pouvant être raisonnablement surmontés ou évités malgré les précautions prises lors de la conception, de la construction, de l’entretien et de l’exploitation de la plateforme de connexion ou du réseau.
				</p>
				<p>
					Les contraintes et aléas peuvent être soit inhérents aux matériels ou aux logiciels compte tenu des connaissances acquises en la matière et des technologies utilisables, soit extérieurs dans le cas d’actions de tiers volontaires ou accidentelles, d’incendie, d’explosion, d’accident de toute nature. Ces cas ne sont pas limitatifs et ne sont pas nécessairement constitutifs de cas de force majeure au sens strict entendu par la jurisprudence.
				</p>
				<p>
					Les interruptions programmées du service, pour effectuer des travaux de toute nature nécessaires à l’entretien ou à l’évolution de l’offre feront l’objet d’un avis à l’abonné et ne donneront lieu à aucune indemnisation. Les travaux programmables à l’avance (entretien, extension, etc.) seront effectués dans toute la mesure du possible, en dehors des plages de grande utilisation.
				</p>
				<p>
					En cas d’interruption du service, le fournisseur prendra immédiatement les dispositions nécessaires pour assurer sa remise en service dans les meilleurs délais.
				</p>
				<p>
					Le fournisseur est responsable des outils logiciels mis à la disposition de ses abonnés lors de la souscription du contrat et nécessaire à la connexion et à l’échange de données entre le site du client et la plateforme informatique du fournisseur.
				</p>

				<br> <br> <br> <br>
				<h4><strong>ARTICLE 9 : JURIDICTION COMPETENTE ET DROIT APPLICABLE</strong></h4>
		</div>

		<div style="width: 48%;">
				<br>
				<p>
				Tout différend, difficulté ou contestation relatif à l’exécution ou l’interprétation du présent contrat sera réglé amiablement. En l’absence d’accord amiable le différend, difficulté ou contestation sera régi par le tribunal du commerce du Burkina Faso. 
				</p>
				<p>
				Les présentes conditions sont rédigées en langue française
				</p>
				<h4><strong>ARTICLE 10 : ELECTION DE DOMICILE</strong></h4>
				<p>Pour tout ce qui n’est pas précisé au contrat, les parties s’en remettent aux dispositions légales et réglementaires en vigueur au Burkina Faso.</p> <br>
				<p>
				Les parties déclarent avoir pris connaissance des dispositions légales, règlementaires et conventionnelles en matière de télécom et en acceptent l’application dans le cadre du présent contrat.
				</p>
				<p>
				Le contrat est établit en deux (02) exemplaires originaux, dont un exemplaire est remis à chaque partie.
				</p>
				<br>
				<p><strong>EN FOI DE QUOI, LES PARTIES ONT SIGNE LES PRESENTES</strong></p>
				<p>Date d'activation le </p>
				
				<p>
					Fait à Ouagadougou, le {{ $date_contrat }}
				</p>
				 <br> <br>

				<div style="display: flex; justify-content: space-around;">
					<div>
						<strong>Le fournisseur</strong> <br>
						@if($avecSignature)
							<img src="../../../assets/images/netforce/signature.png" style="width: 120px; margin:0">
						@endif
					</div>
					<div>
						<strong>Le client</strong>
					</div>
				</div>
				
		</div>
		

			

	</div>




	</div>
	<div id="bottomdiv" align="center">
		<tr>
			<td>
				<div>
					<hr />
				</div>
			</td>
		</tr>
	</div>


	<?php  ?>
</body>

</html>
<script type="text/javascript">
	window.print();
</script>