import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.data("selectStore", () => ({
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
	types,
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

Alpine.start();
