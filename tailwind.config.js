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
                    DEFAULT: "#0078b7", // Requested blue
                    foreground: "#ffffff",
                },
                secondary: {
                    DEFAULT: "#f0f9ff", // Sky 50
                    foreground: "#003d5c", // Dark blue for contrast
                },
                destructive: {
                    DEFAULT: "hsl(var(--destructive))",
                    foreground: "hsl(var(--destructive-foreground))",
                },
                muted: {
                    DEFAULT: "#f8fafc", // Slate 50
                    foreground: "#64748b", // Slate 500
                },
                accent: {
                    DEFAULT: "#e0f2fe", // Sky 100
                    foreground: "#0369a1", // Sky 700
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
