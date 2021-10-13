<!DOCTYPE html>
<html class="no-js" lang="{{__('en')}}" dir="ltr">
<head>
	<meta charset="utf-8">
	<!-- Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
		wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html -->
	@yield('title')
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta content="width=device-width,initial-scale=1" name="viewport">
    <meta property="dcterms.creator" content='{{__("Health Canada")}}'>
    @yield('meta')
    <meta property="dcterms.issued" title="W3CDTF" content="2021-10-01">
    <meta property="dcterms.modified" title="W3CDTF" content="2021-10-01">
    <meta property="dcterms.language" title="ISO639-2/T" content='{{__("eng")}}'>
	<link href="/GCWeb/src/assets/favicon.ico" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<noscript><link rel="stylesheet" href="/wet-boew-4.0.36/css/noscript.min.css" /></noscript>
    <link rel="stylesheet" href="/GCWeb/themes-dist-8.0-gcweb/css/theme.min.css">
	<!--<script type="text/javascript">
		var defTop = document.getElementById("def-top");
		defTop.outerHTML = wet.builder.top({
			cdnEnv:"prod",
			//topSecMenu:true,
			lngLinks:[{
				lang:"en",
				href: "/content",
				text: "Francais"
			}],
			breadcrumbs:jsonbread,
		});
	</script>
        -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha384-rY/jv8mMhqDabXSo+UCggqKtdmBfd3qC2/KvyTDNQ6PcUJXaxK1tMepoQda4g5vB" crossorigin="anonymous"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-181759316-1" integrity="sha384-w4Zjdv3YvW+Jt04BH5VFdjaCNEs8lDNpB6qszS8pyr9VtdGMjBq5d32BoXmCp9Zt" crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-181759316-1');
    </script>
</head>
<body vocab="http://schema.org/" typeof="WebPage">
  <nav>
    <ul id="wb-tphp">
      <li class="wb-slc">
	<a class="wb-sl" href="#wb-cont">{{__("Skip to main content")}}</a>
      </li>
      <li class="wb-slc">
	<a class="wb-sl" href="#wb-info">{{__("Skip to 'About government'")}}</a>
      </li>
    </ul>
  </nav>
	<div id="def-top">
		<header>
			<div id="wb-bnr" class="container">
				<div class="row">
                    @if (Config::get('app.locale')=="en")
                        <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
                            <h2 class="wb-inv">Language selection</h2>
                            <ul class="list-inline mrgn-bttm-0">
                                <li>
                                    @yield('frswitch')
                                        <span class="hidden-xs">Français</span>
                                        <abbr id="abfr" title="Français" class="visible-xs h3 mrgn-tp-sm mrgn-bttm-0 text-uppercase">Fr</abbr>
                                    </a>
                                </li>
                            </ul>
                        </section>
                    @elseif (Config::get('app.locale')=="fr")
                        <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
                            <h2 class="wb-inv">Language selection</h2>
                            <ul class="list-inline mrgn-bttm-0">
                                <li>
                                    @yield('enswitch')
                                        <span class="hidden-xs">English</span>
                                        <abbr id="abfr" title="English" class="visible-xs h3 mrgn-tp-sm mrgn-bttm-0 text-uppercase">En</abbr>
                                    </a>
                                </li>
                            </ul>
                        </section>
                    @endif
					<div class="brand col-xs-9 col-sm-5 col-md-4" property="publisher" typeof="GovernmentOrganization">
						<a href="https://www.canada.ca/en.html" property="url">
							<img src="/GCWeb/src/assets/sig-blk-en.svg" alt="" property="logo"><span class="wb-inv" property="name"> Government of Canada / <span lang="fr">Gouvernement du Canada</span></span>
						</a>
						<meta property="areaServed" typeof="Country" content="Canada">
						<link property="logo" href="GCWeb/src/assets/wmms-blk.svg">
					</div>
					<section id="wb-srch" class="col-lg-offset-4 col-md-offset-4 col-sm-offset-2 col-xs-12 col-sm-5 col-md-4">
						<h2>Search</h2>
						<form action="https://www.canada.ca/{{__('en')}}/sr/srb.html" method="post" name="cse-search-box" role="search">
							<div class="form-group wb-srch-qry">
								<label for="wb-srch-q" class="wb-inv">{{__("Search Canada.ca")}}</label>
								<input id="wb-srch-q" list="wb-srch-q-ac" class="wb-srch-q form-control" name="q" type="search" value="" size="34" maxlength="170" placeholder="{{__('Search Canada.ca')}}">
								<datalist id="wb-srch-q-ac">
								</datalist>
							</div>
							<div class="form-group submit">
								<button type="submit" id="wb-srch-sub" class="btn btn-primary btn-small" name="wb-srch-sub"><span class="glyphicon-search glyphicon"></span><span class="wb-inv">Search</span></button>
							</div>
						</form>
					</section>
				</div>
			</div>
			@if (Config::get('app.locale')=="en")
				<nav class="gcweb-menu" typeof="SiteNavigationElement">
					<div class="container">
						<h2 class="wb-inv">Menu</h2>
						<button type="button" aria-haspopup="true" aria-expanded="false"><span class="wb-inv">Main </span>Menu <span class="expicon glyphicon glyphicon-chevron-down"></span></button>
						<ul role="menu" aria-orientation="vertical" data-ajax-replace="https://www.canada.ca/content/dam/canada/sitemenu/sitemenu-v2-en.html">
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/jobs.html">Jobs and the workplace</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/immigration-citizenship.html">Immigration and citizenship</a></li>
							<li role="presentation"><a role="menuitem" href="https://travel.gc.ca/">Travel and tourism</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/business.html">Business and industry</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/benefits.html">Benefits</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/health.html">Health</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/taxes.html">Taxes</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/environment.html">Environment and natural resources</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/defence.html">National security and defence</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/culture.html">Culture, history and sport</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/policing.html">Policing, justice and emergencies</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/transport.html">Transport and infrastructure</a></li>
							<li role="presentation"><a role="menuitem" href="https://international.gc.ca/world-monde/index.aspx?lang=eng">Canada and the world</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/finance.html">Money and finances</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/en/services/science.html">Science and innovation</a></li>
						</ul>
					</div>
				</nav>
				<nav id="wb-bc" property="breadcrumb">
					<h2>You are here:</h2>
					<div class="container">
						<ol class="breadcrumb">
							<li><a href="https://www.canada.ca/en.html">Home</a></li>
                            <li><a href="https://www.canada.ca/en/services/health.html">Health</a></li>
                            <li><a href="https://www.canada.ca/en/services/health/drug-health-products.html">Drug and health products</a></li>
                            <li><a href="https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products.html">Inspecting and monitoring drug and health products</a></li>
                            <li><a href="https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections.html">Drug and health product inspections</a></li>
						</ol>
					</div>
				</nav>
			@elseif(Config::get('app.locale')=="fr")
				<nav class="gcweb-menu" typeof="SiteNavigationElement">
					<div class="container">
						<h2 class="wb-inv">Menu</h2>
						<button type="button" aria-haspopup="true" aria-expanded="false">Menu<span class="wb-inv"> principal</span> <span class="expicon glyphicon glyphicon-chevron-down"></span></button>
						<ul role="menu" aria-orientation="vertical" data-ajax-replace="https://www.canada.ca/content/dam/canada/sitemenu/sitemenu-v2-fr.html">
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/emplois.html">Emplois et milieu de travail</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/immigration-citoyennete.html">Immigration et citoyenneté</a></li>
							<li role="presentation"><a role="menuitem" href="https://voyage.gc.ca/">Voyage et tourisme</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/entreprises.html">Entreprises et industrie</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/prestations.html">Prestations</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/sante.html">Santé</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/impots.html">Impôts</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/environnement.html">Environnement et ressources naturelles</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/defense.html">Sécurité nationale et défense</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/culture.html">Culture, histoire et sport</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/police.html">Services de police, justice et urgences</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/transport.html">Transport et infrastructure</a></li>
							<li role="presentation"><a role="menuitem" href="https://international.gc.ca/world-monde/index.aspx?lang=fra">Canada et le monde</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/finance.html">Argent et finances</a></li>
							<li role="presentation"><a role="menuitem" href="https://www.canada.ca/fr/services/science.html">Science et innovation</a></li>
						</ul>
					</div>
				</nav>
				<nav id="wb-bc" property="breadcrumb">
					<h2>Vous êtes ici :</h2>
					<div class="container">
						<ol class="breadcrumb">
                        <li><a href="https://www.canada.ca/fr.html">Accueil</a></li>
                            <li><a href="https://www.canada.ca/fr/services/sante.html">Santé</a></li>
                            <li><a href="https://www.canada.ca/fr/services/sante/medicaments-et-produits-sante.html">Médicaments et produits de santé</a></li>
                            <li><a href="https://www.canada.ca/fr/sante-canada/services/inspection-et-controle-produits-sante.html"> Inspection et contrôle des produits de santé</a></li>
                            <li><a href="https://www.canada.ca/fr/sante-canada/services/inspection-et-controle-produits-sante/inspections-medicaments-et-produits-sante.html">Inspections des médicaments et des produits de santé</a></li>
						</ol>
					</div>
				</nav>
			@endif
		</header>
		<!-- Static header ends -->
	</div>

	<main property="mainContentOfPage" class="container" typeof="WebPageElement">
		@yield ('content')
		<div class="pagedetails">
			<div class="row">
				<div class="col-sm-6 col-md-5 col-lg-4">
                        @if(Config::get('app.locale')=="en")
                            <a href="https://www.canada.ca/en/report-problem.html" class="btn btn-default btn-block">Report a problem or mistake on this page</a>
                        @else
                        <a href="https://www.canada.ca/fr/signaler-probleme.html" class="btn btn-default btn-block">Signaler un problème ou une erreur sur cette page</a>
                        @endif
				</div>
				<div class="wb-share col-sm-4 col-md-3 col-sm-offset-2 col-md-offset-4 col-lg-offset-5" data-wb-share='{"lnkClass": "btn btn-default btn-block"}'></div>
			</div>
		</div>
	</main>

	<!-- Static footer starts -->
	@if(Config::get('app.locale')=="en")
		<footer id="wb-info">
			<div class="landscape">
				<nav class="container wb-navcurr">
					<h2 class="wb-inv">About government</h2>
					<ul class="list-unstyled colcount-sm-2 colcount-md-3">
						<li><a href="https://www.canada.ca/en/contact.html">Contact us</a></li>
						<li><a href="https://www.canada.ca/en/government/dept.html">Departments and agencies</a></li>
						<li><a href="https://www.canada.ca/en/government/publicservice.html">Public service and military</a></li>
						<li><a href="https://www.canada.ca/en/news.html">News</a></li>
						<li><a href="https://www.canada.ca/en/government/system/laws.html">Treaties, laws and regulations</a></li>
						<li><a href="https://www.canada.ca/en/transparency/reporting.html">Government-wide reporting</a></li>
						<li><a href="https://pm.gc.ca/eng">Prime Minister</a></li>
						<li><a href="https://www.canada.ca/en/government/system.html">How government works</a></li>
						<li><a href="https://open.canada.ca/en/">Open government</a></li>
					</ul>
				</nav>
			</div>
			<div class="brand">
				<div class="container">
					<div class="row">
						<nav class="col-md-9 col-lg-10 ftr-urlt-lnk">
							<h2 class="wb-inv">About this site</h2>
							<ul>
								<li><a href="https://www.canada.ca/en/social.html">Social media</a></li>
								<li><a href="https://www.canada.ca/en/mobile.html">Mobile applications</a></li>
								<li><a href="https://www1.canada.ca/en/newsite.html">About Canada.ca</a></li>
								<li><a href="https://www.canada.ca/en/transparency/terms.html">Terms and conditions</a></li>
								<li><a href="https://www.canada.ca/en/transparency/privacy.html">Privacy</a></li>
							</ul>
						</nav>
						<div class="col-xs-6 visible-sm visible-xs tofpg"> <a href="#wb-cont">Top of Page <span class="glyphicon glyphicon-chevron-up"></span></a> </div>
						<div class="col-xs-6 col-md-3 col-lg-2 text-right"> <img src="/GCWeb/src/assets/wmms-blk.svg" alt="Symbol of the Government of Canada"> </div>
					</div>
				</div>
			</div>
		</footer>
	@elseif(Config::get('app.locale')=="fr")
		<footer id="wb-info">
			<div class="landscape">
				<nav class="container wb-navcurr">
					<h2 class="wb-inv">Au sujet du gouvernement</h2>
					<ul class="list-unstyled colcount-sm-2 colcount-md-3">
						<li><a href="https://www.canada.ca/fr/contact.html">Contactez-nous</a></li>
						<li><a href="https://www.canada.ca/fr/gouvernement/min.html">Ministères et organismes</a></li>
						<li><a href="https://www.canada.ca/fr/gouvernement/fonctionpublique.html">Fonction publique et force militaire</a></li>
						<li><a href="https://www.canada.ca/fr/nouvelles.html">Nouvelles</a></li>
						<li><a href="https://www.canada.ca/fr/gouvernement/systeme/lois.html">Traités, lois et règlements</a></li>
						<li><a href="https://www.canada.ca/fr/transparence/rapports.html">Rapports à l'échelle du gouvernement</a></li>
						<li><a href="https://pm.gc.ca/fra">Premier ministre</a></li>
						<li><a href="https://www.canada.ca/fr/gouvernement/systeme.html">Comment le gouvernement fonctionne</a></li>
						<li><a href="https://ouvert.canada.ca/">Gouvernement ouvert</a></li>
					</ul>
				</nav>
			</div>
			<div class="brand">
				<div class="container">
					<div class="row">
						<nav class="col-md-9 col-lg-10 ftr-urlt-lnk">
							<h2 class="wb-inv">À propos du site</h2>
							<ul>
								<li><a href="https://www.canada.ca/fr/sociaux.html">Médias sociaux</a></li>
								<li><a href="https://www.canada.ca/fr/mobile.html">Applications mobiles</a></li>
								<li><a href="https://www1.canada.ca/fr/nouveausite.html">À propos de Canada.ca</a></li>
								<li><a href="https://www.canada.ca/fr/transparence/avis.html">Avis</a></li>
								<li><a href="https://www.canada.ca/fr/transparence/confidentialite.html">Confidentialité</a></li>
							</ul>
						</nav>
						<div class="col-xs-6 visible-sm visible-xs tofpg">
							<a href="#wb-cont">Haut de la page <span class="glyphicon glyphicon-chevron-up"></span></a>
						</div>
						<div class="col-xs-6 col-md-3 col-lg-2 text-right">
							<img src="../GCWeb/assets/wmms-blk.svg" alt="Symbole du gouvernement du Canada">
						</div>
					</div>
				</div>
			</div>
		</footer>
		@endif
	<script src="/GCWeb/themes-dist-8.0-gcweb/js/wet-boew.min.js"></script>
	<script src="/GCWeb/themes-dist-8.0-gcweb/js/theme.min.js"></script>
</body>
</html>
