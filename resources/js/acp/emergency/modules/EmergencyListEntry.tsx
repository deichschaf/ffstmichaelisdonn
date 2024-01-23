import React from 'react';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { EmergencyListEntryProps } from '../../../props/props';
import { checkValueType } from './helper';

const EmergencyListEntry: React.FC<React.PropsWithChildren<EmergencyListEntryProps>> = (
  props: EmergencyListEntryProps,
): JSX.Element => (
  <ErrorBoundary key={`${props.count}-${props.idx}`}>
    <li>{checkValueType(props.value, `${props.count}-${props.count}`) as any}</li>
  </ErrorBoundary>
);
export default EmergencyListEntry;
