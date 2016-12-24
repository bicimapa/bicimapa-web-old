<?php


function tr($key) {
	
	$lang=$_SESSION["locale"];
	
	if(
		$lang!="ES" &&
		$lang!="FR" &&
		$lang!="EN" 
	)
		 $lang="ES";//Si el lenguaje no existe

	$txt = array();

	$txt["ES"] = array(

		"ciudad" => "Ciudad",
		"ciudades" => "Ciudades",
		"ir" => "Ir",
		"menu" => "Menu",
		"agregar_sitio" => "Agregar Sitio",
		"que_mas_hay" => "¿Qué más hay?",
		"sobre_el_bicimapa" => "Sobre el bicimapa",
		"que_es" => "¿Qué es?",
		"ayuda" => "Ayuda",
		"terminos_y_condiciones" => "Términos y condiciones",
		"sugerencias" => "Sugerencias",
		"bicigente" => "Bicigente",
		"biciplanes" => "Biciplanes",
		"biciblog" => "Biciblog",
		"buscar" => "Buscar",
		"filtros" => "Filtros",
		"todos" => "Todos",
		"ninguno" => "Ninguno",
		"actualizar" => "Actualizar",
		"inicio" => "Inicio",
		"ciclorrutas" => "V&iacute;a Exclusiva",
		"ciclovias" => "V&iacute;a Recreativa",
		"sin_definir" => "Sin definir",
		"tienda" => "Tienda",
		"parqueadero" => "Parqueadero",
		"taller" => "Taller",
		"ruta" => "Ruta",
		"advertencia" => "Advertencia",
		"el_bicitante" => "El Bicitante",
		"biciamigo" => "Biciamigo",
		"comentar_y_calificar" => "Comentar y Calificar",
		"ver_ruta" => "Ver ruta",
		"ocultar_ruta" => "Ocultar ruta",
		"agregar_sitio_en_esta_ubicacion" => "Agregar Sitio en esta ubicación",
		"sugerir_un_sitio_en_el_bicimapa" => "Sugerir un sitio en el bicimapa",
		"nombre_del_sitio" => "Nombre del Sitio",
		"tipo_de_sitio" => "Tipo de sitio",
		"descripcion" => "Descripción",
		"explicaciones_navegacion" => "Navegue el mapa y haga click en la posicion exacta del sitio o arrastre el marcador al sitio que quiere sugerir.",
		"explicaciones_navegacion_ruta" => "Haz click sobre ubicaciones en el mapa para insertar una l&iacute;nea entre ellos y formar la ruta",
		"aumentar_mapa" => "Aumentar Mapa",
		"dirrecion_o_indicaciones" => "Dirección o indicaciones de llegada (Opcional)",
		"telefono_o_celular" => "Teléfono o celular del sitio (Opcional)",
		"horario" => "Horario de atención del sitio (Opcional)",
		"candado?" => "¿Proveen candado? (Opcional)",
		"si" => "Sí",
		"no" => "No",
		"no_se" => "No sé",
		"cubierto?" => "¿Cubierto? (Opcional)",
		"tarifa" => "Tarifa (Opcional)",
		"cupos" => "Cupos (Opcional)",
		"tu_nombre" => "Tu Nombre (Opcional)",
		"tu_email" => "Tu correo electrónico (Opcional)",
		"recibir_noticias?" => "Deseo recibir noticias y promociones de Bicimapa y sus asociados.",
		"enviar" => "Enviar",
		"directorio" => "Directorio",
		"ordenar_por" => "Ordenar por:",
		"categoria" => "Categoría",
		"calendario" => "Calendario",
		"sugerir_un_evento" => "Sugerir un evento",
		"eventos_gestionados_gran_rodada" => "Eventos gestionados por ",
		"sobre_bicimapa" => "Sobre bicimapa",
		"descripcon_bicimapa" => "
				<p>El bicimapa ser&aacute; un espacio donde todos los usuarios de la bici podr&aacute;n encontrar datos de inter&eacute;s para moverse por la ciudad, no s&oacute;lo de sitios sino que tambi&eacute;n podr&aacute;s programarte para pedalear tu ciudad junto a personas como t&uacute;.</p>
				<p>En este mapa es posible incluir informaci&oacute;n como:</p>
				<ul>
					<li>Bicicleter&iacute;as</li>
					<li>Tiendas especializadas</li>
					<li>Cicloparqueadores gratis</li>
					<li>Rutas</li>
					<li>Advertencias</li>
				</ul>",
		"que_es_bicimapa" => "<p>El bicimapa, el mapa de los ciclistas en Colombia, es una aplicaci&oacute;n web que mediante m&aacute;s y mejor informaci&oacute;n quiere incentivar el uso de la bicicleta. Su forma de funcionamiento es el modo de trabajo tipo wiki, es decir, ciclistas urbanos de manera voluntaria incluyen informaci&oacute;n &uacute;til para los usuarios del mapa.</p>
				<p>Como el eslogan del bicimapa claramente lo dice: \"El mapa de los ciclistas en Colombia. &uacute;salo, mej&oacute;ralo y comp&aacute;rtelo.\" Se quiere que el mayor n&uacute;mero de personas encuentren en &eacute;ste una herramienta de f&aacute;cil uso que con el aporte de toda la comunidad ciclista mejoren la informaci&oacute;n.</p>
				<p>Con m&aacute;s y mejor informaci&oacute;n, Bogot&aacute; seguir&aacute; siendo mejor en bici.</p>",
		"campos_obligatorios" => "Complete los campos obligatorios.",
		"ubicar_sitio" => "Debe ubicar el sitio en el mapa.",
		"gracias_sugerencia" => "<p>Gracias por la sugerencia! Pronto estaremos valid&aacute;ndola y agreg&aacute;ndola al mapa.</p><p>Compartir en: ",
		"error_sugerencia" => "Ocurri&oacute; un error al guardar el sitio :(",
		"coordenadas_error_sugerencia" => "Las coordenadas no eran correctas :(",
		"campos_error_sugerencia" => "Al menos debes escribir el nombre del sitio, una descripci&oacute;n y seleccionar su ubicaci&oacute;n.",
		"sugerir_cambio" => "Sugerir cambio",
		"sugerir_direccion" => "Sugerir dirección",
		"sugerir_telefono" => "Sugerir téléfono",
		"sugerir_horario" => "Sugerir horario",
		"direccion" => "Dirección",
		"telefono" => "Teléfono",
		"horario_b" => "Horario",
		"tipo" => "Tipo",
		"calificacion_promedio" => "Calificación promedio",
		"sin_calificaciones" => "Sin calificaciones",
		"tu_calificacion" => "Tu calificación",
		"compartir" => "Compartir",
		"ver_en_el_mapa" => "Ver en el mapa",
		"comentarios" => "Comentarios",
		"puedes_comentar" => "Puedes comentar con tu cuenta de facebook a continuaci&oacute;n o con tu cuenta de twitter, google+ y disqus en la parte de abajo. (No queremos que tengas que memorizar m&aacute;s contrase&#241;as :) )",
		"no_se_encontro_lugar" => "No se encontró el lugar",
		"no_se_encontro_ciudad" => "No se encontró la ciudad",
		"alquiler" => "Bicis p&uacute;blicas",
		"permalink" => "Enlace Permanente",
		"titulo" => "El mapa de los ciclistas en la ciudad",
		"borrar_ruta"  => "Borrar ruta",
		"borrar_ultimo_punto"  => "Borrar &uacute;ltimo punto",
		"advertencia_ruta_borrar" => "La ruta se borra al cambiar el tipo de sitio. Continuar?",
		"posicion_actual" => "Tu ubicaci&oacute;n actual",
		"aumentar_mapa"=>"Aumentar Mapa",
		"reducir_mapa"=>"Reducir Mapa",
		"share_string" => "Acabo de sugerir el sitio %s en el Bicimapa.",
		"final" => "Final"
	);

	$txt["FR"] = array(

		"ciudad" => "Ville",
		"ciudades" => "Villes",
		"ir" => "Aller",
		"menu" => "Menu",
		"agregar_sitio" => "Ajouter un lieu",
		"que_mas_hay" => "Qu'y a t-il de plus?",
		"sobre_el_bicimapa" => "A propos de bicimapa",
		"que_es" => "Qu'est ce que c'est?",
		"ayuda" => "Aide",
		"terminos_y_condiciones" => "Termes et conditions d'utilisation",
		"sugerencias" => "Suggestions",
		"bicigente" => "Annuaire",
		"biciplanes" => "Evénements",
		"biciblog" => "Blog",
		"buscar" => "Chercher",
		"filtros" => "Filtres",
		"todos" => "Tous",
		"ninguno" => "Aucun",
		"actualizar" => "Actualiser",
		"inicio" => "Début",
		"ciclorrutas" => "Pistes cyclables",
		"ciclovias" => "Pistes cyclables récréatives",
		"sin_definir" => "Indéfini",
		"tienda" => "Boutique",
		"parqueadero" => "Parking",
		"taller" => "Mécanicien",
		"ruta" => "Raccourcis",
		"advertencia" => "Vigilence",
		"el_bicitante" => "El Bicitante",
		"biciamigo" => "Biciacceuillant",
		"comentar_y_calificar" => "Commenter et noter",
		"ver_ruta" => "Voir le raccourcis",
		"ocultar_ruta" => "Cacher le raccourcis",
		"agregar_sitio_en_esta_ubicacion" => "Ajouter un lieu ici",
		"sugerir_un_sitio_en_el_bicimapa" => "Suggérer un lieu à bicimapa",
		"nombre_del_sitio" => "Nom du lieu",
		"tipo_de_sitio" => "Type de lieu",
		"descripcion" => "Description",
		"explicaciones_navegacion" => "Déplacez la carte et faites un clique sur la position exacte du lieu ou déplacez le marqueur en drag'n'drop.",
		"explicaciones_navegacion_ruta" => "Pour entrer le raccourcis: faites un clic sur la carte pour ajouter un point et former une ligne avec le précédent.",
		"aumentar_mapa" => "Agrandir la carte",
		"dirrecion_o_indicaciones" => "Adresse ou indications pour s'y rendre (Optionnel)",
		"telefono_o_celular" => "Téléphone (Optionnel)",
		"horario" => "Horaires d'ouverture (Optionnel)",
		"candado?" => "Cadena fournis? (Optionnel)",
		"si" => "Oui",
		"no" => "Non",
		"no_se" => "Je ne sais pas",
		"cubierto?" => "Couvert? (Optionnel)",
		"tarifa" => "Tarif? (Optionnel)",
		"cupos" => "Nombre de places (Optionnel)",
		"tu_nombre" => "Votre nom (Optionnel)",
		"tu_email" => "Votre email (Optionnel)",
		"recibir_noticias?" => "Je souhaite recevoir des informations et des promotions de bicimapa et de ses associés",
		"enviar" => "Envoyer",
		"directorio" => "Annuaire",
		"ordenar_por" => "Trier par:",
		"categoria" => "Catégorie",
		"calendario" => "Calendrier",
		"sugerir_un_evento" => "Suggérer un événement",
		"eventos_gestionados_gran_rodada" => "Evénements gérés par ", 
		"sobre_bicimapa" => "A propos de bicimapa",
		"descripcon_bicimapa" => "
				<p>Bicimapa es un site communautaire ou les cyclistes urbains peuvent trouver toutes l'information utile pour se déplacer à vélo.</p>
				<p>Les informations disponibles sur cette carte sont:</p>
				<ul>
					<li>Les boutiques</li>
					<li>Les mécaniciens</li>
					<li>Les parkings</li>
					<li>Les pistes cyclables</li>
					<li>...</li>
				</ul>",
		"que_es_bicimapa" => "<p>Bicimapa est la carte des cyclistes urbains du monde entier. C'est une application web qui a débuté à Bogotá (Colombie) afin de promouvoir l'usage du vélo comme moyen de transport alternatif. Cette aplication fonctionne sur le principe des wikis, c'est à dire que l'information est rentré volontairement par les cyclistes urbains du monde entier.</p>
		<p>Le slogan de bicimapa est: \"Bicimapa: La carte des cyclistes urbains du monde entier. Utilisez la, Améliorez la et Partagez la!\". L'objectif est de partager avec un maximum de personnes et au travers d'un outil simple, la connaissance des cyclistes urbains du monde entier.</p>
		<p>Avec toujours plus d'information de qualité, la vie à vélo sera plus facile</p>",
		"campos_obligatorios" => "Vous devez remplir les champs obligatoires.",
		"ubicar_sitio" => "Vous devez indiquer le lieu sur la carte.",
		"gracias_sugerencia" => "<p>Merci pour votre suggestion! Bientôt nous allons la valider et l'ajouter à la carte.</p><p>Partager sur: ",
		"error_sugerencia" => "Une erreur est survenue au moment de sauvegarder le lieu :(",
		"coordenadas_error_sugerencia" => "Les coordonnées n'étaient pas correctes :(",
		"campos_error_sugerencia" => "Le nom du lieu, la description et la localisation sont requis",
		"sugerir_cambio" => "Proposer un complément d'information",
		"sugerir_direccion" => "Renseigner l'adresse",
		"sugerir_telefono" => "Renseigner le téléphone",
		"sugerir_horario" => "Renseigner l'horaire",
		"direccion" => "Adresse",
		"telefono" => "Téléphone",
		"horario_b" => "Horaire",
		"tipo" => "Type",
		"calificacion_promedio" => "Note moyenne",
		"sin_calificaciones" => "Sans note",
		"tu_calificacion" => "Ta note",
		"compartir" => "Partager",
		"ver_en_el_mapa" => "Voir sur la carte",
		"comentarios" => "Commentaires",
		"puedes_comentar" => "Vous pouvez commenter au travers de votre compte Facebook ou Disqus",
		"no_se_encontro_lugar" => "Le lieu n'a pas été trouvé",
		"no_se_encontro_ciudad" => "La ville n'a pas été trouvée",
		"alquiler" => "vélos publics",
		"permalink" => "Permalink",
		"titulo" => "La carte des cyclistes urbains du monde entier",
		"borrar_ruta"  => "Cacher le raccourcis",
		"borrar_ultimo_punto"  => "Effacer le dernier point",
		"advertencia_ruta_borrar" => "Vous allez perdre le tracé du raccourcis si vous changez le type de lieu. Voulez-vous continuer?",
		"posicion_actual" => "Votre position actuelle",
		"aumentar_mapa"=>"Agrandir la carte",
		"reducir_mapa"=>"Rétrécir la carte",
		"share_string" => "Je viens de suggérer le lieu: %s dans bicimapa.",
		"final" => "fin"
	);

	
	$txt["EN"] = array(
	
			"ciudad" => "City",
			"ciudades" => "Cities",
			"ir" => "Go",
			"menu" => "Menu",
			"agregar_sitio" => "Add",
			"que_mas_hay" => "More",
			"sobre_el_bicimapa" => "About bicimapa",
			"que_es" => "What is bicimapa",
			"ayuda" => "Help",
			"terminos_y_condiciones" => "Terms and conditions",
			"sugerencias" => "Feedback",
			"bicigente" => "Directory",
			"biciplanes" => "Events",
			"biciblog" => "Blog",
			"buscar" => "Search",
			"filtros" => "Filters",
			"todos" => "Select all",
			"ninguno" => "Select none",
			"actualizar" => "Update",
			"inicio" => "Home",
			"ciclorrutas" => "Permanent Bikeway",
			"ciclovias" => "Recreational Bikeway",
			"sin_definir" => "Undefined",
			"tienda" => "Bike Shop",
			"parqueadero" => "Parking",
			"taller" => "Repair Shop",
			"ruta" => "Route",
			"advertencia" => "Warning",
			"el_bicitante" => "El Bicitante",
			"biciamigo" => "Bike friendly",
			"comentar_y_calificar" => "Comment and rate",
			"ver_ruta" => "Show route",
			"ocultar_ruta" => "Hide route",
			"agregar_sitio_en_esta_ubicacion" => "Add a place in this location",
			"sugerir_un_sitio_en_el_bicimapa" => "Add a place in bicimapa",
			"nombre_del_sitio" => "Place name",
			"tipo_de_sitio" => "Place category",
			"descripcion" => "Description",
			"explicaciones_navegacion" => "Click the desired position or drag the marker.",
			"explicaciones_navegacion_ruta" => "Click more than two points in order to build up a continuous route",
			"aumentar_mapa" => "Enlarge Map",
			"dirrecion_o_indicaciones" => "Address or directions (Optional)",
			"telefono_o_celular" => "Phone (Optional)",
			"horario" => "Opening hours (Optional)",
			"candado?" => "Provide lock? (Optional)",
			"si" => "Yes",
			"no" => "No",
			"no_se" => "I don't know",
			"cubierto?" => "Indoor? (Optional)",
			"tarifa" => "Parking Fee (Optional)",
			"cupos" => "Total spaces (Optional)",
			"tu_nombre" => "Your name (Optional)",
			"tu_email" => "Your e-mail (Optional)",
			"recibir_noticias?" => "I want to receive updates via email",
			"enviar" => "Submit",
			"directorio" => "Directory",
			"ordenar_por" => "Sort by:",
			"categoria" => "Category",
			"calendario" => "Calendar",
			"sugerir_un_evento" => "submit an event",
			"eventos_gestionados_gran_rodada" => "Events managed by ",
			"sobre_bicimapa" => "About bicimapa",
			"descripcon_bicimapa" => "
				<p>El bicimapa ser&aacute; un espacio donde todos los usuarios de la bici podr&aacute;n encontrar datos de inter&eacute;s para moverse por la ciudad, no s&oacute;lo de sitios sino que tambi&eacute;n podr&aacute;s programarte para pedalear tu ciudad junto a personas como t&uacute;.</p>
				<p>En este mapa es posible incluir informaci&oacute;n como:</p>
				<ul>
					<li>Bicicleter&iacute;as</li>
					<li>Tiendas especializadas</li>
					<li>Cicloparqueadores gratis</li>
					<li>Rutas</li>
					<li>Advertencias</li>
				</ul>",
			"que_es_bicimapa" => "<p>El bicimapa, el mapa de los ciclistas en Colombia, es una aplicaci&oacute;n web que mediante m&aacute;s y mejor informaci&oacute;n quiere incentivar el uso de la bicicleta. Su forma de funcionamiento es el modo de trabajo tipo wiki, es decir, ciclistas urbanos de manera voluntaria incluyen informaci&oacute;n &uacute;til para los usuarios del mapa.</p>
				<p>Como el eslogan del bicimapa claramente lo dice: \"El mapa de los ciclistas en Colombia. &uacute;salo, mej&oacute;ralo y comp&aacute;rtelo.\" Se quiere que el mayor n&uacute;mero de personas encuentren en &eacute;ste una herramienta de f&aacute;cil uso que con el aporte de toda la comunidad ciclista mejoren la informaci&oacute;n.</p>
				<p>Con m&aacute;s y mejor informaci&oacute;n, Bogot&aacute; seguir&aacute; siendo mejor en bici.</p>",
			"campos_obligatorios" => "Please complete all required fields.",
			"ubicar_sitio" => "You must select a location on the map.",
			"gracias_sugerencia" => "<p>Thank you very much! We will review your submission and post it as quickly as possible.</p><p>Share: ",
			"error_sugerencia" => "An error has occurred while saving, please try again :(",
			"coordenadas_error_sugerencia" => "Incorrect coordinates :(",
			"campos_error_sugerencia" => "Please fill the required fields: place name, place description and map location.",
			"sugerir_cambio" => "Suggest Changes",
			"sugerir_direccion" => "Suggest address",
			"sugerir_telefono" => "Suggest phone",
			"sugerir_horario" => "Suggest opening hours",
			"direccion" => "Address",
			"telefono" => "Phone",
			"horario_b" => "Opening hours",
			"tipo" => "Place category",
			"calificacion_promedio" => "Average Rating",
			"sin_calificaciones" => "Not rated yet",
			"tu_calificacion" => "Your rating",
			"compartir" => "Share",
			"ver_en_el_mapa" => "View location on the map",
			"comentarios" => "Comments",
			"puedes_comentar" => "Comment with your facebook account or use twitter, google+ and disqus account below. (You don't need to remember more passwords :) )",
			"no_se_encontro_lugar" => "Place Not Found",
			"no_se_encontro_ciudad" => "City not found",
			"alquiler" => "Public bikes",
			"permalink" => "Permalink",
			"titulo" => "Map for the urban cyclist",
			"borrar_ruta"  => "Delete Route",
			"borrar_ultimo_punto"  => "Delete last point",
			"advertencia_ruta_borrar" => "The route is deleted if you change the place category. Continue?",
			"posicion_actual" => "Your position",
			"aumentar_mapa"=>"Bigger Map",
			"reducir_mapa"=>"Smaller Map",
			"share_string" => "I've just added a new place on Bicimapa: %s",
			"final" => "Final"
	);


	if(isset($txt[$lang][$key])) return $txt[$lang][$key];
	else return "?";

}


