/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/js/**/*.{vue,js,ts,jsx,tsx}",
    ],
    theme: {
        screens: {
            sm: '576px',
            md: '768px',
            lg: '992px',
            xl: '1200px',
            xxl: '1400px',
        },
        colors: {
            'primary': {
                '50': '#f0f0f5',
                '100': '#d3d1e1',
                '200': '#b5b2cc',
                '300': '#9794b8',
                '400': '#7a75a4',
                '500': '#605b8a',
                '600': '#4b476b',
                '700': '#36334d',
                '800': '#201e2e',
                '900': '#0b0a0f',
            },
            'second': {
                '50': '#F5E0FF',
                '100': '#EDC7FF',
                '200': '#E4ADFF',
                '300': '#D18DF2',
                '400': '#B468D9',
                '500': '#9949BF',
                '600': '#7F2EA6',
                '700': '#67198C',
                '800': '#500973',
                '900': '#3C0059',
            },
            'tertiary': {
                '100': '#FFF0E3',
                '200': '#FFE3C9',
                '300': '#FFD5B0',
                '400': '#FFC896',
                '500': '#FFBA7D',
                '600': '#FFAC63',
                '700': '#FF9F4A',
                '800': '#ED872D',
                '900': '#8C4D16',
            },
            'success': {
                '50': '#DEFFF3',
                '100': '#C4FFE9',
                '200': '#ABFFE0',
                '300': '#91FFD7',
                '400': '#6CE6B9',
                '500': '#4BCC9D',
                '600': '#31B383',
                '700': '#1A996A',
                '800': '#098054',
                '900': '#006640',
            },
            'warning': {
                '50': '#FFF3BA',
                '100': '#FFEFA1',
                '200': '#FFEB87',
                '300': '#FFE66E',
                '400': '#FFE254',
                '500': '#FFDE3B',
                '600': '#FFD921',
                '700': '#E6C007',
                '800': '#CCA900',
                '900': 'B39400',
            },
            'error': {
                '50': '#FFC4C4',
                '100': '#FFABAB',
                '200': '#FF9191',
                '300': '#FF7878',
                '400': '#F55B5B',
                '500': '#DB3B3B',
                '600': '#C22121',
                '700': '#A80C0C',
                '800': '#8F0000',
                '900': '750000',
            },
            'gray': {
                '50': '#FFFFFF',
                '100': '#EFF0F2',
                '200': '#E1E2E6',
                '300': '#ADAFB3',
                '400': '#939599',
                '500': '#797B80',
                '600': '#606266',
                '700': '#47494D',
                '800': '#2F3033',
                '900': '000000',
            },
        },
        fontFamily: {},
        extend: {
            width: {},
            spacing: {
                'xxs': '4px',
                'xs': '8px',
                's': '16px',
                'm': '24px',
                'l': '48px',
                'xl': '96px',
            },
            fontSize: {}
        }
    },
    plugins: [],
}
