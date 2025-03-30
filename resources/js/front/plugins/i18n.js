import { createI18n } from 'vue-i18n';
import messages from "./locales";

const numberFormats = {
    'uk-UA': {
        currency: {
            style: 'currency', currency: 'UAH', notation: 'standard'
        },
        decimal: {
            style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2
        },
        percent: {
            style: 'percent', useGrouping: false
        }
    },
    'en-US': {
        currency: {
            style: 'currency', currency: 'USD', notation: 'standard'
        },
        decimal: {
            style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2
        },
        percent: {
            style: 'percent', useGrouping: false
        }
    },
}

const i18n = createI18n({
    locale: window.config.locale,
    messages,
    numberFormats
});
export default i18n;
