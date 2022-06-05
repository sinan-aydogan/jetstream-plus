import {jpFlags, jpLanguages, jpTranslates} from '@/JetstreamPlus/Features/Languages/languages'

/* Flags */
/* import flagBg from '@Languages/Flags/flagBg' */
const flags = {
    ...jpFlags,
    /*flagBg: flagBg*/
}

/* Languages */
const languages = jpLanguages.concat(
    /*{ id: "bg", name: "български", flag: "flagBg" }*/
);

/* Translates */

import enTranslates from '@/Languages/en.json';
import trTranslates from '@/Languages/tr.json';
/* import bgTranslates from '@/Languages/bg.json */

const translates = {
    en: {
        ...jpTranslates.en,
        ...enTranslates
    },
    tr: {
        ...jpTranslates.tr,
        ...trTranslates
    },
    /*bg: {
        ...jpTranslates.bg,
        ...bgTranslates
    }*/
}

export {flags, languages, translates}
