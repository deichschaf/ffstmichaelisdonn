import React from 'react';
import { EmergencyAddEditComponentProps } from '../../props/props';
import EmergencyActionAddEditComponent from './actions/EmergencyAddEditComponent';

const EmergencyAddEditComponent: React.FC<
  React.PropsWithChildren<EmergencyAddEditComponentProps>
> = (props: EmergencyAddEditComponentProps): JSX.Element => {
  return <EmergencyActionAddEditComponent {...props} />;
};
export default EmergencyAddEditComponent;
