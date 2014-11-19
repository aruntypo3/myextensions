<?php

/**
 * @api
 */
class Tx_Hevents_ViewHelpers_Form_DatepickerViewHelper extends Tx_Fluid_ViewHelpers_Form_AbstractFormFieldViewHelper {

	
	/**
	 * @var string
	 */
	protected $tagName = 'input';

	/**
	 * Initialize the arguments.
	 *
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
		$this->registerTagAttribute('maxlength', 'int', 'The maxlength attribute of the input field (will not be validated)');
		$this->registerTagAttribute('readonly', 'string', 'The readonly attribute of the input field');
		$this->registerTagAttribute('size', 'int', 'The size of the input field');
		$this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', FALSE, 'f3-form-error');
		$this->registerUniversalTagAttributes();
	}

	/**
	 * Renders the textfield.
	 *
	 * @param boolean $required If the field is required or not
	 * @param string $type The field type, e.g. "text", "email", "url" etc.
	 * @param string $placeholder A string used as a placeholder for the value to enter
	 * @param string $img
	 * @param string $alt
	 * @return string
	 * @api
	 */
	public function render($required = NULL, $type = 'text', $placeholder = NULL, $img = '', $alt='...') {
		$name = $this->getName();
		$this->registerFieldNameForFormTokenGeneration($name);

		$this->tag->addAttribute('type', $type);
		$this->tag->addAttribute('name', $name);

		$value = $this->getValue();

		if ($placeholder !== NULL) {
			$this->tag->addAttribute('placeholder', $placeholder);
		}

		if ($value !== NULL) {
			$this->tag->addAttribute('value', $value);
		}

		if ($required !== NULL) {
			$this->tag->addAttribute('required', 'required');
		}
		
		$this->setErrorClassAttribute();
		
		$script = '
			<script type="text/javascript">
				//$.datepicker.setDefaults($.datepicker.regional["de"]);
				$("input[name=\''.$name.'\']").datepicker({
					showOn: "button",
					buttonImage: "'.$img.'",
					buttonImageOnly: true,
					buttonText: "'.$alt.'",
					changeMonth: true,
					changeYear: true
				});
			</script>
		';
		
		return $this->tag->render().$script;
	}

}

?>