export const components = (theme) => ({
    '.btn-primary': {
        '@apply px-4 py-2 font-medium text-center text-white rounded transition-all bg-primary-500 hover:bg-primary-600 active:bg-primary-700 disabled:bg-primary-400': {},
    },
    '.btn-primary-outlined': {
        '@apply px-4 py-2 font-medium text-center rounded bg-white transition-all text-primary-500 border border-primary-500 hover:bg-primary-500 hover:text-white active:bg-primary-600': {}
    },
    '.btn-secondary': {
        '@apply px-4 py-2 font-medium text-center rounded transition-all bg-gray-50 hover:bg-gray-100 active:bg-gray-200 disabled:bg-gray-50/50': {},
    },
    '.btn-outlined': {
        '@apply px-4 py-2 font-medium text-center bg-white transition-all border border-gray-200 border-solid rounded text-inherit hover:bg-gray-50 active:bg-gray-100 disabled:bg-gray-50/50': {},
    },
    '.btn-ghost': {
        '@apply font-medium transition-all text-primary-500 hover:text-primary-600 active:text-primary-700 text-center': {},
    },
    '.btn-icon': {
        '@apply p-2 transition-all text-gray-500 hover:text-gray-600 active:text-gray-700 disabled:text-gray-400': {},
    },
    '.form-input-text': {
        '@apply border border-gray-100 text-gray-900 text-sm rounded focus:ring-primary-200 focus:border-primary-200 block w-full p-2.5 focus:ring-0': {},
    },
    '.form-select': {
        '@apply w-full focus:ring-primary-200 focus:border-primary-200 focus:ring-0 rounded py-0.5 border-gray-100': {},
    },
    '.form-label': {
        '@apply block mb-2 font-medium text-gray-700': {},
    },
    '.btn-google-auth': {
        '@apply px-4 py-2 bg-white border border-gray-200 rounded hover:bg-gray-50': {},
    },
    '.divider': {
        '@apply relative w-full min-h-[50px] leading-[50px] text-center': {},
        '& *': {
            '@apply relative z-[2] p-4 bg-white': {},
        },
        '&::after, &::before': {
            '@apply absolute w-full h-[1px] top-6 bg-gray-200': {},
            content: '""',
        },
        '&::before': {
            '@apply left-0': {},
        },
        '&::after': {
            '@apply right-0': {},
        },
    },
    '.link': {
        'color': theme('colors.primary.500'),
        '&:hover': {
            'color': theme('colors.primary.600'),
            'textDecorationLine': 'underline',
        }
    },
})
