/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            colors: {
                button: {
                    DEFAULT: "rgb(64 96 104)", // Default button color
                    hover: "#628b96", // Hover state
                    active: "#1874CD", // Active state
                },
            },
        },
    },
    plugins: [],
    darkMode: "selector",
};
