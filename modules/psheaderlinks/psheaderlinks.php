<?php

if (!defined('_PS_VERSION_'))
	exit;

class psHeaderLinks extends Module
{
	/* @var boolean error */
	protected $_errors = false;
	
	public function __construct()
	{
		$this->name = 'psheaderlinks';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'Nemo';
		$this->need_instance = 0;
		$this->table_name = 'psheaderlinks';

	 	parent::__construct();

		$this->displayName = $this->l('Configurable Header Links');
		$this->description = $this->l('Adds a block in the header with the possibility to add custom links.');
	}
	
	public function install()
	{
		if (!parent::install() OR
			!$this->_installTable() OR
			!$this->registerHook('header') OR
			!$this->registerHook('top') OR
                        !$this->registerHook('nav')
                        )
			return false;
		return true;
	}
	
	public function uninstall()
	{
		if (!parent::uninstall() OR
			 !$this->_eraseTable() )
			return false;
		return true;
	}


	private function _installTable(){
		$sql = 'CREATE TABLE  `'._DB_PREFIX_.$this->table_name.'` (
				`id_link` INT( 12 ) NOT NULL ,
				`text` VARCHAR( 64 ) NOT NULL ,
				`title` VARCHAR( 64 ) NOT NULL ,
				`url` VARCHAR( 256 ) NOT NULL ,
				`id_lang` INT( 12 ) NOT NULL
				) ENGINE =' ._MYSQL_ENGINE_;
		if (!Db::getInstance()->Execute($sql))
			return false;
		else return true;
	}

	/* Used in conjuction with the previous, delete if not necessary */
	private function _eraseTable(){
		if(!Db::getInstance()->Execute('DROP TABLE `'._DB_PREFIX_.$this->table_name.'`'))
			return false;
		else return true;
	}
	

	public function getContent(){
		$this->_html = '<h2>'.$this->displayName.'</h2>';

		$this->_postProcess();
		
		if (Tools::isSubmit('editLink'))
		{
			$this->_displayEditForm();
		} else
			$this->_displayForm();
		return	$this->_html;
	}

	private function _postProcess()
	{
		if (Tools::isSubmit('submitAddLink'))
		{
			$posting = true;
			// get max id added so far
				$max_id = Db::getInstance()->getValue('SELECT MAX(id_link) FROM '._DB_PREFIX_.$this->table_name);

				
				if(!$max_id)
					$max_id = 1;
				else $max_id++;

				
			foreach (Tools::getValue('lang') as $id_lang => $values ) {

				$values['id_link'] = $max_id;
				$values['id_lang'] = $id_lang;

				if (!Db::getInstance()->insert($this->table_name, $values))
					$this->_errors[] = $this->l('Error: ').mysql_error();
			}
			$confirmation = $this->l('New Link Added Successfully');
			
		}
		else if (Tools::isSubmit('submitEditLink'))
		{
			$posting = true;
			$confirmation = $this->l('Link Successfully modified');

			$id_link = Tools::getValue('id_link');
			foreach (Tools::getValue('lang') as $id_lang => $values ) {

				

				if (!Db::getInstance()->update($this->table_name, $values, 'id_link = ' . $id_link . ' AND id_lang = ' . $id_lang))
					$this->_errors[] = $this->l('Error: ').mysql_error();
			}

		} else if (Tools::isSubmit('deleteLink'))
		{
			
			$posting = true;
			$confirmation = $this->l('Link Successfully deleted');

			$id_link = Tools::getValue('deleteLink');
			if(!Db::getInstance()->delete($this->table_name, 'id_link = '.$id_link))
				$this->_errors[] = $this->l('Error: ').mysql_error();

		}

		if(isset($posting))
			if(!$this->_errors)
				$this->_html .= $this->displayConfirmation($confirmation);
			else
				$this->_html .= $this->displayError(implode($this->_errors, '<br />'));
	}

	private function _displayEditForm()
	{
		$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

		// In any case, display the add link form
		

		
		$languages = Language::getLanguages(false);
		$divLangName = 'text¤title¤url';


		$this->_html .= '
			<form action="'.AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'" method="post">
				<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
		';

		
		
		$link = $this->getLink(Tools::getValue('editLink'));

		// set empty values if there are new languages
		
		foreach ($languages as $language) {
			if( !isset($link[$language['id_lang']]) )
				$link[$language['id_lang']] = array('text' => '', 'url' =>'', 'title'=> '');
		}
		
		$this->_html .= '<h4>'.$this->l('Edit Link').'</h4>';
		
		$this->_html .='
					<label>'.$this->l('Text:').'</label>
					<div class="margin-form">';
					foreach ($languages as $language)
						$this->_html .= '
							<div id="text_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').'; float: left;">
								<input value="'.$link[$language['id_lang']]['text'].'" type="text" name="lang['.$language['id_lang'].'][text]" id="textInput_'.$language['id_lang'].'"/><sup> *</sup>
							</div>';
					$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'text', true);
					$this->_html .= '
						<div class="clear"></div>
					</div>
		';
		$this->_html .='
					<label>'.$this->l('Url:').'</label>
					<div class="margin-form">';
					foreach ($languages as $language)
						$this->_html .= '
							<div id="url_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').'; float: left;">
								<input value="'.$link[$language['id_lang']]['url'].'" size="100" type="text" name="lang['.$language['id_lang'].'][url]" id="urlInput_'.$language['id_lang'].'"/><sup> *</sup>
							</div>';
					$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'url', true);
					$this->_html .= '
						<div class="clear"></div>
					</div>
		';		
		$this->_html .='
					<label>'.$this->l('Title:').'</label>
					<div class="margin-form">';
					foreach ($languages as $language)
						$this->_html .= '
							<div id="title_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').'; float: left;">
								<input value="'.$link[$language['id_lang']]['title'].'" type="text" name="lang['.$language['id_lang'].'][title]" id="textInput_'.$language['id_lang'].'"/><sup> *</sup>
							</div>';
					$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'title', true);
					$this->_html .= '
						<div class="clear"></div>
					</div>
		';		
		
		$this->_html .= '<input type="hidden" name="id_link" value="'.Tools::getValue('editLink').'" >';

		/* Submit button */
		$this->_html .='<p class="center"><input type="submit" name="submitEditLink" value="'.$this->l('Submit Modifications').'"" class="button"></p>';


		$this->_html .= '
				</fieldset>
			</form>';

	}

	
	private function _displayForm()
	{

		$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

		// In any case, display the add link form
		

		
		$languages = Language::getLanguages(false);
		$divLangName = 'text¤title¤url';


		$this->_html .= '
			<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
				<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
		';

		// Links list
		
		$links = $this->getLinks();
		// if there's any link, display them in the list, and add languages of course


		if($links)
		{
			$this->_html .= '<h4>'.$this->l('Added Links').'</h4>';
			$this->_html .= '<table class="table">
				
				<thead>
					<tr>
						<th>#</th>
						<th>'.$this->l('Link Text').'</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>';

				foreach ($links as $link) {
					$this->_html .= '
					<tr>
						<td>'.$link['id_link'].'</td>
						<td>'.$link['text'].'</td>
						<td><a href="'.AdminController::$currentIndex.'&editLink='.$link['id_link'].'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'" title="'.$this->l('Edit this link').'"><img src="../img/admin/edit.gif"></a></td>
						<td><a href="'.AdminController::$currentIndex.'&deleteLink='.$link['id_link'].'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'" title="'.$this->l('Edit this link').'"><img src="../img/admin/delete.gif"></a></td>
					</tr>';
				}
			$this->_html .= '
				</tbody>
			</table>';		
		}


		$this->_html .= '<h4>'.$this->l('Add new Link').'</h4>';
		
		$this->_html .='
					<label>'.$this->l('Text:').'</label>
					<div class="margin-form">';
					foreach ($languages as $language)
						$this->_html .= '
							<div id="text_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').'; float: left;">
								<input type="text" name="lang['.$language['id_lang'].'][text]" id="textInput_'.$language['id_lang'].'"/><sup> *</sup>
							</div>';
					$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'text', true);
					$this->_html .= '
						<div class="clear"></div>
					</div>
		';
		$this->_html .='
					<label>'.$this->l('Url:').'</label>
					<div class="margin-form">';
					foreach ($languages as $language)
						$this->_html .= '
							<div id="url_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').'; float: left;">
								<input size="100" type="text" name="lang['.$language['id_lang'].'][url]" id="urlInput_'.$language['id_lang'].'"/><sup> *</sup>
							</div>';
					$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'url', true);
					$this->_html .= '
						<div class="clear"></div>
					</div>
		';		
		$this->_html .='
					<label>'.$this->l('Title:').'</label>
					<div class="margin-form">';
					foreach ($languages as $language)
						$this->_html .= '
							<div id="title_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').'; float: left;">
								<input type="text" name="lang['.$language['id_lang'].'][title]" id="textInput_'.$language['id_lang'].'"/><sup> *</sup>
							</div>';
					$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'title', true);
					$this->_html .= '
						<div class="clear"></div>
					</div>
		';		
		/* Submit button */
		$this->_html .='<p class="center"><input type="submit" name="submitAddLink" value="'.$this->l('Add this link').'"" class="button"></p>';


		$this->_html .= '
				</fieldset>
			</form>';
	}


	public function getLinks( $id_lang = false )
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT *
			FROM '._DB_PREFIX_.$this->table_name . ($id_lang ? ' WHERE id_lang = ' .$id_lang : '' ) . ' GROUP BY id_link');
	}

	public function getLink( $id_link )
	{
		$result =  Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT *
			FROM '._DB_PREFIX_.$this->table_name . ' WHERE id_link = ' . $id_link );

		// rearrange result based on language ids
		if ( $result )
		{
			foreach ($result as $link) {
				$links[$link['id_lang']] = $link;
			}
			return $links;
		}

	}

	public function hookHeader($params)	
	{
		$this->context->controller->addCSS($this->_path.'psheaderlinks.css', 'all');
	}

	public function hookTop($params)
	{
		
		$links = $this->getLinks($this->context->language->id);
		$this->smarty->assign(array(
			'psheaderlinks' => $links
		));
		return $this->display(__FILE__, 'psheaderlinks.tpl');
	}

	
}
