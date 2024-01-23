import React from 'react';
import { AppMoonProps } from '../../../props/props';

const AppMoon: React.FC<React.PropsWithChildren<AppMoonProps>> = (
  props: AppMoonProps
): JSX.Element => {
  function getIconText(moontype: number) {
    let title = '';
    let icon = '';
    switch (moontype) {
      case 0:
        title = 'Neumond';
        icon = 'Disc_Plain_black.svg';
        break;
      case 1:
      case 2:
      case 3:
      case 4:
      case 5:
      case 6:
        title = 'Zunehmender Halbmond';
        icon = 'Moon_symbol_crescent.svg';
        break;
      case 7:
        title = 'Erstes Viertel';
        icon = 'First_quarter_moon_symbol.svg';
        break;
      case 8:
      case 9:
      case 10:
      case 11:
      case 12:
      case 13:
      case 14:
        title = 'Zunehmender Mond';
        icon = 'Waxing_gibbous_moon_symbol.svg';
        break;
      case 15:
        title = 'Vollmond';
        icon = 'Cercle_noir_100.svg';
        break;
      case 16:
      case 17:
      case 18:
      case 19:
      case 20:
      case 21:
        title = 'Abnehmender Mond';
        icon = 'Waning_gibbous_moon_symbol.svg';
        break;
      case 22:
      case 23:
      case 24:
      case 25:
      case 26:
      case 27:
      case 28:
      case 29:
      case 30:
      case 31:
      case 32:
      case 33:
      case 34:
      case 35:
        title = 'Abnehmende Sichel';
        icon = 'Moon_symbol_decrescent.svg';
        break;
    }
    return {
      title: title,
      icon: icon,
    };
  }

  return <></>;
};
export default AppMoon;
