import { create } from 'zustand'

interface ThemeState {
  theme: 'light' | 'dark'
  setTheme: (theme: 'light' | 'dark') => void
}

export const useTheme = create<ThemeState>((set) => ({
  theme: 'light',
  setTheme: (theme) => {
    set({ theme })
    document.documentElement.classList.remove('light', 'dark')
    document.documentElement.classList.add(theme)
    localStorage.setItem('theme', theme)
  },
})) 