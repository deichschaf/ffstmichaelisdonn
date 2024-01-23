import React from 'react';
import { StatusInActiveProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const StatusInActive: React.FC<React.PropsWithChildren<StatusInActiveProps>> = (
  props: StatusInActiveProps,
): JSX.Element => (
  <ErrorBoundary>
    {props.status === '0' || props.status === false ? <>im Dienst</> : <>außer Dienst</>}
  </ErrorBoundary>
);
export default StatusInActive;
