import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { useTheme } from './hooks/use-theme';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Initialize theme
const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | null;
if (savedTheme) {
    document.documentElement.classList.add(savedTheme);
} else {
    document.documentElement.classList.add('light');
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});
