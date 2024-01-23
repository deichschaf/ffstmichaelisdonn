import React, { useEffect, useState } from 'react';
import { EmergencySetScenarioProps } from '../../../props/props';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import ModulEmergencyScenario from './modules/ModulEmergencyScenario';
import LoadingAlertBox from '../../../component/molecules/LoadingAlertBox';

const EmergencySetScenarioAction: React.FC<React.PropsWithChildren<EmergencySetScenarioProps>> = (
  props: EmergencySetScenarioProps
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [getEmergencys, setEmergencys] = useState<any>([]);

  useEffect(() => {
    async function getSelects() {
      let response = await fetch('/api/admin/emergency/getAllEmergencys');
      response = await response.json();
      setEmergencys(response);
      setLoading(false);
    }

    getSelects();
  }, []);

  if (loading) {
    return <LoadingAlertBox />;
  }
  return (
    <ErrorBoundary>
      {getEmergencys.emergency.map((item, idx) => (
        <ModulEmergencyScenario key={idx} data={item} emergencydata={getEmergencys} />
      ))}
    </ErrorBoundary>
  );
};
export default EmergencySetScenarioAction;
