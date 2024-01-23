import React from 'react';
import { FiretruckOverviewDataProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const FireTruckOverviewData: React.FC<React.PropsWithChildren<FiretruckOverviewDataProps>> = (
  props: FiretruckOverviewDataProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.id === 'undefined') {
    return <></>;
  }

  function getBosName(props) {
    if (typeof props.data.bos_kennung === 'undefined') {
      return <></>;
    }
    if (props.data.bos_kennung === null || props.data.bos_kennung === '') {
      return <></>;
    }
    return <br /> + props.data.bos_kennung;
  }

  function getActivatedDate(props) {
    if (typeof props.data.zugelassen === 'undefined') {
      return <></>;
    }
    if (props.data.zugelassen === null || props.data.zugelassen === '') {
      return <></>;
    }
    return <br /> + props.data.zugelassen;
  }

  function getNumberPlate(props) {
    if (typeof props.data.kennzeichen === 'undefined') {
      return <></>;
    }
    if (props.data.kennzeichen === null || props.data.kennzeichen === '') {
      return <></>;
    }
    return <br /> + props.data.kennzeichen;
  }

  return (
    <ErrorBoundary>
      {props.data.fahrzeug}
      <br />
      {props.data.fahrgestell}
      {getBosName(props)}
      {getActivatedDate(props)}
      {getNumberPlate(props)}
    </ErrorBoundary>
  );
};
export default FireTruckOverviewData;
