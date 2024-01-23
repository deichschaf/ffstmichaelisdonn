import React from 'react';
import EmergencyActionAddEditComponent from '../../../acp/emergency/actions/EmergencyAddEditComponent';
import { EmergencyAddEditComponentProps } from '../../../props/props';

const AppEinsaetzeEditorAddEdit: React.FC<
  React.PropsWithChildren<EmergencyAddEditComponentProps>
> = (props: EmergencyAddEditComponentProps): JSX.Element => {
  return <EmergencyActionAddEditComponent {...props} />;
};
export default AppEinsaetzeEditorAddEdit;
