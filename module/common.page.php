<?
//-----------------------------------------------------------------
//		page
//-----------------------------------------------------------------
function page(){
	global $valid;
	//define
	if($valid==true){
		$c = 'admin';
	}else{
		$c = 'user';
	}
	//function string
	$header = $c.'_header';
	$content = $c.'_content';
	$footer = $c.'_footer';
	//execute function
	$header();
	$content();
	$footer();
	confirm_box();
}
//-----------------------------------------------------------------
//		page structure
//-----------------------------------------------------------------
function page_structure($content){
	global $valid;
	if($valid==true){
		switch($_GET['p']){ //page list for admin
			//product_category
			case ('product_category_list'):
				$function_name = $content.'_product_category_list';
				break;
			case ('product_category_add'):
				$function_name = $content.'_product_category_add';
				break;
			case ('product_category_edit'):
				$function_name = $content.'_product_category_edit';
				break;
			case ('product_hierarchy_list'):
				$function_name = $content.'_product_hierarchy_list';
				break;
			//product_class
			case ('product_class_list'):
				$function_name = $content.'_product_class_list';
				break;
			case ('product_class_add'):
				$function_name = $content.'_product_class_add';
				break;
			case ('product_class_edit'):
				$function_name = $content.'_product_class_edit';
				break;
			//product_subclass
			case ('product_subclass_list'):
				$function_name = $content.'_product_subclass_list';
				break;
			case ('product_subclass_add'):
				$function_name = $content.'_product_subclass_add';
				break;
			case ('product_subclass_edit'):
				$function_name = $content.'_product_subclass_edit';
				break;
			//product
			case ('product_list'):
				$function_name = $content.'_product_list';
				break;
			case ('product_add'):
				$function_name = $content.'_product_add';
				break;
			case ('product_edit'):
				$function_name = $content.'_product_edit';
				break;
			case ('product_history_list'):
				$function_name = $content.'_product_history_list';
				break;
			//client
			case ('client_list'):
				$function_name = $content.'_client_list';
				break;
			case ('client_add'):
				$function_name = $content.'_client_add';
				break;
			case ('client_edit'):
				$function_name = $content.'_client_edit';
				break;
			//vendor
			case ('vendor_list'):
				$function_name = $content.'_vendor_list';
				break;
			case ('vendor_add'):
				$function_name = $content.'_vendor_add';
				break;
			case ('vendor_edit'):
				$function_name = $content.'_vendor_edit';
				break;
			case ('vendor_product_add'):
				$function_name = $content.'_vendor_product_add';
				break;
			//order
			case ('order_list'):
				$function_name = $content.'_order_list';
				break;
			case ('order_chart_list'):
				$function_name = $content.'_order_chart_list';
				break;
			case ('order_add'):
				$function_name = $content.'_order_add';
				break;
			case ('order_add_console'):
				$function_name = $content.'_order_add_console';
				break;
			case ('order_edit'):
				$function_name = $content.'_order_edit';
				break;
			//supply
			case ('supply_list'):
				$function_name = $content.'_supply_list';
				break;
			case ('supply_chart_list'):
				$function_name = $content.'_supply_chart_list';
				break;
			case ('supply_add'):
				$function_name = $content.'_supply_add';
				break;
			case ('supply_add_console'):
				$function_name = $content.'_supply_add_console';
				break;
			case ('supply_edit'):
				$function_name = $content.'_supply_edit';
				break;
			case ('order_templete_add'):
				$function_name = $content.'_order_templete_add';
				break;
			//discount
			case ('discount_list'):
				$function_name = $content.'_discount_list';
				break;
			case ('discount_add'):
				$function_name = $content.'_discount_add';
				break;
			case ('discount_edit'):
				$function_name = $content.'_discount_edit';
				break;
			//creditcard
			case ('creditcard_list'):
				$function_name = $content.'_creditcard_list';
				break;
			case ('creditcard_reference_list'):
				$function_name = $content.'_creditcard_reference_list';
				break;
			//tax
			case ('tax_list'):
				$function_name = $content.'_tax_list';
				break;
			case ('tax_edit'):
				$function_name = $content.'_tax_edit';
				break;
			//admin
			case ('admin_list'):
				$function_name = $content.'_admin_list';
				break;
			case ('admin_add'):
				$function_name = $content.'_admin_add';
				break;
			case ('admin_edit'):
				$function_name = $content.'_admin_edit';
				break;
			//reminder_list
			case ('reminder_list'):
				$function_name = $content.'_reminder_list';
				break;
			//trans_supply_additional_price_list
			case ('trans_supply_additional_price_list'):
				$function_name = $content.'_trans_supply_additional_price_list';
				break;
			//logout
			case ('logout'):
				$function_name = $content.'_logout';
				break;
			case ('login_list'):
				$function_name = $content.'_login_list';
				break;
			default:
				$function_name = $content.'_home';
				break;
		}
	}else{
		$function_name = $content.'_login';
	}
	$out = $function_name();
	return $out;
}
?>
