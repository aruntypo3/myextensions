<?php
/***************************************************************
 *  Copyright notice
*
*  (c) 1999-2011 Kasper Skårhøj (kasperYYYY@typo3.com)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Wizard to help make tables (eg. for tt_content elements) of type "table".
* Each line is a table row, each cell divided by a |
*
* Revised for TYPO3 3.6 November/2003 by Kasper Skårhøj
* XHTML compliant
*
* @author	Kasper Skårhøj <kasperYYYY@typo3.com>
*/


define('TYPO3_MOD_PATH', '../typo3conf/ext/pits_elearn/wizard/');


require ('../../../../typo3/init.php');
require ('../../../../typo3/template.php');
$GLOBALS['LANG']->includeLLFile('EXT:lang/locallang_wizards.xml');






/**
 * Script Class for rendering the Table Wizard
 *
 * @author	Kasper Skårhøj <kasperYYYY@typo3.com>
 * @package TYPO3
 * @subpackage core
*/
class wizard_table {

	// Internal, dynamic:
	/**
	* document template object
	*
	* @var mediumDoc
	*/
	var $doc;
	var $content;				// Content accumulation for the module.
	var $include_once=array();	// List of files to include.
	var $inputStyle=0;			// TRUE, then <input> fields are shown, not textareas.


	// Internal, static:
	var $xmlStorage=0;			// If set, the string version of the content is interpreted/written as XML instead of the original linebased kind. This variable still needs binding to the wizard parameters - but support is ready!
	var $numNewRows=1;			// Number of new rows to add in bottom of wizard
	var $colsFieldName='cols';	// Name of field in parent record which MAY contain the number of columns for the table - here hardcoded to the value of tt_content. Should be set by TCEform parameters (from P)


	// Internal, static: GPvars
	var $P;						// Wizard parameters, coming from TCEforms linking to the wizard.
	var $TABLECFG;				// The array which is constantly submitted by the multidimensional form of this wizard.

	// table parsing
	var $tableParsing_quote;			// quoting of table cells
	var $tableParsing_delimiter;		// delimiter between table cells





	/**
	 * Initialization of the class
	 *
	 * @return	void
	 */
	function init()	{
		// GPvars:
		$this->P = t3lib_div::_GP('P');
		$this->TABLECFG = t3lib_div::_GP('TABLE');

		// Setting options:
		$this->xmlStorage = $this->P['params']['xmlOutput'];
		$this->numNewRows = t3lib_utility_Math::forceIntegerInRange($this->P['params']['numNewRows'],1,50,5);

		// Textareas or input fields:
		$this->inputStyle=isset($this->TABLECFG['textFields']) ? $this->TABLECFG['textFields'] : 1;

		// Document template object:
		$this->doc = t3lib_div::makeInstance('template');
		$this->doc->backPath = $GLOBALS['BACK_PATH'];
		//$this->doc->styleSheetFile2 = '../typo3conf/ext/bibus_cms/layout/res/test.css' ;

		//$this->doc->backPath = ../;
		$this->doc->setModuleTemplate('templates/wizard_table.html');
		$this->doc->JScode=$this->doc->wrapScriptTags('
				function jumpToUrl(URL,formEl)	{	//
				window.location.href = URL;
	}
				');

		// Setting form tag:
		list($rUri) = explode('#',t3lib_div::getIndpEnv('REQUEST_URI'));
		$this->doc->form ='<form action="'.htmlspecialchars($rUri).'" method="post" name="wizardForm">';

		// If save command found, include tcemain:
		if ($_POST['savedok_x'] || $_POST['saveandclosedok'])	{
			$this->include_once[]=PATH_t3lib.'class.t3lib_tcemain.php';
		}

		$this->tableParsing_delimiter = '|';
		$this->tableParsing_quote = '';
	}

	/**
	 * Main function, rendering the table wizard
	 *
	 * @return	void
	 */
	function main()	{
		if ($this->P['table'] && $this->P['field'] && $this->P['uid']) {
			$this->content.= $this->doc->section($GLOBALS['LANG']->getLL('table_title'), $this->tableWizard(), 0, 1);
		} else {
			$this->content.= $this->doc->section($GLOBALS['LANG']->getLL('table_title'), '<span class="typo3-red">' . $GLOBALS['LANG']->getLL('table_noData',1) . '</span>', 0, 1);
		}

		// Setting up the buttons and markers for docheader
		$docHeaderButtons = $this->getButtons();
		$markers['CSH'] = $docHeaderButtons['csh'];
		$markers['CONTENT'] = $this->content;

		// Build the <body> for the module
		$this->content = $this->doc->startPage('Table');
		$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
		$this->content.= $this->doc->endPage();
		$this->content = $this->doc->insertStylesAndJS($this->content);
	}

	/**
	 * Outputting the accumulated content to screen
	 *
	 * @return	void
	 */
	function printContent()	{
		echo $this->content;
	}

	/**
	 * Create the panel of buttons for submitting the form or otherwise perform operations.
	 *
	 * @return array all available buttons as an assoc. array
	 */
	protected function getButtons() {
		$buttons = array(
				'csh' => '',
				'csh_buttons' => '',
				'close' => '',
				'save' => '',
				'save_close' => '',
				'reload' => '',
		);

		if ($this->P['table'] && $this->P['field'] && $this->P['uid']) {
			// CSH
			$buttons['csh'] = t3lib_BEfunc::cshItem('xMOD_csh_corebe', 'wizard_table_wiz', $GLOBALS['BACK_PATH'], '');

			// CSH Buttons
			$buttons['csh_buttons'] = t3lib_BEfunc::cshItem('xMOD_csh_corebe', 'wizard_table_wiz_buttons', $GLOBALS['BACK_PATH'], '');

			// Close
			$buttons['close'] = '<a href="#" onclick="' . htmlspecialchars('jumpToUrl(unescape(\'' . rawurlencode(t3lib_div::sanitizeLocalUrl($this->P['returnUrl'])) . '\')); return false;') . '">' .
					t3lib_iconWorks::getSpriteIcon('actions-document-close', array('title' => $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.closeDoc', TRUE))) .
					'</a>';

			// Save
			$buttons['save'] = '<input type="image" class="c-inputButton" name="savedok"' . t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/', 'gfx/savedok.gif') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveDoc', 1) . '" />';

			// Save & Close
			$buttons['save_close'] = '<input type="image" class="c-inputButton" name="saveandclosedok"' . t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/', 'gfx/saveandclosedok.gif') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveCloseDoc', 1) . '" />';

			// Reload
			$buttons['reload'] = '<input type="image" class="c-inputButton" name="_refresh"' . t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/', 'gfx/refresh_n.gif') . ' title="' . $GLOBALS['LANG']->getLL('forms_refresh', 1) . '" />';
		}

		return $buttons;
	}

	/**
	 * Draws the table wizard content
	 *
	 * @return	string		HTML content for the form.
	 */
	function tableWizard()	{

		// First, check the references by selecting the record:
		$row = t3lib_BEfunc::getRecord($this->P['table'],$this->P['uid']);
		if (!is_array($row)) {
			throw new RuntimeException('Wizard Error: No reference to record', 1294587125);
		}
		//added by siva to get default 3 colum start
		$row['cols'] = 4 ;
		//added by siva to get default 3 colum end
		// This will get the content of the form configuration code field to us - possibly cleaned up, saved to database etc. if the form has been submitted in the meantime.
		$tableCfgArray = $this->getConfigCode($row);
		// Generation of the Table Wizards HTML code:
		$content = $this->getTableHTML($tableCfgArray,$row);

		// Return content:
		return $content;
	}







	/***************************
	 *
	* Helper functions
	*
	***************************/

	/**
	 * Will get and return the configuration code string
	 * Will also save (and possibly redirect/exit) the content if a save button has been pressed
	 *
	 * @param	array		Current parent record row
	 * @return	array		Table config code in an array
	 * @access private
	 */
	function getConfigCode($row)	{

		// get delimiter settings
		$flexForm = t3lib_div::xml2array($row['pi_flexform']);

		if (is_array($flexForm)) {
			$this->tableParsing_quote = $flexForm['data']['s_parsing']['lDEF']['tableparsing_quote']['vDEF']?chr(intval($flexForm['data']['s_parsing']['lDEF']['tableparsing_quote']['vDEF'])):'';
			$this->tableParsing_delimiter = $flexForm['data']['s_parsing']['lDEF']['tableparsing_delimiter']['vDEF']?chr(intval($flexForm['data']['s_parsing']['lDEF']['tableparsing_delimiter']['vDEF'])):'|';
		}

		// If some data has been submitted, then construct
		if (isset($this->TABLECFG['c']))	{

			// Process incoming:
			$this->changeFunc();


			// Convert to string (either line based or XML):
			if ($this->xmlStorage)	{
				// Convert the input array to XML:
				$bodyText = t3lib_div::array2xml_cs($this->TABLECFG['c'],'T3TableWizard');

				// Setting cfgArr directly from the input:
				$cfgArr = $this->TABLECFG['c'];
			} else {
				// Convert the input array to a string of configuration code:
				$bodyText = $this->cfgArray2CfgString($this->TABLECFG['c']);

				// Create cfgArr from the string based configuration - that way it is cleaned up and any incompatibilities will be removed!
				$cfgArr = $this->cfgString2CfgArray($bodyText,$row[$this->colsFieldName]);
			}
			// If a save button has been pressed, then save the new field content:
			if ( !empty($_POST['saveandclosedok_x']) || $_POST['saveandclosedok_x'] == 0 )	{
				// Make TCEmain object:
				$tce = t3lib_div::makeInstance('t3lib_TCEmain');
				$tce->stripslashes_values=0;

				// Put content into the data array:
				$data=array();
				$count = strrpos($bodyText , ']');
				if ( $count > 0)
					$bodyText =  substr ( $bodyText , $count+1 , strlen($bodyText)   ) ;
				$data[$this->P['table']][$this->P['uid']][$this->P['field']]=$bodyText;

				// Perform the update:
				$tce->start($data,array());
				$tce->process_datamap();

				// If the save/close button was pressed, then redirect the screen:
				if (!empty($_POST['saveandclosedok_x'])) {
					t3lib_utility_Http::redirect(t3lib_div::sanitizeLocalUrl($this->P['returnUrl']));
				}
			}
		} else {	// If nothing has been submitted, load the $bodyText variable from the selected database row:
			if ($this->xmlStorage)	{
				$cfgArr = t3lib_div::xml2array($row[$this->P['field']]);
			} else {	// Regular linebased table configuration:
				$cfgArr = $this->cfgString2CfgArray($row[$this->P['field']],$row[$this->colsFieldName]);
			}
			$cfgArr = is_array($cfgArr) ? $cfgArr : array();
		}

		return $cfgArr;
	}

	/**
	 * Creates the HTML for the Table Wizard:
	 *
	 * @param	array		Table config array
	 * @param	array		Current parent record array
	 * @return	string		HTML for the table wizard
	 * @access private
	 */
	function getTableHTML($cfgArr,$row)	{
		// Traverse the rows:
		$tRows=array();
		$k=0;
		foreach($cfgArr as $cellArr)	{
			if (is_array($cellArr))	{
				// Initialize:
				$cells=array();
				$a=0;

				// Traverse the columns:
				foreach($cellArr as $cellContent)	{
					if ($this->inputStyle)	{
						#$newCellContent = explode( "->" , $cellContent )  ;
						$count = strrpos($cellContent , ']');
						if ( $count > 0)
							$cellContent=  substr ( $cellContent , $count+1 , strlen( $cellContent )   ) ;
						$style = $this->doc->formWidth(20) ;
						if( $a == 0 && $k == 0 ){
							$style = 'style ="width :192 px; display:none;"';
						}
						$type = '';
						if( $k != 0 &&  $a != 0  ){
							$cellContent = !empty ( $cellContent ) ? $cellContent : '' ;
							if ( $a != 0  ){
								$CHECKED = ( htmlspecialchars($cellContent) == 1  ) ? "CHECKED" : "";
								$cells[]='<input type="hidden"  name="TABLE[c]['.(($k+1)*2).']['.(($a+1)*2).']" value="0"/>
										<input type="checkbox"  name="TABLE[c]['.(($k+1)*2).']['.(($a+1)*2).']" value="1"  '.$CHECKED.'/>';
							}else {
								$cells[]='<input type="text"  name="TABLE[c]['.(($k+1)*2).']['.(($a+1)*2).']" value="'.htmlspecialchars($cellContent).'" /> ';
							}
								
						}else {
							$ld = 0 ;
							if ( $a !=  0 ){
								$ld = 1;
							}
								
							$cells[]='<input type="text"'.$style.' name="TABLE[c]['.(($k+1)*2).']['.(($a+1)*2).']" value="'.htmlspecialchars($cellContent).'" /> ' ;
						}


					} else {
						$cellContent=preg_replace('/<br[ ]?[\/]?>/i',LF,$cellContent);
						$cells[]='<textarea '.$this->doc->formWidth(20).' rows="5" name="TABLE[c]['.(($k+1)*2).']['.(($a+1)*2).']">'.t3lib_div::formatForTextarea($cellContent).'</textarea>';
					}

					// Increment counter:
					$a++;
				}

				// CTRL panel for a table row (move up/down/around):
				$onClick="document.wizardForm.action+='#ANC_".(($k+1)*2-2)."';";
				$onClick=' onclick="'.htmlspecialchars($onClick).'"';
				$ctrl='';

				$brTag=$this->inputStyle?'':'<br />';
				if ($k!=0)	{
					$ctrl.='<input type="image" name="TABLE[row_up]['.(($k+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/pil2up.gif','').$onClick.' title="'.$GLOBALS['LANG']->getLL('table_up',1).'" />'.$brTag;
				} else {
					$ctrl.='<input type="image" name="TABLE[row_bottom]['.(($k+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/turn_up.gif','').$onClick.' title="'.$GLOBALS['LANG']->getLL('table_bottom',1).'" />'.$brTag;
				}
				$ctrl.='<input type="image" name="TABLE[row_remove]['.(($k+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/garbage.gif','').$onClick.' title="'.$GLOBALS['LANG']->getLL('table_removeRow',1).'" />'.$brTag;

				// FIXME what is $tLines? See wizard_forms.php for the same.
				if (($k+1)!=count($tLines))	{
					$ctrl.='<input type="image" name="TABLE[row_down]['.(($k+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/pil2down.gif','').$onClick.' title="'.$GLOBALS['LANG']->getLL('table_down',1).'" />'.$brTag;
				} else {
					$ctrl.='<input type="image" name="TABLE[row_top]['.(($k+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/turn_down.gif','').$onClick.' title="'.$GLOBALS['LANG']->getLL('table_top',1).'" />'.$brTag;
				}
				//'.$GLOBALS['LANG']->getLL('table_addRow',1).'
				$ctrl.='<input type="image" name="TABLE[row_add]['.(($k+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/add.gif','').$onClick.' title="add new row"  value="ADD NEW ROW"/>'.$brTag;

				$tRows[]='
						<tr class="bgColor4">
						<td class="bgColor5"><a name="ANC_'.(($k+1)*2).'"></a><span class="c-wizButtonsV">'.$ctrl.'</span></td>
								<td>'.implode('</td>
										<td>',$cells).'</td>
												</tr>';

				// Increment counter:
				$k++;
			}
		}

		// CTRL panel for a table column (move left/right/around/delete)
		$cells=array();
		$cells[]='';
		// Finding first row:
		$firstRow = reset($cfgArr);
		if (is_array($firstRow))	{

			// Init:
			$a=0;
			$cols=count($firstRow);

			// Traverse first row:
			foreach($firstRow as $temp)	{
				$ctrl='';
				if ($a!=0)	{
					//$ctrl.='<input type="image" name="TABLE[col_left]['.(($a+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/pil2left.gif','').' title="'.$GLOBALS['LANG']->getLL('table_left',1).'" />';
				} else {
					//$ctrl.='<input type="image" name="TABLE[col_end]['.(($a+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/turn_left.gif','').' title="'.$GLOBALS['LANG']->getLL('table_end',1).'" />';
				}
				//$ctrl.='<input type="image" name="TABLE[col_remove]['.(($a+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/garbage.gif','').' title="'.$GLOBALS['LANG']->getLL('table_removeColumn',1).'" />';
				if (($a+1)!=$cols)	{
					//$ctrl.='<input type="image" name="TABLE[col_right]['.(($a+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/pil2right.gif','').' title="'.$GLOBALS['LANG']->getLL('table_right',1).'" />';
				} else {
					//$ctrl.='<input type="image" name="TABLE[col_start]['.(($a+1)*2).']"'.t3lib_iconWorks::skinImg(t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/turn_right.gif','').' title="'.$GLOBALS['LANG']->getLL('table_start',1).'" />';
				}
				//$ctrl.='<input type="image" name="TABLE[col_add]['.(($a+1)*2).']"'.t3lib_iconWorks::skinImg( t3lib_div::getIndpEnv('TYPO3_SITE_URL').'typo3/','gfx/add.gif','').' title="'.$GLOBALS['LANG']->getLL('table_addColumn',1).'" />';
				$cells[]='<span class="c-wizButtonsH">'.$ctrl.'</span>';

				// Incr. counter:
				$a++;
			}
			$tRows[]='
					<tr class="bgColor5">
					<td align="center">'.implode('</td>
							<td align="center">',$cells).'</td>
									</tr>';
		}

		$content = '';

		// Implode all table rows into a string, wrapped in table tags.
		$content.= '


				<!--
				Table wizard
				-->
				<table border="0" cellpadding="0" cellspacing="1" id="typo3-tablewizard">
				'.implode('',$tRows).'
						</table>';

		// Input type checkbox:
		$content.= '

				<!--
				Input mode check box:
				-->
				<div id="c-inputMode">
				'.
				'<input type="hidden" name="TABLE[textFields]" value="0" />'.
				'<input type="checkbox" name="TABLE[textFields]" id="textFields" value="1"'.($this->inputStyle?' checked="checked"':'').' /> <label for="textFields">'.
				$GLOBALS['LANG']->getLL('table_smallFields').'</label>
						</div>

						<br /><br />
						';

		// Return content:
		return $content;
	}

	/**
	 * Detects if a control button (up/down/around/delete) has been pressed for an item and accordingly it will manipulate the internal TABLECFG array
	 *
	 * @return	void
	 * @access private
	 */
	function changeFunc()	{
		if ($this->TABLECFG['col_remove'])	{
			$kk = key($this->TABLECFG['col_remove']);
			$cmd='col_remove';
		} elseif ($this->TABLECFG['col_add'])	{
			$kk = key($this->TABLECFG['col_add']);
			$cmd='col_add';
		} elseif ($this->TABLECFG['col_start'])	{
			$kk = key($this->TABLECFG['col_start']);
			$cmd='col_start';
		} elseif ($this->TABLECFG['col_end'])	{
			$kk = key($this->TABLECFG['col_end']);
			$cmd='col_end';
		} elseif ($this->TABLECFG['col_left'])	{
			$kk = key($this->TABLECFG['col_left']);
			$cmd='col_left';
		} elseif ($this->TABLECFG['col_right'])	{
			$kk = key($this->TABLECFG['col_right']);
			$cmd='col_right';
		} elseif ($this->TABLECFG['row_remove'])	{
			$kk = key($this->TABLECFG['row_remove']);
			$cmd='row_remove';
		} elseif ($this->TABLECFG['row_add'])	{
			$kk = key($this->TABLECFG['row_add']);
			$cmd='row_add';
		} elseif ($this->TABLECFG['row_top'])	{
			$kk = key($this->TABLECFG['row_top']);
			$cmd='row_top';
		} elseif ($this->TABLECFG['row_bottom'])	{
			$kk = key($this->TABLECFG['row_bottom']);
			$cmd='row_bottom';
		} elseif ($this->TABLECFG['row_up'])	{
			$kk = key($this->TABLECFG['row_up']);
			$cmd='row_up';
		} elseif ($this->TABLECFG['row_down'])	{
			$kk = key($this->TABLECFG['row_down']);
			$cmd='row_down';
		}

		if ($cmd && t3lib_utility_Math::canBeInterpretedAsInteger($kk)) {
			if (substr($cmd,0,4)=='row_')	{
				switch($cmd)	{
					case 'row_remove':
						unset($this->TABLECFG['c'][$kk]);
						break;
					case 'row_add':
						#$this->numNewRows
						for($a=1;$a<=1;$a++)	{
							if (!isset($this->TABLECFG['c'][$kk+$a]))	{	// Checking if set: The point is that any new row inbetween existing rows will be TRUE after one row is added while if rows are added in the bottom of the table there will be no existing rows to stop the addition of new rows which means it will add up to $this->numNewRows rows then.
								$this->TABLECFG['c'][$kk+$a] = array();
							} else {
								break;
							}
						}
						break;
					case 'row_top':
						$this->TABLECFG['c'][1]=$this->TABLECFG['c'][$kk];
						unset($this->TABLECFG['c'][$kk]);
						break;
					case 'row_bottom':
						$this->TABLECFG['c'][10000000]=$this->TABLECFG['c'][$kk];
						unset($this->TABLECFG['c'][$kk]);
						break;
					case 'row_up':
						$this->TABLECFG['c'][$kk-3]=$this->TABLECFG['c'][$kk];
						unset($this->TABLECFG['c'][$kk]);
						break;
					case 'row_down':
						$this->TABLECFG['c'][$kk+3]=$this->TABLECFG['c'][$kk];
						unset($this->TABLECFG['c'][$kk]);
						break;
				}
				ksort($this->TABLECFG['c']);
			}
			if (substr($cmd,0,4)=='col_')	{
				foreach ($this->TABLECFG['c'] as $cAK => $value) {
					switch($cmd)	{
						case 'col_remove':
							unset($this->TABLECFG['c'][$cAK][$kk]);
							break;
						case 'col_add':
							$this->TABLECFG['c'][$cAK][$kk+1]='';
							break;
						case 'col_start':
							$this->TABLECFG['c'][$cAK][1]=$this->TABLECFG['c'][$cAK][$kk];
							unset($this->TABLECFG['c'][$cAK][$kk]);
							break;
						case 'col_end':
							$this->TABLECFG['c'][$cAK][1000000]=$this->TABLECFG['c'][$cAK][$kk];
							unset($this->TABLECFG['c'][$cAK][$kk]);
							break;
						case 'col_left':
							$this->TABLECFG['c'][$cAK][$kk-3]=$this->TABLECFG['c'][$cAK][$kk];
							unset($this->TABLECFG['c'][$cAK][$kk]);
							break;
						case 'col_right':
							$this->TABLECFG['c'][$cAK][$kk+3]=$this->TABLECFG['c'][$cAK][$kk];
							unset($this->TABLECFG['c'][$cAK][$kk]);
							break;
					}
					ksort($this->TABLECFG['c'][$cAK]);
				}
			}
		}

		// Convert line breaks to <br /> tags:
		foreach ($this->TABLECFG['c'] as $a => $value) {
			foreach ($this->TABLECFG['c'][$a] as $b => $value2) {
				$this->TABLECFG['c'][$a][$b] = str_replace(LF,'<br />',str_replace(CR,'',$this->TABLECFG['c'][$a][$b]));
			}
		}
	}

	/**
	 * Converts the input array to a configuration code string
	 *
	 * @param	array		Array of table configuration (follows the input structure from the table wizard POST form)
	 * @return	string		The array converted into a string with line-based configuration.
	 * @see cfgString2CfgArray()
	 */
	function cfgArray2CfgString($cfgArr)	{

		// Initialize:
		$inLines=array();
		// Traverse the elements of the table wizard and transform the settings into configuration code.
		foreach ($this->TABLECFG['c'] as $a => $value) {
			$thisLine=array();
			foreach ($this->TABLECFG['c'][$a] as $b => $value) {
				$thisLine[] = $this->tableParsing_quote.str_replace($this->tableParsing_delimiter,'',$this->TABLECFG['c'][$a][$b]).$this->tableParsing_quote;
			}
			$inLines[]=implode($this->tableParsing_delimiter,$thisLine);
		}

		// Finally, implode the lines into a string:
		$bodyText = implode(LF,$inLines);

		// Return the configuration code:
		return $bodyText;
	}

	/**
	 * Converts the input configuration code string into an array
	 *
	 * @param	string		Configuration code
	 * @param	integer		Default number of columns
	 * @return	array		Configuration array
	 * @see cfgArray2CfgString()
	 */
	function cfgString2CfgArray($cfgStr,$cols)	{

		// Explode lines in the configuration code - each line is a table row.
		$tLines=explode(LF,$cfgStr);

		// Setting number of columns
		if (!$cols && trim($tLines[0]))	{	// auto...
			$cols = count(explode($this->tableParsing_delimiter,$tLines[0]));
		}
		$cols=$cols?$cols:4;

		// Traverse the number of table elements:
		$cfgArr=array();
		foreach($tLines as $k => $v)	{

			// Initialize:
			$vParts = explode($this->tableParsing_delimiter,$v);

			// Traverse columns:
			for ($a=0;$a<$cols;$a++)	{
				if ($this->tableParsing_quote && substr($vParts[$a],0,1) == $this->tableParsing_quote && substr($vParts[$a],-1,1) == $this->tableParsing_quote)	{
					$vParts[$a] = substr(trim($vParts[$a]),1,-1);
				}
				$cfgArr[$k][$a]=$vParts[$a];
			}
		}

		// Return configuration array:
		return $cfgArr;
	}
}


if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['typo3/wizard_table.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['typo3/wizard_table.php']);
}


// Make instance:
$SOBE = t3lib_div::makeInstance('wizard_table');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();

$SOBE->printContent();


?>
<head>
<link rel="stylesheet" href="" type="text/css" />
</head>
<head>
<link rel="stylesheet"
	href="<?php echo t3lib_div::getIndpEnv('TYPO3_SITE_URL');?>typo3conf/ext/pits_elearn/wizard/style.css"
	type="text/css" />
</head>