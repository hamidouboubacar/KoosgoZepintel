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
				La Soci??t?? <strong>Groupe NetForce</strong>  ?? responsabilit?? limit??e (SARL), avec un captal d???Un million (1.000.000) de francs CFA ayant son si??ge social ?? Ouagadougou, 01 BP 248 Ouagadougou 01, T??l (+226) 74266200 immatricul?? au registre de commerce et du cr??dit immobilier sous le num??ro RCCM-BF OUA 2019 B 3987, repr??sent??e par BOUDA Y. Barkwend??,
				<br> ci-apr??s nomm?? : <strong>Groupe NetForce</strong>.
				<!-- TODO: Changer des info ici -->
			</p>
			<br>
			<p>Et</p>
			<br>
			<p>
				{{ $client->name }} , Adresse : {{ $client->adresse }} ??? Tel: {{ $client->telephone }} <br>
			</p> <br>
			<strong>IL A ETE CONVENU ET ARRETE CE QUI SUIT :</strong> <br> <br>

			<p><strong style="text-decoration: underline;">Pr??ambule :</strong></p> <br>
			<p>
				Le pr??sent contrat est r??gi par les conditions g??n??rales ci-apr??s ainsi que par les conditions particuli??res ci-dessus.
			</p>
			<p>
				ci-apr??s nomm?? : <strong>Client</strong>
			</p>
			<h4><strong><u>CONDITIONS GENERALES</u> </strong></h4>
			<p>
				
			</p>
			<br>
			<h4><strong><u>ARTICLE 1 : OBJET DU CONTRAT </u></strong></h4>
			<p>
				Les pr??sentes dispositions r??gissent les conditions d???offre de service fourni par le fournisseur.
			</p>
		</div>

		<div style="width: 48%;">
			Le service objet du pr??sent contrat consiste en la fourniture d???une connectivit?? internet, {{ $packages_fournis }}
			<h4><strong><u>ARTICLE 2 : PRIX ET MODALITES DE REGLEMENT</u></strong></h4>
			<p>
				Les montants du pr??sent contrat est de {{ $somme_contrat_package }} francs CFA par mois. Avec des frais d???installation de 100000 francs CFA.
			</p>
			<p>
				Les redevances mensuelles feront l???objet d???une facture mensuelle adress??e au client par mail et ou physiquement. Les redevances sont en pr??pay??es et sont dues au plus tard 10 jours ?? partir de la date de pr??sentation de la facture. Les paiements seront effectu??s par orange money au +226 64 19 79 79, ch??que ou par virement bancaire au b??n??fice du fournisseur.
			</p>

			<h4><strong><u>ARTICLE 3 : DUREE DU CONTRAT</u></strong></h4>

			<p>
				L'abonnement prend effet lorsque le service est install?? et en service chez le client. L'abonnement est souscrit pour une p??riode minimale d???une ann??e.
				Il est renouvelable par tacite reconduction pour une dur??e ind??termin??e sauf instruction contraire de l???une ou l???autre partie par ??crit au moins trois (3) mois avant l???expiration de la p??riode initiale d???un (01) ans.

			</p>
			<h4><strong><u>ARTICLE 4 : MODIFICATIONS</u></strong></h4>
			<p>
				Le fournisseur s???engage ?? informer l???abonn??, un mois ?? l???avance, de toute modification portant sur le contenu des prestations fournies, de leur dur??e et de leur prix. En cas d???acceptation de ces modifications par le client, les nouvelles dispositions s???appliqueront ?? la date du changement effectif. En cas de non acceptation de ces modifications, l???abonn?? aura la facult?? de r??silier son abonnement. Il devra proc??der ?? cette r??siliation par courrier, dans le mois pr??c??dant la date du changement effectif.
			</p>
			<h4><strong><u>ARTICLE 5 : RESILIATION</u></strong></h4>
			<h6><strong>5.1 R??siliation normale par l???abonn??</strong></h6>
			<p>
				Le client peut, au terme de l???ann??e contractuel, le r??silier. La r??siliation prend effet si elle est re??ue au moins trois (03) mois avant la fin du pr??sent contrat.
			</p>
			<p>
				Si le client, avant le terme du pr??sent, met fin ou r??silie son contrat, il restera redevable de tous les frais restants dus, jusqu????? l?????ch??ance du contrat
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
				plus profiter du service Internet (Indisponibilit?? totale du service pendant au moins 15 jours) sans pr??judice de tous dommages et int??r??ts. <br>
			</p>
			<p>
				En cas de reconduction pour une p??riode ind??termin??e, il peut ??tre d??nonc?? ?? tout moment par l???une ou l???autre partie, sous r??serve du respect du pr??avis de trois (3) mois notifi?? par ??crit.
			</p>
			<h6><strong>5.2 R??siliation par le fournisseur</strong></h6>

			<p>
				Tout manquement de l???abonn?? aux conditions du pr??sent contrat est de nature ?? entrainer la r??siliation imm??diate de l???abonnement sans pr??judice de tous dommages et int??r??ts. En cas de retard dans les paiements et faute de r??gularisation dans les d??lais pr??vue par la lettre de mise en demeure adress??e par le <strong>fournisseur</strong>, l???abonnement sera imm??diatement r??siliable de plein droit par le fournisseur. Dans tous les cas, les sommes dont l???abonn?? est redevable ?? la date de la r??siliation restent dues par ce dernier.
				En cas d???impay??s, les frais y aff??rents ainsi que ceux n??cessaires ?? leur recouvrement, sont ??galement ?? la charge de l???abonn??

			</p>
			<h6><strong>5.3 R??siliation automatique en cas d???impossibilit?? technique de raccordement</strong></h6>
			<p>
				Dans certains cas, la fourniture du service peut s???av??rer techniquement impossible. Si une telle situation est constat??e, le pr??sent contrat deviendra automatiquement caduc. Le fournisseur en informera l???abonn?? par courrier ou par t??l??phone et lui signalera ult??rieurement toute ??volution du r??seau ou des conditions techniques qui permettrait d???envisager ?? nouveau le raccordement.
			</p>
			<h4><strong><u> ARTICLE 8 : OBLIGATIONS DES PARTIES</u></strong></h4>
			<h6><strong>8.1 OBLIGATIONS DU CLIENT</strong></h6>
			<h6>8.1.1 PROPRIETE ET PROTECTION DE L???EQUIPEMENT</h6>
			<p>
				L?????quipement fourni aux termes des pr??sentes demeure la propri??t?? du fournisseur, toutefois, le client en a l???enti??re responsabilit??. Il doit prot??ger l?????quipement du fournisseur contre la d??t??rioration, l???alt??ration ou les dommages et n???autoriser personne, sauf un repr??sentant du fournisseur, ?? effectuer des travaux ou une quelconque manipulation sur cet ??quipement. Le client devra rembourser au fournisseur le co??t int??gral de la r??paration ou du remplacement de l?????quipement perdu, vol??, endommag??, non retourn?? ??
			</p>
			<br>
		</div>

		<div style="width: 48%;">
				<br>
				<p>l?????ch??ance, hypoth??qu??, vendu, lou??, c??d?? ou transf??r??, en totalit?? ou en partie.</p>
				<h6><strong>8.1.2 USAGE CONFORME</strong></h6>
				<p>
					Le pr??sent contrat n???exon??re pas le client de sa responsabilit?? civile et p??nale dans le cadre des droits li??s ?? l???utilisation de logiciels informatiques. L???abonn?? est responsable des informations qu???il fait transiter par le r??seau du fournisseur, en diffusion ou en lecture, m??me s???il n???en est pas le cr??ateur.
				</p>

				<p>
					Le client est responsable de sa propre s??curit?? informatique. L???abonnement et les ??l??ments de reconnaissance, fournis par le fournisseur, sont personnels et ne peuvent en aucun cas ??tre transf??r??s ?? un tiers sous peine de r??siliation imm??diate selon les dispositions de l???article 7alin??as 2 des pr??sentes.
				</p>
				<p>
					Il est express??ment convenu que l???abonn?? qui c??de son contrat en violation de l???interdiction ci-dessus, reste tenu du r??glement du prix de l???abonnement et de l???int??gralit?? des consommations li??es ?? la formule de fourniture souscrite.
				</p>

				<p>
				Restent ??galement ?? la charge de l???abonn??, sans que puisse ??tre recherch??e la responsabilit?? du fournisseur, les cons??quences dommageables de ses fautes ou n??gligences ainsi que de celles des personnes ou des choses dont il a la garde.
				</p>
				<br><br>
				<h6><strong>8.1.3 INTERDICTIONS</strong></h6>
				<p>
					Il est formellement interdit au client, sous peine de r??siliation de son abonnement et sans pr??judice de tous dommages et int??r??ts et poursuites, d???introduire dans le r??seau des perturbations de toute nature. Dans ce cas, le client sera tenu pour responsable de ces perturbations tant ?? l?????gard du fournisseur qu????? l?????gard des tiers.
				</p>
				<h6><strong>8.2 OBLIGATION DU FOURNISSEUR</strong></h6>
				<p>
					Le fournisseur est responsable de la qualit?? de la connexion depuis le n??ud d???acc??s jusqu???au point d???entr??e du r??seau, propri??t?? du fournisseur, c??t?? client.
				</p>

				<p>
				Le fournisseur ne saurait ??tre tenu responsable des pannes, coupures de lignes, mauvaise configuration de mat??riel, des ??quipements, etc., qui ne sont pas sous son contr??le direct 
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
					ou qu???elle n???a pas fourni, et notamment des liaisons de tous types assur??s par d???autres prestataires.
				</p>

				<p>
					Le fournisseur ne garantit pas les taux de transfert et les temps de r??ponse des informations circulant dans le r??seau Internet.
				</p>
				<p>
					L???acc??s au r??seau sera en principe assur?? en permanence, sous r??serve de contraintes et al??as ind??pendants de la volont?? du fournisseur, affectant la continuit?? et la qualit?? du service, et ne pouvant ??tre raisonnablement surmont??s ou ??vit??s malgr?? les pr??cautions prises lors de la conception, de la construction, de l???entretien et de l???exploitation de la plateforme de connexion ou du r??seau.
				</p>
				<p>
					Les contraintes et al??as peuvent ??tre soit inh??rents aux mat??riels ou aux logiciels compte tenu des connaissances acquises en la mati??re et des technologies utilisables, soit ext??rieurs dans le cas d???actions de tiers volontaires ou accidentelles, d???incendie, d???explosion, d???accident de toute nature. Ces cas ne sont pas limitatifs et ne sont pas n??cessairement constitutifs de cas de force majeure au sens strict entendu par la jurisprudence.
				</p>
				<p>
					Les interruptions programm??es du service, pour effectuer des travaux de toute nature n??cessaires ?? l???entretien ou ?? l?????volution de l???offre feront l???objet d???un avis ?? l???abonn?? et ne donneront lieu ?? aucune indemnisation. Les travaux programmables ?? l???avance (entretien, extension, etc.) seront effectu??s dans toute la mesure du possible, en dehors des plages de grande utilisation.
				</p>
				<p>
					En cas d???interruption du service, le fournisseur prendra imm??diatement les dispositions n??cessaires pour assurer sa remise en service dans les meilleurs d??lais.
				</p>
				<p>
					Le fournisseur est responsable des outils logiciels mis ?? la disposition de ses abonn??s lors de la souscription du contrat et n??cessaire ?? la connexion et ?? l?????change de donn??es entre le site du client et la plateforme informatique du fournisseur.
				</p>

				<br> <br> <br> <br>
				<h4><strong>ARTICLE 9 : JURIDICTION COMPETENTE ET DROIT APPLICABLE</strong></h4>
		</div>

		<div style="width: 48%;">
				<br>
				<p>
				Tout diff??rend, difficult?? ou contestation relatif ?? l???ex??cution ou l???interpr??tation du pr??sent contrat sera r??gl?? amiablement. En l???absence d???accord amiable le diff??rend, difficult?? ou contestation sera r??gi par le tribunal du commerce du Burkina Faso. 
				</p>
				<p>
				Les pr??sentes conditions sont r??dig??es en langue fran??aise
				</p>
				<h4><strong>ARTICLE 10 : ELECTION DE DOMICILE</strong></h4>
				<p>Pour tout ce qui n???est pas pr??cis?? au contrat, les parties s???en remettent aux dispositions l??gales et r??glementaires en vigueur au Burkina Faso.</p> <br>
				<p>
				Les parties d??clarent avoir pris connaissance des dispositions l??gales, r??glementaires et conventionnelles en mati??re de t??l??com et en acceptent l???application dans le cadre du pr??sent contrat.
				</p>
				<p>
				Le contrat est ??tablit en deux (02) exemplaires originaux, dont un exemplaire est remis ?? chaque partie.
				</p>
				<br>
				<p><strong>EN FOI DE QUOI, LES PARTIES ONT SIGNE LES PRESENTES</strong></p>
				<p>Date d'activation le </p>
				
				<p>
					Fait ?? Ouagadougou, le {{ $date_contrat }}
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