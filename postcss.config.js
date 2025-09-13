export default {
    plugins: {
        '@tailwindcss/postcss': {
            // Beritahu PostCSS lokasi konfigurasi Tailwind secara eksplisit
            config: './tailwind.config.js',
        },
        autoprefixer: {},
    },
};
