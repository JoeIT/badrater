<?php
abstract class PermissionType
{
	const PERMISSION = 'permission';
	const STORE_V = 'store_v'; // View
	const STORE_A = 'store_a'; // Add and modify
	const STORE_D = 'store_d'; // Delete
	const SHOP_V = 'shop_v';
	const SHOP_A = 'shop_a';
	const SHOP_D = 'shop_d';
	const TYRE_A = 'tyre_a';
	const TYRE_D = 'tyre_d';
	const SUPPLIER_A = 'supplier_a';
	const SUPPLIER_D = 'supplier_d';
	const DEPTOR_A = 'deptor_a';
	const DEPTOR_D = 'deptor_d';
	
	const MOV_V = 'mov_v';
	const MOV_A = 'mov_a';
	const MOV_D = 'mov_d';
	const MOV_O = 'mov_o'; // Outs
	
	// Pages
	const MAIN = 'main';
	const TYRES = 'tyres';
	const SUPPLIERS = 'suppliers';
	const DEPTORS = 'deptors';
	const ROLES = 'roles';
	const STORES = 'stores';
	const STORES_MOVEMENTS = 'stores_movements';
	const SHOPS = 'shops';
	const SHOPS_MOVEMENTS = 'shops_movements';
	const PLACES = 'places';
	const PERMISSIONS = 'permissions';

    const KARDEX = 'kardex';
    const KARDEX_IO = 'kardex_io';
    const KARDEX_ENTRIES = 'kardex_entries';
    const KARDEX_OUTS = 'kardex_outs';
    const KARDEX_STOCK = 'kardex_stock';
    const KARDEX_IMPORTS = 'kardex_imports';
    const KARDEX_INVOICE = 'kardex_invoice';
    const KARDEX_DEBTS = 'kardex_debts';
}
?>