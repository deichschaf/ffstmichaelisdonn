import React from 'react';
import { SVGIconProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import SignDanger from '../../svgs/achtung.svg';
import AlarmSign from '../../svgs/alarm_sign.svg';
import AlarmSignOn from '../../svgs/alarm_sign_active.svg';
import AlarmSignOff from '../../svgs/alarm_sign_deactive.svg';
import AlarmClock from '../../svgs/alarm-clock.svg';
import ArrowUp from '../../svgs/arrow-up.svg';
import AppleStore from '../../svgs/available_on_the_App_Store_(black)_SVG.svg';
import Bundle from '../../svgs/bundle.svg';
import Burger from '../../svgs/burger.svg';
import Calendar from '../../svgs/calendar.svg';
import Cart from '../../svgs/cart.svg';
import Chef from '../../svgs/chef.svg';
import SignExplosition from '../../svgs/explosion.svg';
import Fax from '../../svgs/fax-solid.svg';
import SignFire from '../../svgs/feuer.svg';
import SignFireRescueHelpGuard from '../../svgs/feuerwehr-loschen-bergen-retten-seeklogo.com.svg';
import FlorianDithmarschen from '../../svgs/florian_dithmarschen.svg';
import FirePositonWaistcoatBlue from '../../svgs/funktionsweste_blau.svg';
import FirePositonWaistcoatYellow from '../../svgs/funktionsweste_gelb.svg';
import FirePositonWaistcoatGreen from '../../svgs/funktionsweste_gruen.svg';
import FirePositonWaistcoatOrange from '../../svgs/funktionsweste_reinorange.svg';
import FirePositonWaistcoatRed from '../../svgs/funktionsweste_rot.svg';
import FirePositonWaistcoatViolett from '../../svgs/funktionsweste_violett.svg';
import FirePositonWaistcoatWhite from '../../svgs/funktionsweste_weiss.svg';
import FirePositonWaistcoatWhite2 from '../../svgs/funktionsweste_weiss2.svg';
import SignToxic from '../../svgs/giftig.svg';
import GoogleStore from '../../svgs/google-play-store-badge-de.svg';
import Handy from '../../svgs/handy.svg';
import Knife from '../../svgs/knife.svg';
import Loader from '../../svgs/loader.svg';
import LoaderLight from '../../svgs/loader-light.svg';
import SignEuropeNumber from '../../svgs/logo-notruf-112-europaweit.svg';
import Map from '../../svgs/map-location-dot-solid.svg';
import NinaBBK from '../../svgs/nina-logo-eps.svg';
import SignRescueNumber from '../../svgs/notruf.svg';
import PaulinchenEV from '../../svgs/PaulinchenEV.svg';
import PeperHot from '../../svgs/pepper-hot.svg';
import PriceTag from '../../svgs/pricetag.svg';
import SignRadioActive from '../../svgs/radioaktiv.svg';
import SignRadioActive2 from '../../svgs/radioaktiv2.svg';
import SmokeAlarm from '../../svgs/rauchmelder_retten_leben.svg';
import Ribbon from '../../svgs/ribbon.svg';
import RLBS from '../../svgs/rlbs.svg';
import SignStreetDanger from '../../svgs/schleudergefahr.svg';
import NationalWarnSign from '../../svgs/schutzzeichen.svg';
import NationalWarnSignCancel from '../../svgs/schutzzeichen_cancel.svg';
import SignStorm from '../../svgs/sturm.svg';
import SwissphoneResQ from '../../svgs/swissphone_res.q.svg';
import TimeReminder from '../../svgs/time-reminder-icon.svg';
import Truck from '../../svgs/truck.svg';
import WalkieTalkie from '../../svgs/walkie-talkie-solid.svg';
import Wifi from '../../svgs/wifi.svg';
import PictureSourcSet from '../Picture/SourceSet';

const SVGIcon: React.FC<React.PropsWithChildren<SVGIconProps>> = (
  props: SVGIconProps,
): JSX.Element => {
  function getSVG(svg) {
    switch (svg) {
      case 'SignDanger':
        return SignDanger;
      case 'ArrowUp':
        return ArrowUp;
      case 'SignStreetDanger':
        return SignStreetDanger;
      case 'Truck':
        return Truck;
      case 'SignStorm':
        return SignStorm;
      case 'RLBS':
        return RLBS;
      case 'SignRadioActive2':
        return SignRadioActive2;
      case 'Cart':
        return Cart;
      case 'Ribbon':
        return Ribbon;
      case 'Chef':
        return Chef;
      case 'WalkieTalkie':
        return WalkieTalkie;
      case 'Wifi':
        return Wifi;
      case 'Burger':
        return Burger;
      case 'Bundle':
        return Bundle;
      case 'NationalWarnSign':
        return NationalWarnSign;
      case 'NationalWarnSignCancel':
        return NationalWarnSignCancel;
      case 'SignExplosition':
        return SignExplosition;
      case 'SignFire':
        return SignFire;
      case 'SignToxic':
        return SignToxic;
      case 'FlorianDithmarschen':
        return FlorianDithmarschen;
      case 'FirePositonWaistcoatViolett':
        return FirePositonWaistcoatViolett;
      case 'FirePositonWaistcoatWhite':
        return FirePositonWaistcoatWhite;
      case 'Knife':
        return Knife;
      case 'Handy':
        return Handy;
      case 'Loader':
        return Loader;
      case 'LoaderLight':
        return LoaderLight;
      case 'FirePositonWaistcoatOrange':
        return FirePositonWaistcoatOrange;
      case 'FirePositonWaistcoatRed':
        return FirePositonWaistcoatRed;
      case 'FirePositonWaistcoatWhite2':
        return FirePositonWaistcoatWhite2;
      case 'FirePositonWaistcoatYellow':
        return FirePositonWaistcoatYellow;
      case 'FirePositonWaistcoatGreen':
        return FirePositonWaistcoatGreen;
      case 'FirePositonWaistcoatBlue':
        return FirePositonWaistcoatBlue;
      case 'PriceTag':
        return PriceTag;
      case 'SignRadioActive':
        return SignRadioActive;
      case 'SignEuropeNumber':
        return SignEuropeNumber;
      case 'SignFireRescueHelpGuard':
        return SignFireRescueHelpGuard;
      case 'SignRescueNumber':
        return SignRescueNumber;
      case 'PeperHot':
        return PeperHot;
      case 'SwissphoneResQ':
        return SwissphoneResQ;
      case 'AlarmClock':
        return AlarmClock;
      case 'AlarmSign':
        return AlarmSign;
      case 'AlarmSignOn':
        return AlarmSignOn;
      case 'AlarmSignOff':
        return AlarmSignOff;
      case 'TimeReminder':
        return TimeReminder;
      case 'Calendar':
        return Calendar;
      case 'Map':
        return Map;
      case 'Fax':
        return Fax;
      case 'NinaBBK':
        return NinaBBK;
      case 'AppleStore':
        return AppleStore;
      case 'GoogleStore':
        return GoogleStore;
      case 'SmokeAlarm':
        return SmokeAlarm;
      case 'PaulinchenEV':
        return PaulinchenEV;
      default:
        return '';
    }
  }

  return (
    <ErrorBoundary>
      <PictureSourcSet
        img={getSVG(props.svg)}
        title={props.title}
        alt={props.alt}
        className={props.className}
      />
    </ErrorBoundary>
  );
};
export default SVGIcon;
