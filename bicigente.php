<?php 
$pagina='bicigente.php';
$top_titulo="Bicigente - Directorio de colectivos";
include_once('top.php');?>

		<div class="row">
			<div class="large-6 columns">
			<h2><?php echo tr("directorio"); ?></h2>
			</div>
			<div class="large-6 columns text-right">
			<?php echo tr("ordenar_por"); ?> <a href="?o=categoria"><?php echo tr("categoria"); ?></a> | <a href="?o=ciudad"><?php echo tr("ciudad"); ?></a>
			</div>
		</div>
		
		<?php 
		
		
		function imprimir_bicigente($i){
				$gentei="";
				
				if(!empty($i['imagen'])) $pic=$i['imagen'];
				else{
					if(!empty($i['facebook'])) $pic="https://graph.facebook.com/".darFacebookId($i['facebook'])."/picture";
					else $pic=url()."img/bicigente.png";
				}
				
				$gentei.='
				<div class="row  bicigente_nombre">
					<div class="large-6 columns">
						<h3><img src="'.$pic.'"/> '.$i['nombre'].'</h3>
					</div>
					<div class="large-6 columns">';
				
				if(!empty($i['facebook'])){$gentei.='<a href="'.$i['facebook'].'"><img src="'.url().'img/facebook.png"> Facebook</a> '; }
				if(!empty($i['twitter'])){$gentei.='<a href="'.$i['twitter'].'"><img src="'.url().'img/twitter.png"> Twitter</a> '; }
				if(!empty($i['web'])){
					/*
					$laweb = str_replace("http://", "", $i['web']);
					$laweb = str_replace("https://", "", $laweb);
					$laweb = str_replace("www.", "", $laweb);
					if(strlen($laweb)>50) 
					*/
					$laweb="Web";
					$gentei.='<a href="'.$i['web'].'"><img src="'. url().'img/enlace.png"> '.$laweb.'</a> ';
				}
				
				if(!empty($i['descripcion'])){
				$gentei.='
					</div>
					<div class="large-12 columns">
						<p>'.$i['descripcion'].'</p>
				';
				}
				$gentei.='
					</div>
				</div>
				';
				/*
				$gentei.='
					</div>
					<div class="large-12 columns">
						<p><strong>'.$i['ciudad'].'</strong> - Descripcion</p>
					</div>
				</div>
				
				';
				*/
				
				return $gentei;
		}
		
		$orden=0;
		if(isset($_GET['o'])&&$_GET['o']=="ciudad") $orden=1;
		
		if($orden==0){
		
			$gente=darBicigente(0);//ordenado por categoria
		
			$tipo="";
			$ciudad="";
			$genteciudad=array();
			
			foreach($gente as $i){
				$eltipo=$i['tipo'];
				if($tipo!=$eltipo){
					$tipo=$eltipo;
					?>
						<div class="bicigente_bloque_categoria">
							<?php foreach($genteciudad as $gc) echo $gc;?>
						</div>
						
						<div class="row">
							<div class="large-12 columns bicigente_categoria">
								<a href="#<?php echo $tipo;?>"><h3 id="<?php echo $tipo;?>"><?php echo $tipo;?></h3></a>
							</div>
						</div>	
					<?php 
					
					$genteciudad=array();
					$ciudad="";
				}
				
				$laciudad=$i['ciudad'];
				if($ciudad!=$laciudad){
					$ciudad=$laciudad;
					$genteciudad[]='
						<div class="row">
							<div class="large-12 columns bicigente_ciudad">
								<h3>'.$ciudad.'</h3>
							</div>
						</div>';
				}
				
				$genteciudad[]=imprimir_bicigente($i);
			}
		
		}
		else{
		
			$gente=darBicigente(1);//ordenado por ciudad
		
			$tipo="";
			$ciudad="";
			$genteciudad=array();
			
			foreach($gente as $i){
			
				$laciudad=$i['ciudad'];
				if($ciudad!=$laciudad){
					$ciudad=$laciudad;
					?>
						<div class="bicigente_bloque_categoria">
							<?php foreach($genteciudad as $gc) echo $gc;?>
						</div>
						
						<div class="row">
							<div class="large-12 columns bicigente_categoria">
								<a href="#<?php echo $ciudad;?>"><h3 id="<?php echo $ciudad;?>"><?php echo $ciudad;?></h3></a>
							</div>
						</div>	
					<?php 
					$genteciudad=array();
					$tipo="";
				}
				
				$eltipo=$i['tipo'];
				if($tipo!=$eltipo){
					$tipo=$eltipo;					
					$genteciudad[]='
						<div class="row">
							<div class="large-12 columns bicigente_ciudad">
								<h3>'.$tipo.'</h3>
							</div>
						</div>';
				}

				$genteciudad[]=imprimir_bicigente($i);
			}
		
		}
		?>

		<div class="bicigente_bloque_categoria">
			<?php foreach($genteciudad as $gc) echo $gc;?>
		</div>
  
<?php include_once('pie.php');?>
