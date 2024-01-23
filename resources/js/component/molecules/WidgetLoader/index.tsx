import React from 'react';
import { WidgetLoaderProps } from '../../../props/props';
import BloodDonationTermine from '../../atoms/BloodDonationTermine';
import CriticalMessage from '../../atoms/CriticalMessage';
import EinsatzMelder from '../../atoms/EinsatzMelder';
import HappyHoliday from '../../atoms/HappyHoliday';
import UnwetterInfo from '../../atoms/UnwetterInfo';
import NinaAppInfo from '../../atoms/Widget/NinaAppInfo/NinaAppInfo';
import PaulinchenEVInfo from '../../atoms/Widget/PaulinchenEVInfo/PaulinchenEVInfo';
import SmokeAlarmInfo from '../../atoms/Widget/SmokeAlarmInfo/SmokeAlarmInfo';
import WidgetTermine from '../../atoms/Widget/Termine/WidgetTermine';
import GridBox from '../GridBox';

const WidgetLoader: React.FC<React.PropsWithChildren<WidgetLoaderProps>> = (
  props: WidgetLoaderProps
): JSX.Element => {
  if (typeof props.pagedata === 'undefined') {
    return <></>;
  }
  if (typeof props.data === 'undefined') {
    return <></>;
  }

  if (props.data.element === 'WidgetTicker') {
    return <></>;
  }

  if (props.data.element === 'WidgetNews') {
    return <></>;
  }

  if (props.data.element === 'WidgetPartner') {
    return <></>;
  }

  if (props.data.element === 'WidgetEinsatz') {
    if (typeof props.pagedata.data.last_emergency === 'undefined') {
      return <></>;
    }
    if (typeof props.pagedata.data.last_emergency.begin_time === 'undefined') {
      return <></>;
    }
    if (props.pagedata.data.last_emergency.begin_time === '') {
      return <></>;
    }
    return (
      <GridBox lable="Unser letzter Einsatz">
        <EinsatzMelder data={props.pagedata.data} />
      </GridBox>
    );
  }

  if (props.data.element === 'WidgetUhr') {
    return <></>;
  }

  if (props.data.element === 'WidgetTermine') {
    if (typeof props.pagedata.data.termine === 'undefined') {
      return <></>;
    }
    return (
      <GridBox lable="Unsere nächsten Termine">
        <WidgetTermine data={props.pagedata.data} />
      </GridBox>
    );
  }

  if (props.data.element === 'WidgetCopyright') {
    return <></>;
  }

  if (props.data.element === 'WidgetBirthday') {
    return <></>;
  }
  if (props.data.element === 'WidgetHoliday') {
    if (typeof props.pagedata.data.happyholiday === 'undefined') {
      return <></>;
    }
    if (props.pagedata.data.happyholiday.length === 0) {
      return <></>;
    }
    return (
      <GridBox>
        <HappyHoliday data={props.pagedata.data} />
      </GridBox>
    );
  }

  if (props.data.element === 'WidgetLogin') {
    return <></>;
  }

  if (props.data.element === 'WidgetZitat') {
    return <></>;
  }

  if (props.data.element === 'WidgetWetter') {
    return <></>;
  }

  if (props.data.element === 'WidgetNinaAppInfo') {
    return (
      <GridBox lable="Warn-App Nina">
        <NinaAppInfo />
      </GridBox>
    );
  }

  if (props.data.element === 'WidgetPaulinchenEVInfo') {
    return (
      <GridBox lable="Paulinchen e.V.">
        <PaulinchenEVInfo />
      </GridBox>
    );
  }

  if (props.data.element === 'WidgetSmokeAlarmInfo') {
    return (
      <GridBox lable="Rauchwarnmelder">
        <SmokeAlarmInfo />
      </GridBox>
    );
  }

  if (props.data.element === 'WidgetUnwetter') {
    // if (props.widget === null) {
    //   getApiWarnings();
    // }
    if (props.widget !== null) {
      if (typeof props.widget.data === 'undefined') {
        return <></>;
      }
      if (typeof props.widget.data.weather === 'undefined') {
        return <></>;
      }
      if (
        props.widget.data.weather.warnungen.length === 0 &&
        props.widget.data.weather.vorabinfo.length === 0
      ) {
        return <></>;
      }
      return (
        <GridBox lable="Wetterwarnung">
          <UnwetterInfo data={props.widget.data} />
        </GridBox>
      );
    }
    return <></>;
  }

  if (props.data.element === 'WidgetWarnung') {
    // if (props.widget === null) {
    //   getApiWarnings();
    // }
    if (props.widget !== null) {
      if (typeof props.widget.data === 'undefined') {
        return <></>;
      }
      if (typeof props.widget.data.critical === 'undefined') {
        return <></>;
      }
      if (props.widget.data.critical.length === 0) {
        return <></>;
      }
      return (
        <GridBox lable="Bevölkerungswarnung">
          <CriticalMessage data={props.widget.data} />
        </GridBox>
      );
    }
    return <></>;
  }

  if (props.data.element === 'WidgetBloodDonation') {
    if (props.widget !== null) {
      if (typeof props.widget.data === 'undefined') {
        return <></>;
      }
      if (typeof props.widget.data.blooddonation === 'undefined') {
        return <></>;
      }
      if (props.widget.data.blooddonation.length === 0) {
        return <></>;
      }
      return (
        <GridBox lable="Blutspendetermine">
          <BloodDonationTermine data={props.widget.data} />
        </GridBox>
      );
    }
    return <></>;
  }

  return <></>;
};
export default WidgetLoader;
