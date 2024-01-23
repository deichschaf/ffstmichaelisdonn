import React from 'react';
import { ContentVehicleProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';
import VehicleOverviewList from './components/VehicleOverviewList';

const ContentVehicle: React.FC<React.PropsWithChildren<ContentVehicleProps>> = (
  props: ContentVehicleProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.verhicles === 'undefined') {
    return <></>;
  }
  const vehicle = props.data.verhicles;
  return (
    <ErrorBoundary>
      {vehicle.active.length > 0 ? (
        <VehicleOverviewList title="Aktuelle Einsatzfahrzeuge" data={vehicle.active} />
      ) : (
        <></>
      )}
      {vehicle.deactive.length > 0 ? (
        <VehicleOverviewList title="Ehemalige Einsatzfahrzeuge" data={vehicle.deactive} />
      ) : (
        <></>
      )}
    </ErrorBoundary>
  );
};
export default ContentVehicle;
