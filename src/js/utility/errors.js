{
  const init = () => {
    const inputs = document.querySelectorAll(`.input_error`);
    inputs.forEach(($input) => {
      $input.addEventListener(`blur`, handleBlurInput);
      $input.addEventListener(`input`, handleInputField);
    });
  };

  const handleBlurInput = (e) => {
    showValidationInfo(e.currentTarget);
  };

  const showValidationInfo = ($input) => {
    // selecteren van het error veld bij elk element
    const $error = $input.parentElement.parentElement.querySelector(".error");

    // controle of het veld ingevuld is
    if ($input.validity.valueMissing) {
      $error.textContent = ` - gelieve iets in te vullen`;
    }
    // controle of input matcht met type attribute
    if ($input.validity.typeMismatch) {
      $error.textContent = `A ${showTypeMismatch(
        $input.getAttribute(`type`)
      )} is expected`;
    }
    // controle of de maximale lengte niet overschreden is
    if ($input.validity.tooLong) {
      $error.textContent = `Input mag maximum ${$input.getAttribute(
        `maxlength`
      )} karakters bevatten`;
    }
    // controle of de minimale lengte wel gehaald werd
    if ($input.validity.tooShort) {
      $error.textContent = `Input mag maximum ${$input.getAttribute(
        `minlength`
      )} karakters bevatten`;
    }
    // controle of de input groter of gelijk is aan de kleinst mogelijke waarde
    if ($input.validity.rangeUnderflow) {
      $error.textContent = `De waarde moet groter dan of gelijk zijn aan ${$input.getAttribute(
        `min`
      )}`;
    }
    // controle of de input kleiner of gelijk is aan de grootst mogelijke waarde
    if ($input.validity.rangeOverflow) {
      $error.textContent = `De waarde moet kleiner dan of gelijk zijn aan ${$input.getAttribute(
        `max`
      )}`;
    }
  };

  const handleInputField = (e) => {
    const $input = e.currentTarget;
    const $error = $input.parentElement.querySelector(`.error`);
    if ($input.checkValidity()) {
      $error.textContent = ``;
    }
  };

  init();
}
