import React from 'react';
import { BuildEmergencyMonthsProps } from '../../../../../../props/props';
import ErrorBoundary from '../../../../errorboundary';
import BuildEmergencyMonth from './BuildEmergencyMonth';

const BuildEmergencyMonths: React.FC<React.PropsWithChildren<BuildEmergencyMonthsProps>> = (
  props: BuildEmergencyMonthsProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const keys = Object.keys(props.data);
  keys.sort(
    (a, b) =>
      // @ts-ignore
      b - a,
  );
  const rows = [] as any;
  // eslint-disable-next-line no-plusplus
  for (let i = 0; i < keys.length; i++) {
    rows.push(
      <BuildEmergencyMonth year={props.year} month={keys[i]} key={i} data={props.data[keys[i]]} />,
    );
  }

  return <ErrorBoundary>{rows}</ErrorBoundary>;
};
export default BuildEmergencyMonths;
