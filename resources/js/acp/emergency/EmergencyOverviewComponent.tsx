import React from 'react';
import { EmergencyOverviewComponentProps } from '../../props/props';
import EmergencyActionOverviewComponent from './actions/EmergencyOverviewComponent';

const EmergencyOverviewComponent: React.FC<
  React.PropsWithChildren<EmergencyOverviewComponentProps>
> = (props: EmergencyOverviewComponentProps): JSX.Element => {
  return <EmergencyActionOverviewComponent {...props} />;
};
export default EmergencyOverviewComponent;
