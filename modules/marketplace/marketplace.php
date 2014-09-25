<?php
if (!defined('_PS_VERSION_'))
    exit;
//include_once 'classes/SellerProductDetail.php';
include_once 'classes/MarketplaceClassInclude.php';
class MarketPlace extends Module
{
	const INSTALL_SQL_FILE = 'install.sql';
    private $_postErrors = array();
    public function __construct()
    {
        $this->name          = 'marketplace';
        $this->tab           = 'front_office_features';
        $this->version       = 0.1;
        $this->author        = 'webkul';
        $this->need_instance = 0;
        $config              = Configuration::getMultiple(array(
            'FONT-FAMILY1',
            'FONT-FAMILY2',
            'RECENT-SIZE',
            'RECENT-COLOR',
            'COLOR',
            'COLOR1',
            'COLOR5',
            'PRO_COLOR',
            'COLOR6',
            'ROW-FONT-SIZE',
            'PRO-HEAD-FONT-SIZR',
            'HEADING_COLOR',
            'EVEN_ROW_COLOR',
            'ODD_ROW_COLOR',
            'FONT-SIZE1',
            'FONT-SIZE',
            'MAIN-HEADING-SIZE',
            'MAIN-HEADING-COLOR',
            'MAIN-HEADING-FAMILY',
            'ADD-SIZE',
            'ADD-FONT-FAMILY',
            'ADD-COLOR',
            'ADD-BORDER-COLOR',
            'COL-SIZE',
            'COL-FONT-FAMILY',
            'COL-COLOR',
            'PROF-SIZE',
            'PROF-FONT-FAMILY',
            'PROF-COLOR',
            'CONT-SIZE',
            'CONT-FONT-FAMILY',
            'CONT-COLOR',
            'CONT-BORDER-COLOR',
            'CONT-HEAD-SIZE',
            'CONT-HEAD-FONT-FAMILY',
            'CONT-HEAD-COLOR',
            'CONT-HEADING-SIZE',
            'CONT-HEADING-FONT-FAMILY',
            'CONT-HEADING-COLOR',
            'CONT-HEAD-INFO-SIZE',
            'CONT-HEAD-INFO-FONT-FAMILY',
            'CONT-HEAD-INFO-COLOR',
            'SHOP-SIZE',
            'SHOP-FONT-FAMILY',
            'SHOP-COLOR',
            'SHOP-HEADING-SIZE',
            'SHOP-HEADING-FONT-FAMILY',
            'SHOP-HEADING-COLOR',
            'EDIT-SIZE',
            'EDIT-FONT-FAMILY',
            'EDIT-COLOR',
            'EDIT-BACK-COLOR',
            'EDIT-BORDER-COLOR',
            'PROPAGE-HEAD-SIZE',
            'PROPAGE-HEAD-COLOR',
            'PROPAGE-HEAD-FONT-FAMILY',
            'PROPAGE-FONT-FAMILY',
            'PROPAGE-SIZE',
            'PROPAGE-COLOR',
            'PROPAGE-BACK-COLOR',
            'PROPAGE-BORDER-COLOR',
            'SHOP-HEAD-SIZE',
            'SHOP-HEAD-COLOR',
            'SHOP-HEAD-FONT-FAMILY',
            'REQ-HEADING-SIZE',
            'REQ-HEADING-COLOR',
            'REQ-HEADING-FONT-FAMILY',
            'REQ-TEXT-SIZE',
            'REQ-TEXT-COLOR',
            'REQ-TEXT-FONT-FAMILY',
            'REQ-BORDER-COLOR',
            'ORDER-HEADING-SIZE',
            'ORDER-HEADING-FAMILY',
            'ORDER-ROW-SIZE',
            'ORDER-ROW-FAMILY',
            'EDITPRO-FONT-FAMILY',
            'EDITPRO-SIZE',
            'EDITPRO-COLOR',
            'PRODUCT_APPROVE',
            'SELLER_APPROVE'
        ));
		
        parent::__construct();
        $this->displayName     = $this->l('Market place');
        $this->description     = $this->l('Adds customer as a seller');
        
		$this->extra_mail_vars = array(
            '{font-family}' => nl2br(Configuration::get('FONT-FAMILY')),
            '{font-family1}' => nl2br(Configuration::get('FONT-FAMILY1')),
            '{font-family2}' => nl2br(Configuration::get('FONT-FAMILY2')),
            '{dash-head-font-family}' => nl2br(Configuration::get('DASH-HEAD-FONT-FAMILY')),
            '{color}' => nl2br(Configuration::get('COLOR')),
            '{color1}' => nl2br(Configuration::get('COLOR1')),
            '{color5}' => nl2br(Configuration::get('COLOR5')),
            '{color6}' => nl2br(Configuration::get('COLOR6')),
            '{heading_color}' => nl2br(Configuration::get('HEADING_COLOR')),
            '{recent-color}' => nl2br(Configuration::get('RECENT-COLOR')),
            '{recent-size}' => nl2br(Configuration::get('RECENT-SIZE')),
            '{even_row_color}' => nl2br(Configuration::get('EVEN_ROW_COLOR')),
            '{odd_row_color}' => nl2br(Configuration::get('ODD_ROW_COLOR')),
            '{font-size1}' => nl2br(Configuration::get('FONT-SIZE1')),
            '{main-heading-size}' => nl2br(Configuration::get('MAIN_HEADING-SIZE')),
            '{main-heading-color}' => nl2br(Configuration::get('MAIN_HEADING-COLOR')),
            '{font-size}' => nl2br(Configuration::get('FONT-SIZE')),
            '{main-heading-family}' => nl2br(Configuration::get('MAIN-HEADING-FAMILY')),
            '{pro_color}' => nl2br(Configuration::get('PRO_COLOR')),
            '{color6}' => nl2br(Configuration::get('COLOR6')),
            '{color5}' => nl2br(Configuration::get('COLOR5')),
            '{row-font-size}' => nl2br(Configuration::get('ROW-FONT-SIZE')),
            '{pro-head-font-size}' => nl2br(Configuration::get('PRO-HEAD-FONT-SIZE')),
            '{row-font-family}' => nl2br(Configuration::get('ROW-FONT-FAMILY')),
            '{pro-head-font-family}' => nl2br(Configuration::get('PRO-HEAD-FONT-FAMILY')),
            '{add-size}' => nl2br(Configuration::get('ADD-SIZE')),
            '{add-font-family}' => nl2br(Configuration::get('ADD-FONT-FAMILY')),
            '{add-color}' => nl2br(Configuration::get('ADD-COLOR')),
            '{add-border-color}' => nl2br(Configuration::get('ADD-BORDER-COLOR')),
            '{col-size}' => nl2br(Configuration::get('COL-SIZE')),
            '{col-font-family}' => nl2br(Configuration::get('COL-FONT-FAMILY')),
            '{col-color}' => nl2br(Configuration::get('COL-COLOR')),
            '{prof-size}' => nl2br(Configuration::get('PROF-SIZE')),
            '{prof-font-family}' => nl2br(Configuration::get('PROF-FONT-FAMILY')),
            '{prof-color}' => nl2br(Configuration::get('PROF-COLOR')),
            '{cont-size}' => nl2br(Configuration::get('CONT-SIZE')),
            '{cont-font-family}' => nl2br(Configuration::get('CONT-FONT-FAMILY')),
            '{cont-color}' => nl2br(Configuration::get('CONT-COLOR')),
            '{cont-border-color}' => nl2br(Configuration::get('CONT-BORDER-COLOR')),
            '{cont-head-size}' => nl2br(Configuration::get('CONT-HEAD-SIZE')),
            '{cont-head-font-family}' => nl2br(Configuration::get('CONT-HEAD-FONT-FAMILY')),
            '{cont-head-color}' => nl2br(Configuration::get('CONT-HEAD-COLOR')),
            '{cont-heading-size}' => nl2br(Configuration::get('CONT-HEADING-SIZE')),
            '{cont-heading-font-family}' => nl2br(Configuration::get('CONT-HEADING-FONT-FAMILY')),
            '{cont-heading-color}' => nl2br(Configuration::get('CONT-HEADING-COLOR')),
            '{cont-head-info-size}' => nl2br(Configuration::get('CONT-HEAD-INFO-SIZE')),
            '{cont-head-info-font-family}' => nl2br(Configuration::get('CONT-HEAD-INFO-FONT-FAMILY')),
            '{cont-head-info-color}' => nl2br(Configuration::get('CONT-HEAD-INFO-COLOR')),
            '{shop-size}' => nl2br(Configuration::get('SHOP-SIZE')),
            '{shop-font-family}' => nl2br(Configuration::get('SHOP-FONT-FAMILY')),
            '{shop-color}' => nl2br(Configuration::get('SHOP-COLOR')),
            '{shop-heading-size}' => nl2br(Configuration::get('SHOP-HEADING-SIZE')),
            '{shop-heading-font-family}' => nl2br(Configuration::get('SHOP-HEADING-FONT-FAMILY')),
            '{shop-heading-color}' => nl2br(Configuration::get('SHOP-HEADING-COLOR')),
            '{edit-size}' => nl2br(Configuration::get('EDIT-SIZE')),
            '{edit-font-family}' => nl2br(Configuration::get('EDIT-FONT-FAMILY')),
            '{edit-color}' => nl2br(Configuration::get('EDIT-COLOR')),
            '{edit-back-color}' => nl2br(Configuration::get('EDIT-BACK-COLOR')),
            '{edit-border-color}' => nl2br(Configuration::get('EDIT-BORDER-COLOR')),
            '{propage-border-color}' => nl2br(Configuration::get('PROPAGE-BORDER-COLOR')),
            '{propage-back-color}' => nl2br(Configuration::get('PROPAGE-BACK-COLOR')),
            '{propage-head-color}' => nl2br(Configuration::get('PROPAGE-HEAD-COLOR')),
            '{propage-head-size}' => nl2br(Configuration::get('PROPAGE-HEAD-SIZE')),
            '{propage-head-font-family}' => nl2br(Configuration::get('PROPAGE-HEAD-FONT-FAMILY')),
            '{propage-color}' => nl2br(Configuration::get('PROPAGE-COLOR')),
            '{propage-size}' => nl2br(Configuration::get('PROPAGE-SIZE')),
            '{propage-font-family}' => nl2br(Configuration::get('PROPAGE-FONT-FAMILY')),
            '{shop-head-color}' => nl2br(Configuration::get('SHOP-HEAD-COLOR')),
            '{shop-head-size}' => nl2br(Configuration::get('SHOP-HEAD-SIZE')),
            '{shop-head-font-family}' => nl2br(Configuration::get('SHOP-HEAD-FONT-FAMILY')),
            '{req-border-color}' => nl2br(Configuration::get('REQ-BORDER-COLOR')),
            '{req-heading-color}' => nl2br(Configuration::get('REQ-HEADING-COLOR')),
            '{req-heading-size}' => nl2br(Configuration::get('REQ-HEADING-SIZE')),
            '{req-heading-font-family}' => nl2br(Configuration::get('REQ-HEADING-FONT-FAMILY')),
            '{req-text-color}' => nl2br(Configuration::get('REQ-TEXT-COLOR')),
            '{req-text-size}' => nl2br(Configuration::get('REQ-TEXT-SIZE')),
            '{req-text-font-family}' => nl2br(Configuration::get('REQ-TEXT-FONT-FAMILY')),
            '{order-heading-family}' => nl2br(Configuration::get('ORDER-HEADING-FAMILY')),
            '{order-heading-size}' => nl2br(Configuration::get('ORDER-HEADING-SIZE')),
            '{order-row-family}' => nl2br(Configuration::get('ORDER-ROW-FAMILY')),
            '{order-row-size}' => nl2br(Configuration::get('ORDER-ROW-SIZE')),
            '{editpro-size}' => nl2br(Configuration::get('EDITPRO-SIZE')),
            '{editpro-color}' => nl2br(Configuration::get('EDITPRO-COLOR')),
            '{editpro-font-family}' => nl2br(Configuration::get('EDITPRO-FONT-FAMILY')),
        );
    }
    private function _displayForm()
    {
        $this->_html .= '<!doctype html>

		<form action="' . Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']) . '" method="post">

			<fieldset>

			<legend><img src="../img/admin/contact.gif" />' . $this->l('My Account CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading Text Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="color1" value="#000000" />

						</td>

					</tr>

								

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Text FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="8" max="30" name="font-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Text FontFamily') . '</td>

					<td><input list="font-family" name="font-family1">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					<tr>



				</table>

			</fieldset>

				<br />

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('DashBoard Link CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

				

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('DashBoard Link Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="color" value="#6C702F" />

						</td>

					</tr>

					

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('DashBoard Link FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="18" name="font-size1"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Text FontFamily') . '</td>

					<td><input list="font-family" name="font-family2">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					<tr>

					

					</table>

				</fieldset>

					<br />

				

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Order CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

				

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Main Heading Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="main-heading-color" value="#D9E5EE" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Main Heading FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="28" name="main-heading-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Main Heading FontFamily') . '</td>

					<td><input list="font-family" name="main-heading-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					<tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading BackGround Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="heading_color" value="#D9E5EE" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="8" max="17" name="order-heading-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Heading FontFamily') . '</td>

					<td><input list="font-family" name="order-heading-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					<tr>

					

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Even Row BackGround Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="even_row_color" value="#EEEDED" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Odd Row BackGround Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="odd_row_color" value="#F8F7F5" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Row FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="8" max="17" name="order-row-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Row FontFamily') . '</td>

					<td><input list="font-family" name="order-row-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</tr>

					

					</table>

				</fieldset>

					<br />

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Product List CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

				

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading BackGround Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="pro_color" value="#766666" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Table Row(odd) Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="color6" value="#ECF7FB" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Table Row(even) Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="color5" value="#F5F8FF" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Row Text FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="10" max="20" name="row-font-size"  />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="10" max="24" name="pro-head-font-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Row Text FontFamily') . '</td>

					<td><input list="font-family" name="row-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					<tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Heading FontFamily') . '</td>

					<td><input list="font-family" name="pro-head-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					</table>

				</fieldset>

				

							<br />		

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Recent Heading CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('RECENT Heading Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="recent-color" value="#E65505" />

						</td>

					</tr>

					

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('DashBoard Link FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="8" max="25" name="recent-size"  />

						</td>

					</tr>

					</table>

				</fieldset>

				

					<br />

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Add Product CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Border Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="add-border-color" value="#000000" />

						</td>

					</tr>

				

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Add Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="add-color" value="#5872AE" />

						</td>

					</tr>

					

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Add FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="10" max="18" name="add-size"  />

						</td>

					</tr>

					

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Add FontFamily') . '</td>

					<td><input list="font-family" name="add-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

					</table>

				</fieldset>

					<br />

				

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Collection Header CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="col-color" value="#737739" />

						</td>

					</tr>

					

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="50" name="col-size"  />

						</td>

					</tr>

					

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Header FontFamily') . '</td>

					<td><input list="font-family" name="col-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

					</table>

				</fieldset>

				

					<br />

					<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Shop Bigger Header CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="shop-head-color" value="#737739" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="50" name="shop-head-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Header FontFamily') . '</td>

					<td><input list="font-family" name="shop-head-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					</table>

				</fieldset>

					<br />

				

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Seller Profile Header CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="prof-color" value="#737739" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="50" name="prof-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Header FontFamily') . '</td>

					<td><input list="font-family" name="prof-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					</table>

				</fieldset>

					<br />

				

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Contact Header CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

				

				<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Border Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="cont-border-color" value="#000000" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="cont-color" value="#737739" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="50" name="cont-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Header FontFamily') . '</td>

					<td><input list="font-family" name="cont-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

						<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="cont-heading-color" value="#737739" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="50" name="cont-heading-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Heading FontFamily') . '</td>

					<td><input list="font-family" name="cont-heading-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

						

						<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Main Header Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="cont-head-color" value="#000000" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Main Header FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="22" name="cont-head-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Main Header FontFamily') . '</td>

					<td><input list="font-family" name="cont-head-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

						<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Main Header Info Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="cont-head-info-color" value="#000000" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Main Header Info FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="10" max="22" name="cont-head-info-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Main Header Info FontFamily') . '</td>

					<td><input list="font-family" name="cont-head-info-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

						

					</table>

				</fieldset>

				

					<br />

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Shop Header CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="shop-color" value="#737739" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Header FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="50" name="shop-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Header FontFamily') . '</td>

					<td><input list="font-family" name="shop-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

						

						<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="shop-heading-color" value="#737739" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="35" name="shop-heading-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Heading FontFamily') . '</td>

					<td><input list="font-family" name="shop-heading-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					</table>

				</fieldset>

				

					<br />

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Seller Request CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

				

				<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Border Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="req-border-color" value="#000000" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="req-heading-color" value="#000000" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Heading FontSize') . '</td>

						<td style="padding-bottom:15px;">


							<input type="number" min="12" max="50" name="req-heading-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Heading FontFamily') . '</td>

					<td><input list="font-family" name="req-heading-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

						

						<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Text Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="req-text-color" value="#666666" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Text FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="10" max="20" name="req-text-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Text FontFamily') . '</td>

					<td><input list="font-family" name="req-text-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

					</table>

				</fieldset>

				

					<br />

				

				<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Profile Page CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Title Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="propage-head-color" value="#666666" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Title FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="26" name="propage-head-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Title FontFamily') . '</td>

					<td><input list="font-family" name="propage-head-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

						

						<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Text Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="propage-color" value="#666666" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Text FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="12" max="26" name="propage-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Text FontFamily') . '</td>

					<td><input list="font-family" name="propage-font-family">

						<datalist id="font-family">

						  <option value="Helvetica, sans-serif">

						  <option value="Times, serif">

						  <option value="Courier New, monospace">

						  <option value="Comic Sans, Comic Sans MS, cursive	">

						  <option value="Impact, fantasy">

						</datalist></td></tr>

						

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('BackGround Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="propage-back-color" value="#ffffff" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Border Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="propage-border-color" value="#000000" />

						</td>

					</tr>

					</table>

				</fieldset>

				

					<br />

				

					<fieldset>

				<legend><img src="../img/admin/contact.gif" />' . $this->l('Edit Product Page CSS') . '</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

						<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Text Color') . '</td>

						<td style="padding-bottom:15px;">

						<input type="color" name="editpro-color" value="#666666" />

						</td>

					</tr>

					

					<tr>

						<td width="250" style="vertical-align: top;">' . $this->l('Text FontSize') . '</td>

						<td style="padding-bottom:15px;">

							<input type="number" min="8" max="19" name="editpro-size"  />

						</td>

					</tr>

					

					<tr><td width="250" style="height: 35px;">' . $this->l('Text FontFamily') . '</td>

					<td><input list="font-family" name="editpro-font-family">

						<datalist id="font-family">

						  <option value="Helvetica,sans-serif">

						  <option value="Times,serif">

						  <option value="Courier New,monospace">

						  <option value="Comic Sans,Comic Sans MS,cursive">

						  <option value="Impact,fantasy">

						</datalist></td></tr>

					

				<tr><td colspan="2" align="center"><input class="button" name="btnSubmit" value="' . $this->l('Update settings') . '" type="submit" /></td></tr>

					

					</table>

				</fieldset>

				

				

		</form>
        <div class="form" style="margin-top:30px;">
       <form action="' . Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']) . '" method="post">
            <fieldset><legend><img src="'.$this->_path.'setting.gif" alt="" title="" />'.$this->l('Settings').'</legend>
                <label style="width:260px;">'.$this->l('Product Need To Be Approved By Admin').'</label>
                <div class="margin-form">
                    <input type="radio" name="admin_product_approve" id="admin_approve_on" value="admin"
                        '.((Tools::getValue('admin_approve', Configuration::getGlobalValue('PRODUCT_APPROVE')) == 'admin') ? 'checked="checked" ' : '').'/>
                </div>
                    
                <label style="width:260px;">'.$this->l('By Default Approved').'</label>
                <div class="margin-form">
                    <input type="radio" name="admin_product_approve"  id="default_approve_on" value="default" '.((Tools::getValue('admin_approve', Configuration::getGlobalValue('PRODUCT_APPROVE')) == 'default') ? 'checked="checked" ' : '').'/>
                </div>
                 <label style="width:260px;">'.$this->l('Seller Need To Be Approved By Admin').'</label>
                <div class="margin-form">
                    <input type="radio" name="admin_seller_approve" id="admin_approve_on" value="admin"
                        '.((Tools::getValue('admin_approve', Configuration::getGlobalValue('SELLER_APPROVE')) == 'admin') ? 'checked="checked" ' : '').'/>
                </div>
                    
                <label style="width:260px;">'.$this->l('By Default Approved').'</label>
                <div class="margin-form">
                    <input type="radio" name="admin_seller_approve"  id="default_approve_on" value="default" '.((Tools::getValue('admin_approve', Configuration::getGlobalValue('SELLER_APPROVE')) == 'default') ? 'checked="checked" ' : '').'/>
                </div>
                <input type="submit" name="submitApproveInfo" value="'.$this->l('Save').'" class="button" />
                </fieldset>
        </form>
     </div>

		</html>';
    }
    public function getContent()
    {
        $this->_html = '<h2>' . $this->displayName . '</h2>';
        $this->_postProcess();
        $this->_displayForm();
        if (Tools::isSubmit('submitApproveInfo'))
            {
                $approve_prod_val = Tools::getValue('admin_product_approve');
                Configuration::updateValue('PRODUCT_APPROVE', $approve_prod_val);
                $approve_seller_val = Tools::getValue('admin_seller_approve');
                Configuration::updateValue('SELLER_APPROVE', $approve_seller_val);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        return $this->_html;
    }
    private function _postProcess()
    {
         if (Tools::isSubmit('btnSubmit')) {
            Configuration::updateValue('font-family1', Tools::getValue('font-family1'));
            Configuration::updateValue('font-family2', Tools::getValue('font-family2'));
            Configuration::updateValue('color', Tools::getValue('color'));
            Configuration::updateValue('color1', Tools::getValue('color1'));
            Configuration::updateValue('color5', Tools::getValue('color5'));
            Configuration::updateValue('color6', Tools::getValue('color6'));
            Configuration::updateValue('font-size1', Tools::getValue('font-size1'));
            Configuration::updateValue('font-size', Tools::getValue('font-size'));
            Configuration::updateValue('heading_color', Tools::getValue('heading_color'));
            Configuration::updateValue('even_row_color', Tools::getValue('even_row_color'));
            Configuration::updateValue('odd_row_color', Tools::getValue('odd_row_color'));
            Configuration::updateValue('recent-size', Tools::getValue('recent-size'));
            Configuration::updateValue('recent-color', Tools::getValue('recent-color'));
            Configuration::updateValue('main-heading-size', Tools::getValue('main-heading-size'));
            Configuration::updateValue('main-heading-color', Tools::getValue('main-heading-color'));
            Configuration::updateValue('main-heading-family', Tools::getValue('main-heading-family'));
            Configuration::updateValue('order-heading-family', Tools::getValue('order-heading-family'));
            Configuration::updateValue('order-heading-size', Tools::getValue('order-heading-size'));
            Configuration::updateValue('order-row-family', Tools::getValue('order-row-family'));
            Configuration::updateValue('order-row-size', Tools::getValue('order-row-size'));
            Configuration::updateValue('pro_color', Tools::getValue('pro_color'));
            Configuration::updateValue('color6', Tools::getValue('color6'));
            Configuration::updateValue('color5', Tools::getValue('color5'));
            Configuration::updateValue('row-font-size', Tools::getValue('row-font-size'));
            Configuration::updateValue('pro-head-font-size', Tools::getValue('pro-head-font-size'));
            Configuration::updateValue('row-font-family', Tools::getValue('row-font-family'));
            Configuration::updateValue('pro-head-font-family', Tools::getValue('pro-head-font-family'));
            Configuration::updateValue('add-size', Tools::getValue('add-size'));
            Configuration::updateValue('add-font-family', Tools::getValue('add-font-family'));
            Configuration::updateValue('add-color', Tools::getValue('add-color'));
            Configuration::updateValue('add-border-color', Tools::getValue('add-border-color'));
            Configuration::updateValue('col-size', Tools::getValue('col-size'));
            Configuration::updateValue('col-font-family', Tools::getValue('col-font-family'));
            Configuration::updateValue('col-color', Tools::getValue('col-color'));
            Configuration::updateValue('prof-size', Tools::getValue('prof-size'));
            Configuration::updateValue('prof-font-family', Tools::getValue('prof-font-family'));
            Configuration::updateValue('prof-color', Tools::getValue('prof-color'));
            Configuration::updateValue('cont-size', Tools::getValue('cont-size'));
            Configuration::updateValue('cont-font-family', Tools::getValue('cont-font-family'));
            Configuration::updateValue('cont-color', Tools::getValue('cont-color'));
            Configuration::updateValue('cont-border-color', Tools::getValue('cont-border-color'));
            Configuration::updateValue('cont-head-size', Tools::getValue('cont-head-size'));
            Configuration::updateValue('cont-head-font-family', Tools::getValue('cont-head-font-family'));
            Configuration::updateValue('cont-head-color', Tools::getValue('cont-head-color'));
            Configuration::updateValue('cont-heading-size', Tools::getValue('cont-heading-size'));
            Configuration::updateValue('cont-heading-font-family', Tools::getValue('cont-heading-font-family'));
            Configuration::updateValue('cont-heading-color', Tools::getValue('cont-heading-color'));
            Configuration::updateValue('cont-head-info-size', Tools::getValue('cont-head-info-size'));
            Configuration::updateValue('cont-head-info-font-family', Tools::getValue('cont-head-info-font-family'));
            Configuration::updateValue('cont-head-info-color', Tools::getValue('cont-head-info-color'));
            Configuration::updateValue('shop-size', Tools::getValue('shop-size'));
            Configuration::updateValue('shop-font-family', Tools::getValue('shop-font-family'));
            Configuration::updateValue('shop-color', Tools::getValue('shop-color'));
            Configuration::updateValue('shop-heading-size', Tools::getValue('shop-heading-size'));
            Configuration::updateValue('shop-heading-font-family', Tools::getValue('shop-heading-font-family'));
            Configuration::updateValue('shop-heading-color', Tools::getValue('shop-heading-color'));
            Configuration::updateValue('edit-size', Tools::getValue('edit-size'));
            Configuration::updateValue('edit-font-family', Tools::getValue('edit-font-family'));
            Configuration::updateValue('edit-color', Tools::getValue('edit-color'));
            Configuration::updateValue('edit-back-color', Tools::getValue('edit-back-color'));
            Configuration::updateValue('edit-border-color', Tools::getValue('edit-border-color'));
            Configuration::updateValue('propage-back-color', Tools::getValue('propage-back-color'));
            Configuration::updateValue('propage-border-color', Tools::getValue('propage-border-color'));
            Configuration::updateValue('propage-color', Tools::getValue('propage-color'));
            Configuration::updateValue('propage-size', Tools::getValue('propage-size'));
            Configuration::updateValue('propage-font-family', Tools::getValue('propage-font-family'));
            Configuration::updateValue('propage-head-color', Tools::getValue('propage-head-color'));
            Configuration::updateValue('propage-head-size', Tools::getValue('propage-head-size'));
            Configuration::updateValue('propage-head-font-family', Tools::getValue('propage-head-font-family'));
            Configuration::updateValue('shop-head-font-family', Tools::getValue('shop-head-font-family'));
            Configuration::updateValue('shop-head-color', Tools::getValue('shop-head-color'));
            Configuration::updateValue('shop-head-size', Tools::getValue('shop-head-size'));
            Configuration::updateValue('req-border-color', Tools::getValue('req-border-color'));
            Configuration::updateValue('req-heading-font-family', Tools::getValue('req-heading-font-family'));
            Configuration::updateValue('req-heading-color', Tools::getValue('req-heading-color'));
            Configuration::updateValue('req-heading-size', Tools::getValue('req-heading-size'));
            Configuration::updateValue('req-text-font-family', Tools::getValue('req-text-font-family'));
            Configuration::updateValue('req-text-color', Tools::getValue('req-text-color'));
            Configuration::updateValue('req-text-size', Tools::getValue('req-text-size'));
            Configuration::updateValue('editpro-font-family', Tools::getValue('editpro-font-family'));
            Configuration::updateValue('editpro-color', Tools::getValue('editpro-color'));
            Configuration::updateValue('editpro-size', Tools::getValue('editpro-size'));
        }
        $this->_html .= '<div class="conf confirm"> ' . $this->l('Settings updated') . '</div>';
    }
	
	public function add_profile()
    {
		$profile = new Profile();
		$profile->name = array();
		foreach (Language::getLanguages(true) as $lang)
			$profile->name[$lang['id_lang']] = 'marketplaceseller';
		$profile->name = $profile->name;
		$isprofileadd = $profile->add();
		if($isprofileadd) {
			$id = $this->setGlobalvariableForProfile('marketplaceseller');
			Configuration::updateValue('market_place_seller_profile_id', $id);
			return true;
		} else {
			return false;
		}
    }
	
	public function setGlobalvariableForProfile($name) {
		$id_lang = Configuration::get('PS_LANG_DEFAULT');
		$id_profile_detail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `id_profile` from "._DB_PREFIX_."profile_lang where `id_lang`=".$id_lang." and `name`='".$name."'"); 
		return $id_profile_detail['id_profile'];
	}
	
	
	//hook detail
	
	public function hookDisplayMenuhook($params) {
		//return true;
		 //
	}
	
	public function hookDisplayMpmenuhook($params) {
		return $this->display(__FILE__, 'mpmenu.tpl');
	}
	
	public function hookDisplayMpmyaccountmenuhook($params) {
		global $smarty;
        $link            = new link();
        $customer_id     = $this->context->customer->id;
		
		$obj_marketplace_seller = new SellerInfoDetail();
		$already_request = $obj_marketplace_seller->getMarketPlaceSellerIdByCustomerId($customer_id);
		
        if ($already_request) {
            $is_seller = $already_request['is_seller'];
            $smarty->assign("is_seller", $is_seller);
            if ($is_seller == 1) {
				$obj_marketplace_shop = new MarketplaceShop();
				$market_place_shop = $obj_marketplace_shop->getMarketPlaceShopInfoByCustomerId($customer_id);
			    $id_shop   = $market_place_shop['id'];
				$obj_ps_shop = new MarketplaceShop($id_shop);
				$name_shop = $obj_ps_shop->link_rewrite;
				$param = array('shop'=>$id_shop);			
				$payment_detail    = $link->getModuleLink('marketplace', 'customerPaymentDetail',$param);
				$link_store        = $link->getModuleLink('marketplace', 'shopstore',array('shop'=>$id_shop,'shop_name'=>$name_shop));
				$link_collection   = $link->getModuleLink('marketplace', 'shopcollection',array('shop'=>$id_shop,'shop_name'=>$name_shop));
				$link_profile      = $link->getModuleLink('marketplace', 'shopprofile',$param);
				$add_product       = $link->getModuleLink('marketplace', 'addproduct');
				$account_dashboard = $link->getModuleLink('marketplace', 'marketplaceaccount',$param);
				$seller_profile    = $link->getModuleLink('marketplace', 'sellerprofile',$param);
				$edit_profile    = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>2,'edit-profile'=>1));
				$product_list    = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>3));
				$my_order    = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>4));
				$payment_details    = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'id_cus'=>$customer_id,'l'=>5));
						
				$smarty->assign("id_shop", $id_shop);
				$smarty->assign("id_customer", $customer_id);
				$smarty->assign("payment_detail", $payment_detail);
				$smarty->assign("link_store", $link_store);
				$smarty->assign("link_collection", $link_collection);
				$smarty->assign("link_profile", $link_profile);
				$smarty->assign("add_product", $add_product);
				$smarty->assign("account_dashboard", $account_dashboard);
				$smarty->assign("seller_profile", $seller_profile);
				$smarty->assign("edit_profile", $edit_profile);
				$smarty->assign("product_list", $product_list);
				$smarty->assign("my_order", $my_order);
				$smarty->assign("payment_details", $payment_details);
            }
        } else {
            $smarty->assign("is_seller", -1);
            $new_link1 = $link->getModuleLink('marketplace', 'sellerrequest');
			$smarty->assign("new_link1", $new_link1);
        }
        $font_size1   = Configuration::get('font-size');
        $font_family1 = Configuration::get('font-family1');
        $color1       = Configuration::get('color1');
      
        $smarty->assign("font_size1", $font_size1);
        $smarty->assign("font_family1", $font_family1);
        $smarty->assign("color1", $color1);
        return $this->display(__FILE__, 'mpmyaccountmenu.tpl');
	}
	
	public function hookDisplayMpOrderheaderlefthook($params) {
		return $this->display(__FILE__, 'orderheaderleft.tpl');
	}
	
	public function hookDisplayMpOrderheaderrighthook($params) {
		//return true;
		return $this->display(__FILE__, 'orderheaderright.tpl');
	}
	
	public function hookDisplayMpbottomordercustomerhook($params) {
		return $this->display(__FILE__, 'bottomordercustomer.tpl');
	}
	public function hookDisplayMpbottomorderstatushook($params) {
		return $this->display(__FILE__, 'bottomorderstatus.tpl');
	}
	public function hookDisplayMpbottomorderproductdetailhook($params) {
		return $this->display(__FILE__, 'bottomorderproductdetail.tpl');
	}
	
	public function hookDisplayMpordershippinghook($params) {
		return $this->display(__FILE__, 'ordershipping.tpl');
	}
	public function hookDisplayMpordershippinglefthook($params) {
		return $this->display(__FILE__, 'ordershippingleft.tpl');
	}
	public function hookDisplayMpordershippingrighthook($params) {
		return $this->display(__FILE__, 'ordershippingright.tpl');
	}
	
	public function hookDisplayMpdashboardtophook($params) {
		return $this->display(__FILE__, 'dashboardtop.tpl');
	}
	
	public function hookDisplayMpdashboardbottomhook($params) {
		return $this->display(__FILE__, 'dashboardbottom.tpl');
	}
	
	public function hookDisplayMpsplefthook($params) {
		return $this->display(__FILE__, 'sellerprofilelefthook.tpl');
	}
	
	public function hookDisplayMpspcontentbottomhook($params) {
		return $this->display(__FILE__, 'sellerprofilecontentbottom.tpl');
	}
	public function hookDisplayMpsprighthook($params) {
		return $this->display(__FILE__, 'sellerprofilerighthook.tpl');
	}
	
	public function hookDisplayMpshoplefthook($params) {
		return $this->display(__FILE__, 'shoplefthook.tpl');
	}
	
	public function hookDisplayMpshopcontentbottomhook($params) {
		return $this->display(__FILE__, 'shopcontentbottom.tpl');
	}
	public function hookDisplayMpshoprighthook($params) {
		return $this->display(__FILE__, 'shoprighthook.tpl');
	}
	
	public function hookDisplayMpcollectionlefthook($params) {
		return $this->display(__FILE__, 'collectionlefthook.tpl');
	}
	
	public function hookDisplayMpcollectionfooterhook($params) {
		return $this->display(__FILE__, 'collectionfooterhook.tpl');
	}
	
	public function hookDisplayMpaddproductfooterhook($params) {
		return $this->display(__FILE__, 'addcustomefieldtoproduct.tpl');
	}
	
	public function hookDisplayMpupdateproductfooterhook($params) {
		return $this->display(__FILE__, 'updatecustomefieldtoproduct.tpl');
	}
	public function hookDisplayMpshoprequestfooterhook($params) {
		return $this->display(__FILE__, 'customefieldtoshoprequest.tpl');
	}
	
	public function hookDisplayMpshopaddfooterhook($params) {
		return $this->display(__FILE__, 'customefieldtoshopedit.tpl');
	}
	
	//product description hook
	public function hookDisplayMpproductdescriptionheaderhook($params) {
		return $this->display(__FILE__, 'productdetailheaderhook.tpl');
	}
	public function hookDisplayMpproductdescriptionfooterhook($params) {
		return $this->display(__FILE__, 'productdetailfooterhook.tpl');
	}
	
	public function hookDisplayMpproductdescriptioncontenthook($params) {
		//return true;
	}
	//product detail tab
	public function hookDisplayMpproductdetailheaderhook($params) {
		return $this->display(__FILE__, 'productdetailheader.tpl');
	}
	
	public function hookDisplayMpproductdetailfooterhook($params) {
		return $this->display(__FILE__, 'productdetailfooterhook.tpl');
	}
	
	//payment detail tab
	public function hookDisplayMppaymentdetailfooterhook($params) {
		return $this->display(__FILE__, 'paymentdetailfooterhook.tpl');
	}
	
	//seller detail tab
	public function hookDisplayMpsellerinfobottomhook($params) {
		//return true;
	}
	
	public function hookDisplayMpsellerleftbottomhook($params) {
		//return true;
	}
	
	public function hookActionAddproductExtrafield($params) {
		//return true;
	}
	public function hookActionUpdateproductExtrafield($params) {
		//return true;
	}
	public function hookActionAddshopExtrafield($params) {
		//return true;
	}
	public function hookActionUpdateshopExtrafield($params) {
		//return true;
	}
    public function hookDisplayOrderConfirmation($params)
    {
		
       	$id_order         = Tools::getValue('id_order');
        $is_allready_calc = Db::getInstance()->executeS("SELECT *  from `" . _DB_PREFIX_ . "marketplace_commision_calc` where `id_order`=" . $id_order);
		
		$currency = Db::getInstance()->getRow("SELECT `id_currency`  from `" . _DB_PREFIX_ . "orders` where `id_order`=" . $id_order);
		
        if (!$is_allready_calc) {
            $customer = Db::getInstance()->executeS("SELECT * from `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "order_detail` ordd on (ordd.`product_id`=msp.`id_product`) join `" . _DB_PREFIX_ . "marketplace_seller_product` mssp on(mssp.`id` = msp.`marketplace_seller_id_product`) join `" . _DB_PREFIX_ . "marketplace_customer` mc on(mc.`marketplace_seller_id` = mssp.`id_seller`) join `" . _DB_PREFIX_ . "customer` c on (c.`id_customer` = mc.`id_customer`) and ordd.`id_order`=" . $id_order);
            ///// for commision
            $d        = 0;
            foreach ($customer as $customer2) {
                $cust_com = Db::getInstance()->getRow('SELECT `commision` from ' . _DB_PREFIX_ . 'marketplace_commision where customer_id=' . $customer2['id_customer']);
                if (!$cust_com) {
                    $cust_com1 = Db::getInstance()->getRow('SELECT `commision` from ' . _DB_PREFIX_ . 'marketplace_commision where customer_id=0');
                    if (!$cust_com1) {
                        $cust_com11    = Db::getInstance()->getRow('SELECT `value` from ' . _DB_PREFIX_ . 'configuration where name="PS_CP_GLOBAL_COMMISION"');
                        $global_com    = $cust_com11['value'];
                        $customer_comm = $global_com;
                    } else {
                        $customer_comm = $cust_com1['commision'];
                    }
                } else {
                    $customer_comm = $cust_com['commision'];
                }
                $commision_array[] = $customer_comm;
                $d++;
            }
            $count = count($customer);
            for ($i = 0; $i < $count; $i++) {
                
                $commision           = (($customer[$i]['product_price'] * $customer[$i]['product_quantity']) * $commision_array[$i]) / 100;
                $insert_mkt_com_calc = Db::getInstance()->insert('marketplace_commision_calc', array(
                    'product_id' => $customer[$i]['id_product'],
                    'customer_id' => $customer[$i]['id_customer'],
                    'product_name' => $customer[$i]['product_name'],
                    'customer_name' => $customer[$i]['firstname'],
                    'price' => $customer[$i]['product_price'],
                    'quantity' => $customer[$i]['product_quantity'],
                    'commision' => $commision,
                    'id_order' => $id_order
                ));
				
				$mp_product_id = $customer[$i]['marketplace_seller_id_product'];
				$obj_seller_product = new SellerProductDetail($mp_product_id);
				
				$ps_id_shop = $obj_seller_product->ps_id_shop;
				//$available_qty = StockAvailable::getStockAvailableIdByProductId($customer[$i]['id_product'], null, $ps_id_shop);
				//$obj_seller_product->quantity = $available_qty;
				$obj_seller_product->quantity = $obj_seller_product->quantity-1;
				$is_change = $obj_seller_product->save();
				Hook::exec('actionSellerPaymentTransaction', array('commision' => $commision,'id_seller'=>$customer[$i]['id_customer'],'id_currency'=>$currency['id_currency']));
            }
			
		
			
	   }
		
			
		//for seller email
		
		$mkt_pd = new SellerProductDetail();
		$pd_list = $mkt_pd->getProductsByOrderId($id_order);
		$seller_list = array();
		if($pd_list)
		{
		  foreach($pd_list as $pd)
		  {
		    $mkt_product_id = $mkt_pd->checkProduct($pd['product_id']);
			if($mkt_product_id)
			{
			   $mkt_seller_id = $mkt_pd->getSellerIdByProduct($mkt_product_id);
			   if(!array_key_exists($mkt_seller_id,$seller_list))
			   {
			     $seller_list[$mkt_seller_id]['products'][] = $pd['product_id'];
				 $seller_list[$mkt_seller_id]['quantity'][] = $pd['product_quantity'];
			   }
			   else
			   {
			    $count = count($seller_list[$mkt_seller_id]['products']);
			    $seller_list[$mkt_seller_id]['products'][$count] = $pd['product_id'];
				$seller_list[$mkt_seller_id]['quantity'][$count] = $pd['product_quantity'];
			   }
			   //$customer_info = $mkt_pd->getCustomerDetails($mkt_seller_id);
			   
			}
		  }
		}
		
		
		if(count($seller_list))
		{
		  foreach($seller_list  as $key=>$value)
		  {
		    $customer_info = $mkt_pd->getCustomerInfo($this->context->customer->id);
			$id_address_delivery = $mkt_pd->getDeliverAddress($id_order); 
			$shipping_details = $mkt_pd->getShippingInfo($id_address_delivery);
			$state = $mkt_pd->getState($shipping_details['id_state']);
			$country = $mkt_pd->getCountry($shipping_details['id_country']);
		    $customer_id = $mkt_pd->getCustomerIdBySellerId($key);
			$seller_info = $mkt_pd->getSellerInfo($customer_id);
			
			$to = $seller_info['email'];
			$subject = "Order Detail";
			$html ='<html><head>
			</head><body>Hi '.$seller_info['firstname'].' '.$seller_info['lastname']."<br/><br/>";
			
			$html .='<div>
			         <b>Customer Name:'.$customer_info['firstname'].' '.$customer_info['lastname'].'</b><br/>
					 <b>Customer Email:'.$customer_info['email'].'</b><br/>
					 <b>Shipping Address:</b><br/><br/>
					 <div>
					  <table style="margin:0;padding:0;width:100%;">
					  <tr style="background-color:#FFAA56;">
					 <th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
                      font-family: Arial;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: center;
	                  padding: 7px;
	                  vartical-align:middle;">Name</th>
					  <th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
                      font-family: Arial;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: center;
	                  padding: 7px;
	                  vartical-align:middle;">Address</th>
					  <th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
                      font-family: Arial;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: center;
	                  padding: 7px;
	                  vartical-align:middle;">City</th>
					  <th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
                      font-family: Arial;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: center;
	                  padding: 7px;
	                  vartical-align:middle;">State</th>
					  <th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
                      font-family: Arial;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: center;
	                  padding: 7px;
	                  vartical-align:middle;">Country</th>
					  <th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
                      font-family: Arial;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: center;
	                  padding: 7px;
	                  vartical-align:middle;">Zip Code</th>
					  <th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
                      font-family: Arial;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: center;
	                  padding: 7px;
	                  vartical-align:middle;">Phone</th>
					  <th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
                      font-family: Arial;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: center;
	                  padding: 7px;
	                  vartical-align:middle;">Mobile No</th>
                     </tr>
                     <tr style="background-color:#FFFFFF;">
					  <td style="-moz-border-bottom-colors: none;
                      -moz-border-left-colors: none;
                      -moz-border-right-colors: none;
                      -moz-border-top-colors: none;
                      border-color: #000000;
                      border-image: none;
                      border-style: solid;
                      border-width: 0 1px 1px 0;
                      color: #000000;
                      font-family: Arial;
                      font-size: 10px;
                      font-weight: normal;
                      padding: 7px;
                      text-align: center;
                      vertical-align: middle;">'.$shipping_details['firstname'].' '.$shipping_details['firstname'].'</td>
					  <td style="-moz-border-bottom-colors: none;
                      -moz-border-left-colors: none;
                      -moz-border-right-colors: none;
                      -moz-border-top-colors: none;
                      border-color: #000000;
                      border-image: none;
                      border-style: solid;
                      border-width: 0 1px 1px 0;
                      color: #000000;
                      font-family: Arial;
                      font-size: 10px;
                      font-weight: normal;
                      padding: 7px;
                      text-align: center;
                      vertical-align: middle;">'.$shipping_details['address1'].', '.$shipping_details['address2'].'</td>
					  <td style="-moz-border-bottom-colors: none;
                      -moz-border-left-colors: none;
                      -moz-border-right-colors: none;
                      -moz-border-top-colors: none;
                      border-color: #000000;
                      border-image: none;
                      border-style: solid;
                      border-width: 0 1px 1px 0;
                      color: #000000;
                      font-family: Arial;
                      font-size: 10px;
                      font-weight: normal;
                      padding: 7px;
                      text-align: center;
                      vertical-align: middle;">'.$shipping_details['city'].'</td>
					   <td style="-moz-border-bottom-colors: none;
                      -moz-border-left-colors: none;
                      -moz-border-right-colors: none;
                      -moz-border-top-colors: none;
                      border-color: #000000;
                      border-image: none;
                      border-style: solid;
                      border-width: 0 1px 1px 0;
                      color: #000000;
                      font-family: Arial;
                      font-size: 10px;
                      font-weight: normal;
                      padding: 7px;
                      text-align: center;
                      vertical-align: middle;">'.$state.'</td>
					   <td style="-moz-border-bottom-colors: none;
                      -moz-border-left-colors: none;
                      -moz-border-right-colors: none;
                      -moz-border-top-colors: none;
                      border-color: #000000;
                      border-image: none;
                      border-style: solid;
                      border-width: 0 1px 1px 0;
                      color: #000000;
                      font-family: Arial;
                      font-size: 10px;
                      font-weight: normal;
                      padding: 7px;
                      text-align: center;
                      vertical-align: middle;">'.$country.'</td>
					   <td style="-moz-border-bottom-colors: none;
                      -moz-border-left-colors: none;
                      -moz-border-right-colors: none;
                      -moz-border-top-colors: none;
                      border-color: #000000;
                      border-image: none;
                      border-style: solid;
                      border-width: 0 1px 1px 0;
                      color: #000000;
                      font-family: Arial;
                      font-size: 10px;
                      font-weight: normal;
                      padding: 7px;
                      text-align: center;
                      vertical-align: middle;">'.$shipping_details['postcode'].'</td>
					   <td style="-moz-border-bottom-colors: none;
                      -moz-border-left-colors: none;
                      -moz-border-right-colors: none;
                      -moz-border-top-colors: none;
                      border-color: #000000;
                      border-image: none;
                      border-style: solid;
                      border-width: 0 1px 1px 0;
                      color: #000000;
                      font-family: Arial;
                      font-size: 10px;
                      font-weight: normal;
                      padding: 7px;
                      text-align: center;
                      vertical-align: middle;">'.$shipping_details['phone'].'</td>
					   <td style="-moz-border-bottom-colors: none;
                      -moz-border-left-colors: none;
                      -moz-border-right-colors: none;
                      -moz-border-top-colors: none;
                      border-color: #000000;
                      border-image: none;
                      border-style: solid;
                      border-width: 0 1px 1px 0;
                      color: #000000;
                      font-family: Arial;
                      font-size: 10px;
                      font-weight: normal;
                      padding: 7px;
                      text-align: center;
                      vertical-align: middle;">'.$shipping_details['phone_mobile'].'</td>
                     </tr>					 
					  </table>
					 </div>
		            </div><br/><br/>';
					$html .= '<b>Product List:</b><br/><div style="width:300px;  border: 1px solid #000000;border-radius: 0 0 0 0;box-shadow: 10px 10px 5px #888888;margin: 0;padding: 0;">

					<table style="margin:0;padding:0;width:100%;">
					<tr style="background-color:#FFAA56;">
					<th style="
						background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
						font-family: Arial;
						font-size: 14px;
						font-weight: bold;
						text-align: center;
						padding: 7px;
						vartical-align:middle;">Id</th>
					<th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
						font-family: Arial;
						font-size: 14px;
						font-weight: bold;
						text-align: center;
						padding: 7px;
						vartical-align:middle;">Name</th>
					<th style="background: -moz-linear-gradient(center top , #FF7F00 5%, #BF5F00 100%) repeat scroll 0 0 #FF7F00;
						font-family: Arial;
						font-size: 14px;
						font-weight: bold;
						text-align: center;
						padding: 7px;
						vartical-align:middle;">Qty</th>
					</tr>';
							$count = count($value['products']);
							//	foreach($value as $value1)
							for($i=0;$i<$count;$i++)
								{
								  $pd_info = $mkt_pd->getProductInfo($value['products'][$i]);
								  $html .='<tr style="background-color:#FFFFFF;">
								  <td style="-moz-border-bottom-colors: none;
						-moz-border-left-colors: none;
						-moz-border-right-colors: none;
						-moz-border-top-colors: none;
						border-color: #000000;
						border-image: none;
						border-style: solid;
						border-width: 0 1px 1px 0;
						color: #000000;
						font-family: Arial;
						font-size: 10px;
						font-weight: normal;
						padding: 7px;
						text-align: center;
						vertical-align: middle;">'.$value['products'][$i].'</td>
								  <td style="-moz-border-bottom-colors: none;
						-moz-border-left-colors: none;
						-moz-border-right-colors: none;
						-moz-border-top-colors: none;
						border-color: #000000;
						border-image: none;
						border-style: solid;
						border-width: 0 1px 1px 0;
						color: #000000;
						font-family: Arial;
						font-size: 10px;
						font-weight: normal;
						padding: 7px;
						text-align: center;
						vertical-align: middle;">'.$pd_info['name'].'</td>
								  <td style="-moz-border-bottom-colors: none;
						-moz-border-left-colors: none;
						-moz-border-right-colors: none;
						-moz-border-top-colors: none;
						border-color: #000000;
						border-image: none;
						border-style: solid;
						border-width: 0 1px 1px 0;
						color: #000000;
						font-family: Arial;
						font-size: 10px;
						font-weight: normal;
						padding: 7px;
						text-align: center;
						vertical-align: middle;">'.$value['quantity'][$i].'</td>
								  </tr>';
								}
								$html .= '</table></div></body></html>';
							  }
							  $headers = "MIME-Version: 1.0" . "\r\n";
							  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
							 // $abc='<html><head></head><body>jhg fuyewgruyegrue</body></html>';
							  mail($to,$subject,$html,$headers);
		}
    }
    public function hookDisplayCustomerAccount($params)
    {
		global $smarty;
        return $this->display(__FILE__, 'customeraccount.tpl');
    }
    
	public function hookDisplayProductTab($params)
    {
        global $smarty;
        $id_product         = Tools::getValue('id_product');
		$obj_marketplace_product = new SellerProductDetail();
        $isproductassociatetomarketplace = $obj_marketplace_product->getMarketPlaceShopProductDetail($id_product);
        if ($isproductassociatetomarketplace)
            return $this->display(__FILE__, 'seller_details_tab.tpl');
    }
	
	public function hookDisplayProductTabContent($params)
    {
		global $smarty;
        global $cookie;
        $link               = new link();
        
        $id_product         = Tools::getValue('id_product');
		
		$obj_marketplace_product = new SellerProductDetail();
		
        $seller_shop_detail = $obj_marketplace_product->getMarketPlaceShopProductDetail($id_product);
		
        if ($seller_shop_detail) {
            $id_shop         = $seller_shop_detail['id_shop'];
			$mkt_seller_pro  = $obj_marketplace_product->getMarketPlaceProductInfo($seller_shop_detail['marketplace_seller_id_product']);
		   
            $product_name    = $mkt_seller_pro['product_name'];
          
			$mkt_shop = $obj_marketplace_product->getMarketPlaceShopDetail($id_shop);
            $id_customer     = $mkt_shop['id_customer'];
			
			$obj_marketplace_seller = new SellerInfoDetail();
			$mkt_customer = $obj_marketplace_seller->getMarketPlaceSellerIdByCustomerId($id_customer);
           
            $seller_id       = $mkt_customer['marketplace_seller_id'];
			
           	$mkt_seller_info = $obj_marketplace_seller->getmarketPlaceSellerInfo($seller_id);
			
			$prof_size =  Configuration::get('prof-size');
			$prof_color =  Configuration::get('prof-color');
			$prof_font_family =  Configuration::get('prof-font-family');
					
					
            $email           = $mkt_seller_info['business_email'];
            $facebook_id     = $mkt_seller_info['facebook_id'];
            $twitter_id      = $mkt_seller_info['twitter_id'];
			
			$cust_id = $this->context->cookie->id_customer;
			
			$param = array('shop'=>$id_shop);
			$link_store         = $link->getModuleLink('marketplace', 'shopstore',$param);
			$link_collection    = $link->getModuleLink('marketplace', 'shopcollection',$param);
			$link_profile       = $link->getModuleLink('marketplace', 'sellerprofile',$param);
			$link_ask_que       = $link->getModuleLink('marketplace', 'shopaskque',$param);
			
			
            $smarty->assign("mkt_seller_info", $mkt_seller_info);
			$smarty->assign("cust_id", $cust_id);
            $smarty->assign("product_name", $product_name);
            $smarty->assign("id_shop", $id_shop);
            $smarty->assign("id_product", $id_product);
            $smarty->assign("link_store", $link_store);
            $smarty->assign("link_collection", $link_collection);
			$smarty->assign("seller_id", $seller_id);
            $smarty->assign("seller_email", $email);
            $smarty->assign("facebook_id", $facebook_id);
            $smarty->assign("twitter_id", $twitter_id);
            $smarty->assign("link_profile", $link_profile);
            $smarty->assign("link_ask_que", $link_ask_que);
			
			$smarty->assign("prof_size",$prof_size);

			$smarty->assign("prof_color",$prof_color);

			$smarty->assign("prof_font_family",$prof_font_family);
					
					
            return $this->display(__FILE__, 'seller_details_content.tpl');
        }    
    }
    
	public function callInstallTab() {
		$create_parent_tab = $this->installTab('AdminMarketplaceManagement','MarketPlace Management');
		$create_subtab_sellerinfo = $this->installTab('AdminSellerInfoDetail','Manage Seller Profile','AdminMarketplaceManagement');
		$create_subtab_productprice = $this->installTab('AdminSellerProductDetail','Manage Seller Product','AdminMarketplaceManagement');
		$create_subtab_commsetting = $this->installTab('AdminCommisionSetting','Manage Commision Setting','AdminMarketplaceManagement');
		$create_subtab_commcalc = $this->installTab('AdminCommisionCalc','Manage Commision Calculation','AdminMarketplaceManagement');
		$create_subtab_sellercomm = $this->installTab('AdminCustomerCommision','Manage Seller Commision','AdminMarketplaceManagement');
		$create_subtab_paymentmod = $this->installTab('AdminPaymentMode','Manage Payment Mode','AdminMarketplaceManagement');
		$create_subtab_sellerreview = $this->installTab('AdminReviews','Manage Seller Reviews','AdminMarketplaceManagement');
			return true;
	}
    
	public function installTab($class_name,$tab_name,$tab_parent_name=false) {
		$tab = new Tab();
		$tab->active = 1;
		$tab->class_name = $class_name;
		$tab->name = array();
		foreach (Language::getLanguages(true) as $lang)
			$tab->name[$lang['id_lang']] = $tab_name;
		if($tab_parent_name) {
			$tab->id_parent = (int)Tab::getIdFromClassName($tab_parent_name);
		} else {
			$tab->id_parent = 0;
		}
		
		$tab->module = $this->name;
		return $tab->add();
	}
    
    public function insertConfg()
    {
		Configuration::updateValue('PS_CP_GLOBAL_COMMISION', 10);
		return true;
    }
    public function hookLeftColumn($params)
    {
       //return true;
    }
  
	
	public function install()
    {
        Configuration::updateValue('PRODUCT_APPROVE', 'admin');
        Configuration::updateValue('SELLER_APPROVE', 'admin');
		if (!file_exists(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE))
            return (false);
        else if (!$sql = file_get_contents(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE))
            return (false);
        $sql = str_replace(array(
            'PREFIX_',
            'ENGINE_TYPE'
        ), array(
            _DB_PREFIX_,
            _MYSQL_ENGINE_
        ), $sql);
        $sql = preg_split("/;\s*[\r\n]+/", $sql);
        foreach ($sql AS $query)
            if ($query)
                if (!Db::getInstance()->execute(trim($query)))
                    return false;
         if (!parent::install() OR !$this->registerHook('leftColumn') OR !$this->registerHook('displaycustomerAccount') OR !$this->registerHook('orderConfirmation') OR !$this->registerHook('displayProductTab') OR !$this->registerHook('displayProductTabContent') OR !$this->add_profile() OR !$this->callInstallTab()  OR !$this->insertConfg() OR !$this->registerHook('displayMenuhook')
		 
		 OR !$this->registerHook('displayMpmenuhook')
		 OR !$this->registerHook('displayMpmyaccountmenuhook')
		 OR !$this->registerHook('displayMpOrderheaderlefthook')
		 OR !$this->registerHook('displayMpOrderheaderrighthook')
		 OR !$this->registerHook('displayMpbottomordercustomerhook')
		 OR !$this->registerHook('displayMpbottomorderstatushook')
		 OR !$this->registerHook('displayMpbottomorderproductdetailhook')
		 OR !$this->registerHook('displayMpordershippinghook')
		 OR !$this->registerHook('displayMpordershippinglefthook')
		 OR !$this->registerHook('displayMpordershippingrighthook')
		 OR !$this->registerHook('displayMpdashboardtophook')
		 OR !$this->registerHook('displayMpdashboardbottomhook')
		 OR !$this->registerHook('displayMpsplefthook')
		 OR !$this->registerHook('displayMpspcontentbottomhook')
		 OR !$this->registerHook('displayMpsprighthook')
		 OR !$this->registerHook('displayMpshoplefthook')
		 OR !$this->registerHook('displayMpshopcontentbottomhook')
		 OR !$this->registerHook('displayMpshoprighthook')
		 OR !$this->registerHook('displayMpcollectionlefthook')
		 OR !$this->registerHook('displayMpcollectionfooterhook')
		 OR !$this->registerHook('displayMpaddproductfooterhook')
		 OR !$this->registerHook('displayMpupdateproductfooterhook')
		 OR !$this->registerHook('displayMpshoprequestfooterhook')
		 OR !$this->registerHook('displayMpshopaddfooterhook')
		 OR !$this->registerHook('displayMpproductdetailheaderhook')
		 OR !$this->registerHook('displayMpproductdetailfooterhook')
		 OR !$this->registerHook('displayMppaymentdetailfooterhook')
		 OR !$this->registerHook('displayMpsellerinfobottomhook')
		 OR !$this->registerHook('displayMpsellerleftbottomhook')
		 OR !$this->registerHook('actionAddproductExtrafield')
		 OR !$this->registerHook('actionUpdateproductExtrafield')
		 OR !$this->registerHook('actionAddshopExtrafield')
		 OR !$this->registerHook('actionUpdateshopExtrafield')
		 )
            return false;
        return true;
    }
    
	 public function dropTable()
    {
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_seller_product');
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_seller_product_category');
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_seller_info');
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_shop');
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_shop_product');
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_customer');
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_product_image');
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_commision_calc');
        Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_commision');
		Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_payment_mode');
		Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'marketplace_customer_payment_detail');
		Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'seller_reviews');
        return true;
    }
	public function deleteProfile() {
		$profile = new Profile();
		$profile->id = Configuration::get('market_place_seller_profile_id');
		return $profile->delete();
	}
	
    public function deleteConfig()
    {
        Configuration::deleteByName('PS_CP_GLOBAL_COMMISION');
		Configuration::deleteByName('market_place_seller_profile_id');
		return true;
    }
        
	public function callUninstallTab() {
		$uninstall_subtab_productprice = $this->uninstallTab('AdminReviews');
		$uninstall_parent_tab = $this->uninstallTab('AdminPaymentMode');
		$uninstall_parent_tab = $this->uninstallTab('AdminCustomerCommision');
		$uninstall_parent_tab = $this->uninstallTab('AdminCommisionCalc');
		$uninstall_parent_tab = $this->uninstallTab('AdminCommisionSetting');
		$uninstall_parent_tab = $this->uninstallTab('AdminSellerProductDetail');
		$uninstall_parent_tab = $this->uninstallTab('AdminSellerInfoDetail');
		$uninstall_parent_tab = $this->uninstallTab('AdminMarketplaceManagement');
		return true;
	}
		
	public function uninstallTab($class_name) {
		$id_tab = (int)Tab::getIdFromClassName($class_name);
		if ($id_tab)
		{
			$tab = new Tab($id_tab);
			return $tab->delete();
		}
		else
			return false;
	}
	
	public function deleteOverrideFile()
	{
		$override_dispather_file = _PS_ROOT_DIR_.'/override/classes/Dispatcher.php';
		$responce = @unlink($override_dispather_file);
		return $responce;
	}
		
   
    public function uninstall()
    {
        if(parent::uninstall() == false OR !$this->dropTable() OR !$this->callUninstallTab() OR !$this->deleteProfile() OR !$this->deleteConfig() OR !$this->deleteOverrideFile())
            return false;
        return true;
    }
}
?>