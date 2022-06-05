/* Flags */
import flagEn from "@/JetstreamPlus/Features/Languages/Flags/flagEn";
import flagTr from "@/JetstreamPlus/Features/Languages/Flags/flagTr";

const jpFlags = {
    flagEn: flagEn,
    flagTr: flagTr,
};

/* Languages */
const jpLanguages = [
    { id: "en", name: "English", flag: "flagEn" },
    { id: "tr", name: "Türkçe", flag: "flagTr" },
];

/*Translates*/
import enTranslates from "@/JetstreamPlus/Features/Languages/en.json";
import trTranslates from "@/JetstreamPlus/Features/Languages/tr.json";

const jpTranslates = {
    en: enTranslates,
    tr: trTranslates,
};

export {
    jpLanguages,
    jpFlags,
    jpTranslates,
};
