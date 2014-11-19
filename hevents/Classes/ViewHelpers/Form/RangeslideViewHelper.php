<?php

/**
 * @api
 */
class Tx_Hevents_ViewHelpers_Form_RangeslideViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Renders the field.
	 *
	 * @param string $minFieldId
	 * @param string $maxFieldId
	 * @param string $minValue
	 * @param string $maxValue
	 * @param string $minInfoId
	 * @param string $maxInfoId
	 * @param string $formSubmitId
	 * @return string
	 * @api
	 */
	public function render($minFieldId , $maxFieldId , $minValue = 0, $maxValue = 100000, $minInfoId='', $maxInfoId='', $formSubmitId='') {
		$tag = '<div id="sr-'.$minFieldId.'-'.$maxFieldId.'"></div>';
		
		$script = '
			<script type="text/javascript">
				$(document).ready(function(){
					$("#sr-'.$minFieldId.'-'.$maxFieldId.'" ).slider({
						range: true,
						min: '.$minValue.',
						max: '.$maxValue.',
						values: [$("#'.$minFieldId.'").val(), $("#'.$maxFieldId.'").val()],
						slide: function(event, ui) {
							$("#'.$minFieldId.'").val(ui.values[0]);
							$("#'.$maxFieldId.'").val(ui.values[1]);
							$("#'.$minInfoId.'").text(ui.values[0]);
							$("#'.$maxInfoId.'").text(ui.values[1]);
						},
						change: function(event, ui) {
							'.(empty($formSubmitId) ? '' : '$("#'.$formSubmitId.'").submit()').'
						}
					});
					$("#'.$minInfoId.'").text($("#'.$minFieldId.'").val());
					$("#'.$maxInfoId.'").text($("#'.$maxFieldId.'").val());
				});	
			</script>
		';
		
		return $tag.$script;
	}

}

?>