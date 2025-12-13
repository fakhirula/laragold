import { createSystem, defaultConfig, defineConfig } from '@chakra-ui/react';

const customConfig = defineConfig({
  theme: {
    tokens: {
      colors: {
        brand: {
          50: { value: '#E6FFF2' },
          100: { value: '#B3FFD6' },
          200: { value: '#80FFB9' },
          300: { value: '#4DFF9C' },
          400: { value: '#1AFF80' },
          500: { value: '#00E666' },
          600: { value: '#00CC5C' },
          700: { value: '#00B352' },
          800: { value: '#009944' },
          900: { value: '#008038' },
        },
        dark: {
          50: { value: '#F8FAFC' },
          100: { value: '#1A1F2E' },
          200: { value: '#151A27' },
          300: { value: '#0F131E' },
          400: { value: '#0A0D15' },
          500: { value: '#05070C' },
        },
        blue: {
          400: { value: '#60A5FA' },
          500: { value: '#3B82F6' },
          600: { value: '#2563EB' },
        },
        purple: {
          500: { value: '#A855F7' },
          600: { value: '#9333EA' },
        },
        orange: {
          500: { value: '#F59E0B' },
          600: { value: '#D97706' },
        },
      },
      fonts: {
        body: { value: '"Instrument Sans", system-ui, -apple-system, sans-serif' },
        heading: { value: '"Instrument Sans", system-ui, -apple-system, sans-serif' },
      },
      fontSizes: {
        xs: { value: '0.75rem' },
        sm: { value: '0.875rem' },
        md: { value: '1rem' },
        lg: { value: '1.125rem' },
        xl: { value: '1.25rem' },
        '2xl': { value: '1.5rem' },
        '3xl': { value: '1.875rem' },
      },
      radii: {
        md: { value: '12px' },
        lg: { value: '16px' },
        xl: { value: '20px' },
        '2xl': { value: '24px' },
      },
      shadows: {
        md: { value: '0 4px 12px rgba(0, 0, 0, 0.15)' },
        lg: { value: '0 8px 24px rgba(0, 0, 0, 0.2)' },
        xl: { value: '0 12px 32px rgba(0, 0, 0, 0.25)' },
        glow: { value: '0 0 20px rgba(0, 230, 102, 0.3)' },
      },
    },
    semanticTokens: {
      colors: {
        bg: { value: { _light: '#F8FAFC', _dark: '#0A0D15' } },
        surface: { value: { _light: '#FFFFFF', _dark: '#151A27' } },
        elevated: { value: { _light: '#FFFFFF', _dark: '#1A1F2E' } },
        border: { value: { _light: '#E2E8F0', _dark: '#2D3548' } },
        text: { value: { _light: '#0F172A', _dark: '#F8FAFC' } },
        subtext: { value: { _light: '#64748B', _dark: '#94A3B8' } },
        muted: { value: { _light: '#94A3B8', _dark: '#64748B' } },
      },
    },
  },
});

export const system = createSystem(defaultConfig, customConfig);
