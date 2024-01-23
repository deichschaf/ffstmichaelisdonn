import React, { useEffect, useState } from 'react';
import { FiretruckOverviewProps } from '../../../props/props';
import H1 from '../../atoms/Typography/H1';
import LoadingAlertBox from '../../molecules/LoadingAlertBox';
import FireTruckOverviewComponent from '../../organisms/FireTruckOverviewComponent';

const FireTruckOverview: React.FC<React.PropsWithChildren<FiretruckOverviewProps>> = (
  props: FiretruckOverviewProps,
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);

  useEffect(() => {
    async function fetchMyApi() {
      const response = await fetch('/api/get/fahrzeuge/overview');

      if (!response.ok) {
        window.location.reload();
      } else {
        setAppState(response.json());
        setLoading(false);
      }
    }

    fetchMyApi();
  }, []);

  if (loading || appState === null) {
    return <LoadingAlertBox />;
  }
  return (
    <>
      {appState.fahrzeuge.map((item, idx) => (
        <FireTruckOverviewComponent data={item.fahrzeug} image={item.image} />
      ))}
      {appState.ehemalige_fahrzeuge !== '' ? (
        <>
          <H1 label="Ehemalige Fahrzeuge" />
          {appState.ehemalige_fahrzeuge.map((item, idx) => (
            <FireTruckOverviewComponent data={item.fahrzeug} image={item.image} />
          ))}
        </>
      ) : (
        ''
      )}
    </>
  );
};
export default FireTruckOverview;
