/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ["./views/**/*.{html,view.php}"],
	theme: {
		extend: {},
	},
	plugins: [require("@tailwindcss/forms")],
};
