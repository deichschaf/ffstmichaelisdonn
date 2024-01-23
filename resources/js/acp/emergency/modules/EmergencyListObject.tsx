import React from 'react';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { EmergencyListProps } from '../../../props/props';
import { buildLi, generateRandomNumber } from './helper';

const EmergencyListArray: React.FC<React.PropsWithChildren<EmergencyListProps>> = (
  props: EmergencyListProps,
): JSX.Element => (
  <ErrorBoundary key={`${generateRandomNumber()}-${props.count}`}>
    <ul>{Object.values(props.value).map((item, idx) => buildLi(item, idx, props.count))}</ul>
  </ErrorBoundary>
);
export default EmergencyListArray;
