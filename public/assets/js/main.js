import Alpine from "alpinejs";

window.Alpine = Alpine;

/**
 * Alpine.js store for managing selected items.
 *
 * @typedef {Object} HomeStore
 * @property {number[]} selected - Array of selected item IDs.
 * @method toggleSelect(id) - Toggles the selection state of an item by its ID.
 */
Alpine.data("homeStore", () => ({
  selected: [],

  /**
   * Toggles the selection state of an item by its ID.
   * If the item is already selected, it will be removed from the selection.
   * If the item is not selected, it will be added to the selection.
   *
   * @param {number} id - The ID of the item to toggle.
   * @return {void}
   */
  toggleSelect(id) {
    const index = this.selected.findIndex((item) => item === id);
    // if already selected remove it
    if (index !== -1) this.selected.splice(index, 1);

    else this.selected.push(id);
  },
}));

/**
 * Alpine.js store for managing form data and validation.
 *
 * @typedef {Object} FormStore
 * @property {Object} types - Types passed from PHP.
 * @property {string} type - The current selected type.
 * @property {number|null} dimensions - Dimensions value (or null if not set).
 * @property {number|null} width - Width value (or null if not set).
 * @property {number|null} height - Height value (or null if not set).
 * @property {number|null} length - Length value (or null if not set).
 * @property {Object} errors - Validation errors.
 * @method validate(form) - Validates the form fields and returns an object with validity status, errors, and data.
 * @method submit(form) - Submits the form data and handles the response.
 */
Alpine.data("formStore", () => ({
  types, // passed from PHP
  type: types.DVD,
  dimensions: null,
  width: null,
  height: null,
  length: null,
  errors: {},

  /**
   * Validates the form fields.
   * Checks for empty fields and collects errors if any.
   *
   * @param {HTMLFormElement} form - The form element to validate.
   * @return {Object} - An object containing `isValid`, `errors`, and `data`.
   */
  validate(form) {
    const data = Object.fromEntries(new FormData(form));
    const errors = {};
    for (const [key, field] of Object.entries(data)) {
      if (!field.trim()) {
        errors[key] = `${key} field is required`;
      }
    }
    const isValid = Object.keys(errors).length === 0;
    return {
      isValid,
      errors,
      data,
    };
  },

  /**
   * Submits the form data and handles the response.
   *
   * @param {HTMLFormElement} form - The form element to submit.
   * @return {void}
   */
  async submit(form) {
    const { isValid, errors, data } = this.validate(form);
    if (isValid) {
      const request = await fetch(form.action, {
        method: form.method,
        body: JSON.stringify(data),
        headers: {
          "Content-Type": "application/json",
        },
      });
      const response = await request.json();
      if (request.ok) {
        redirectToHome();
      }
      this.errors = response.errors;
    } else this.errors = errors;
  },
}));

/**
 * Alpine.js store for managing flash error messages.
 *
 * @typedef {Object} FlashErrorStore
 * @property {boolean} showFlash - Whether to show the flash message or not.
 * @property {string} error - The error message passed from PHP.
 * @property {number|null} flashTimeout - The timeout ID for hiding the flash message.
 * @method showFlashMessage() - Displays the flash message with a 1ms delay for smoother transition.
 * @method toggleFlash() - Toggles the visibility of the flash message and clears the timeout if manually closed.
 */
Alpine.data("flashError", () => ({
  showFlash: false,
  error, // passed from PHP,
  flashTimeout: null, // Holds the timeout ID here

  /**
   * Displays the flash message.
   *
   * This method checks for the presence of an error and triggers the flash message display
   *
   * @return {void}
   */
  showFlashMessage() {
    if (this.error) {
      /*
            ? Added a delay of 1ms before setting 'showFlash' to true.
            ? This delay allows the code to mimic the behavior of a value change on the client side,
            ? rather than immediately applying a value that was already true from the server response.
            ? Without this delay, the flash message would pop up abruptly, skipping the intended transition effect.
            */
      setTimeout(() => (this.showFlash = true), 1); // Show after 1ms

      // Set the timeout to automatically hide the flash message after 3.5 seconds
      this.flashTimeout = setTimeout(() => this.toggleFlash(), 3500);
    }
  },

  /**
   * Toggles the visibility of the flash message and clears the timeout if manually closed.
   *
   * @return {void}
   */
  toggleFlash() {
    // If the flash message is manually closed, clear the timeout
    if (this.showFlash && this.flashTimeout) {
      clearTimeout(this.flashTimeout);
      this.flashTimeout = null;
    }

    this.showFlash = !this.showFlash;
  },
}));

Alpine.start();
