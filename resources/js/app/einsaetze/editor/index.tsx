import React from 'react';
import { EmergencyOverviewComponentProps } from '../../../props/props';
import EmergencyActionOverviewComponent from '../../../acp/emergency/actions/EmergencyOverviewComponent';

const AppEinsaetzeEditorOverview: React.FC<
  React.PropsWithChildren<EmergencyOverviewComponentProps>
> = (props: EmergencyOverviewComponentProps): JSX.Element => {
  return <EmergencyActionOverviewComponent {...props} />;
};
export default AppEinsaetzeEditorOverview;
