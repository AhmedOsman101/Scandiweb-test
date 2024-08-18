import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.data("homeStore", () => ({
	selected: [],

	toggleSelect(id) {
		const index = this.selected.findIndex((item) => item === id);
		// if already selected remove it
		if (index !== -1) this.selected.splice(index, 1);
		// else add it
		else this.selected.push(id);
	},
}));

Alpine.data("formStore", () => ({
	types, // passed from PHP
	type: types.DVD,
	dimensions: null,
	width: null,
	height: null,
	length: null,
	errors: {},

	validate(form) {
		const data = Object.fromEntries(new FormData(form));
		const errors = {};
		for (const [key, field] of Object.entries(data)) {
			// Empty fields validation
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

Alpine.data("flashError", () => ({
	showFlash: false,
	error, // passed from PHP,
	flashTimeout: null, // Store the timeout ID here
	// This method checks for the presence of an error and triggers the flash message display
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
