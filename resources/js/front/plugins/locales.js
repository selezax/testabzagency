import _localesTestImgApiUk from '~/../../packages/TestImgApi/resources/lang/uk.json';
import _localesTestImgApiEn from '~/../../packages/TestImgApi/resources/lang/en.json';


const _localesUk = {
    uk: {
        ..._localesTestImgApiUk
    }
};

const _localesEn = {
    en: {
        ..._localesTestImgApiEn
    }
};

const locales = Object.assign({}, _localesEn, _localesUk);

export default locales;
