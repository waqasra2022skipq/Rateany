/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#fefce8",
                    100: "#fef9c3",
                    200: "#fef08a",
                    300: "#fde047",
                    400: "#facc15",
                    500: "#eab308",
                    600: "#ca8a04",
                    700: "#a16207",
                    800: "#854d0e",
                    900: "#713f12",
                    950: "#422006",
                },
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
    fontFamily: {
        body: [
            "Inter",
            "ui-sans-serif",
            "system-ui",
            "-apple-system",
            "system-ui",
            "Segoe UI",
            "Roboto",
            "Helvetica Neue",
            "Arial",
            "Noto Sans",
            "sans-serif",
            "Apple Color Emoji",
            "Segoe UI Emoji",
            "Segoe UI Symbol",
            "Noto Color Emoji",
        ],
        sans: [
            "Inter",
            "ui-sans-serif",
            "system-ui",
            "-apple-system",
            "system-ui",
            "Segoe UI",
            "Roboto",
            "Helvetica Neue",
            "Arial",
            "Noto Sans",
            "sans-serif",
            "Apple Color Emoji",
            "Segoe UI Emoji",
            "Segoe UI Symbol",
            "Noto Color Emoji",
        ],
    },
};
