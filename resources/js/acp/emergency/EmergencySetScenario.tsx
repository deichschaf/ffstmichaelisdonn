import React from 'react';
import { EmergencySetScenarioProps } from '../../props/props';
import EmergencySetScenarioAction from './actions/EmergencySetScenarioAction';

const EmergencySetScenario: React.FC<React.PropsWithChildren<EmergencySetScenarioProps>> = (
  props: EmergencySetScenarioProps
): JSX.Element => {
  return <EmergencySetScenarioAction {...props} />;
};
export default EmergencySetScenario;
