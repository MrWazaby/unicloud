import langFr from '../locale/fr';
import langEn from '../locale/en';

export default function (lang) {
  if (lang === 'en') return langEn;
  return langFr;
}
