<?php
include_once('../utils/usr_permission.php');

//(new UsrPermission())->requestAccessPage(PermissionType::MAIN);
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::MAIN);

include_once('../utils/generic_tags.php');
include_once('../utils/config.php');

$access = new UsrPermission();
$config = Config::getInstance();

if( $access->isPageAllowed(PermissionType::PLACES) )
{
	include_once('../controller/c_places.php');
	$control = new ControllerPlaces();
}
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.24.custom.css"/>
	<link rel="stylesheet" type="text/css" href="../css/jquery.ui.potato.menu.css"/>
	<link rel="stylesheet" type="text/css" href="../css/main_style.css"/>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	
	
	<script type="text/javascript" src="../js/jquery-1.8.0.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.24.custom.min.js"></script>
	<script type="text/javascript" src="../js/jquery.ui.potato.menu.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie-1.3.js"></script>
	<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
	
	<title><?php echo $tag_company_name; ?></title>
	
	<script >
	var currentUrlCookieName = 'currentUrl';
	
	
	$(document).ready(function() {
	
		manageRefreshPage();
		
		// First time load
		loadPage($.cookie(currentUrlCookieName));
		
		//$('#bar_menu').menu();
		$('#bar_menu').ptMenu();
		
		// Page menu loader
		$('.menu_nav').click(function(){
			loadPage( $(this).attr('url') );
		});
	
	<?php if( $access->isPageAllowed(PermissionType::PLACES) ) { ?>
		$('#selectPlaceStore').change(function(){
			$.post("places/places_form.php", { selectPlaceStore: $('#selectPlaceStore').val() }, function(data){
				reloadMain();
			});
		});
		
		$('#selectPlaceShop').change(function(){
			$.post("places/places_form.php", { selectPlaceShop: $('#selectPlaceShop').val() }, function(data){
				reloadMain();
			});
		});
	<?php } ?>
	});
	
	function loadPage(url)
	{
		if(url != '')
		{
			$('#content').load( url );
			$.cookie(currentUrlCookieName, url);
		}
		else
			$.cookie(currentUrlCookieName, 'infos/welcome.php');
	}
	
	function reloadMain()
	{
		$('#content').load( $.cookie(currentUrlCookieName) );
	}
	
	function updatePlacesBar(place)
	{
		/*if( place == 'stores' && $('#selectPlaceStore').length > 0 )
		{
			$.post("places/ajax_places_select.php", {place: place}, function(data){
				$('#selectPlaceStore').replaceWith( data );
			});
		}
		else if( place == 'shops' && $('#selectPlaceShop').length > 0 )
		{
			//$('#selectPlaceShop').replaceWith();
		}*/
	}
	
	function manageRefreshPage()
	{
		// Saving the current url into a cookie
		if($.cookie(currentUrlCookieName) == '' || $.cookie(currentUrlCookieName) == null)
			$.cookie(currentUrlCookieName, 'infos/welcome.php');
	}
	
	function cleanCookie()
	{
		$.cookie(currentUrlCookieName, '');
	}
	
	</script>
	
</head>

<body>

<table id='layout' border='0'>
	<tr>
		<td id='header'>
			<img src="<?php echo '../img/'; ?>badra_logo.png" alt="<?php echo $tag_company_name; ?>" height="50px" width="350px">

        </td>
	</tr>
	<tr>
		<td id='option_nav' >
			<b class='cssUsrInfo'>
			<?php if( $access->isPageAllowed(PermissionType::PLACES) ) { ?>
			
			<?php $control->stores_select(); ?>
			
			&#8194;
			
			<?php $control->shops_select(); ?>
			
			&#8194;
			&#8194;
			<?php } ?>
			[Hoy: <?php echo $config->toUsrDateFormat($config->getCurrentDate()); ?>]
			&#8194;
			[Usuario: <?php echo $_SESSION['usr_name']; ?>]</b>
			&#8194;
			<a href='infos/close_session.php' >Cerrar Sesi&oacute;n</a>
		</td>
	</tr>
	<tr>
		<td id='nav'>
			<div id='div_nav'>
				<ul id='bar_menu'>
					<li><a class='menu_nav' href='javascript:void(0)' url='tyres/tyres.php' >LLANTAS</a></li>
					<li><a class='menu_nav' href='javascript:void(0)' url='suppliers/suppliers.php' >IMPORTADORES</a></li>
					<!-- <li><a class='menu_nav' href='javascript:void(0)' url='invoices/invoices.php' >FACTURAS</a></li> -->
					<li><a class='menu_nav' href='javascript:void(0)' url='deptors/deptors.php' >DEUDORES</a></li>
					
					<?php 
					$storeUrl = '';
					if( $up->isPageActionAllowed(PermissionType::STORES, PermissionType::STORE_V) )
						$storeUrl = 'stores/stores.php';
					
					if( isset($_SESSION["idStore"]) || $storeUrl != '' ){ ?>
					<li><a class='menu_nav' href='javascript:void(0)' url='<?php echo $storeUrl; ?>' >DEPOSITOS</a>
					<?php if( isset($_SESSION["idStore"]) ){ ?>
						<ul>
							<li><a class='menu_nav' href='javascript:void(0)' url='stores/store_entries.php' >Entradas</a></li>
							<li><a class='menu_nav' href='javascript:void(0)' url='stores/store_outs.php' >Salidas</a></li>
						</ul>
					<?php } ?>
					</li>
					<?php }
					$shopUrl = '';
					if( $up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_V) )
						$shopUrl = 'shops/shops.php';
					
					if( isset($_SESSION["idShop"]) || $shopUrl != '' ){ ?>
					<li><a class='menu_nav' href='javascript:void(0)' url='<?php echo $shopUrl; ?>' >TIENDAS</a>
					<?php if( isset($_SESSION["idShop"]) ){ ?>
						<ul>
							<li><a class='menu_nav' href='javascript:void(0)' url='shops/shop_entries.php' >Entradas</a></li>
							<li><a class='menu_nav' href='javascript:void(0)' url='shops/shop_eo.php?eo_type=out' >Salidas</a></li>
							<li><a class='menu_nav' href='javascript:void(0)' url='shops/sales.php' >Ventas</a></li>
						</ul>
					<?php } ?>
					</li>
					<?php }
                    if( $access->isPageAllowed(PermissionType::KARDEX) ) {
                        ?>
                        <li><a class='menu_nav' href='javascript:void(0)' url=''>KARDEX</a>
                            <ul>
                                <?php
                                if( $access->isPageActionAllowed(PermissionType::KARDEX, PermissionType::KARDEX_IO) ) {
                                ?>
                                <li><a class='menu_nav' href='javascript:void(0)' url='kardex/io.php'>Entradas y Salidas</a></li>
                                <?php }
                                if( $access->isPageActionAllowed(PermissionType::KARDEX, PermissionType::KARDEX_ENTRIES) ) {
                                ?>
                                <li><a class='menu_nav' href='javascript:void(0)' url='kardex/entries.php'>Entradas</a></li>
                                <?php }
                                if( $access->isPageActionAllowed(PermissionType::KARDEX, PermissionType::KARDEX_OUTS) ) {
                                ?>
                                <li><a class='menu_nav' href='javascript:void(0)' url='kardex/outs.php'>Salidas</a></li>
                                <?php }
                                if( $access->isPageActionAllowed(PermissionType::KARDEX, PermissionType::KARDEX_STOCK) ) {
                                ?>
                                <li><a class='menu_nav' href='javascript:void(0)' url='kardex/stock.php'>Existencias</a></li>
                                <?php }
                                if( $access->isPageActionAllowed(PermissionType::KARDEX, PermissionType::KARDEX_IMPORTS) ) {
                                ?>
                                <li><a class='menu_nav' href='javascript:void(0)' url='kardex/imports.php'>Importadores</a></li>
                                <?php }
                                if( $access->isPageActionAllowed(PermissionType::KARDEX, PermissionType::KARDEX_DEBTS) ) {
                                ?>
                                <li><a class='menu_nav' href='javascript:void(0)' url='kardex/debts.php'>Deudores</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php
                    }

					if( $access->isPageAllowed(PermissionType::ROLES) ) {
					?>
					<li><a class='menu_nav' href='javascript:void(0)' url='' >OPCIONES</a>
						<ul>
							<li><a class='menu_nav' href='javascript:void(0)' url='roles/roles.php' >Permisos</a></li>
							<li><a class='menu_nav' href='javascript:void(0)' url='users/users.php' >Usuarios</a></li>
						<ul>
					</li>
					<?php } ?>					
				</ul>
			</div>
		</td>
	</tr>

	<tr>
		<td id='content'></td>
	</tr>

	<tr>
		<td id='footer'>
			DERECHOS RESERVADOS
			<br>
			BOLIVIA - <?php echo Date('Y');?>
		</td>
	</tr>
</table>


</body>
</html>
