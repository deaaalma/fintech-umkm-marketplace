import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue", // Kalau pakai Vue
        "./resources/js/**/*.jsx", // Kalau pakai React
        // 👇 TAMBAHKAN BARIS INI (Wajib buat Flowbite)
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        container: {
            center: true,
            padding: "2rem",
            screens: {
                "2xl": "1400px",
            },
        },
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                mono: ["Geist Mono", ...defaultTheme.fontFamily.mono],
            },
            colors: {
                border: "hsl(var(--border))",
                input: "hsl(var(--input))",
                ring: "hsl(var(--ring))",
                background: "hsl(var(--background))",
                foreground: "hsl(var(--foreground))",
                primary: {
                    DEFAULT: "#047857", // Emerald 700
                    foreground: "#ffffff",
                },
                secondary: {
                    DEFAULT: "#ecfdf5", // Emerald 50
                    foreground: "#065f46", // Emerald 800
                },
                destructive: {
                    DEFAULT: "hsl(var(--destructive))",
                    foreground: "hsl(var(--destructive-foreground))",
                },
                muted: {
                    DEFAULT: "#f1f5f9", // Slate 100
                    foreground: "#64748b", // Slate 500
                },
                accent: {
                    DEFAULT: "#d1fae5", // Emerald 100
                    foreground: "#065f46",
                },
                popover: {
                    DEFAULT: "hsl(var(--popover))",
                    foreground: "hsl(var(--popover-foreground))",
                },
                card: {
                    DEFAULT: "hsl(var(--card))",
                    foreground: "hsl(var(--card-foreground))",
                },
            },
            borderRadius: {
                lg: "var(--radius)",
                md: "calc(var(--radius) - 2px)",
                sm: "calc(var(--radius) - 4px)",
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        // 👇 TAMBAHKAN PLUGIN INI (Wajib buat Flowbite)
        require("flowbite/plugin"),
    ],
};
