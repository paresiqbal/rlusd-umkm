/**
* @type HTMLInputElement
*/
const inputTokenEmail = document.getElementById("tokenEmail")
const buttonTokenEmail = document.getElementById("tokenEmailSubmit")
const inputs = document.getElementsByClassName("inputTokenEmail");
const value = [null, null, null, null, null, null];
let nextElement = inputs[index + 1];

buttonTokenEmail.disabled = true;

for (let index = 0; index < inputs.length; index++) {
    const element = inputs[index];

    nextElement = index == 5 ? null : inputs[index + 1];

    element.addEventListener("input", handleInputToken)
}

/**
 *
 * @param {InputEvent} e
 */
function handleInputToken(e) {

    const regex = /^\d+$/;

    /**
     * @type HTMLInputElement
     */
    const element = e.target;
    const elementValue = element.value;
    const index = element.dataset.index ?? null;

    if (!regex.test(elementValue)) {
        element.value = "";
        return;
    }

    if (index) {
        value[index] = elementValue;
    }

    inputTokenEmail.value = value.join("");

    if (inputTokenEmail.value.length() >= 6) {
        buttonTokenEmail.disabled = false;
    }

    if (nextElement != null) {
        nextElement?.focus();
    }
}
