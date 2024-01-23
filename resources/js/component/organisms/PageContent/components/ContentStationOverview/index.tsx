import React from 'react';
import { ContentVehicleProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';
import OrganisationStation from './components/OrganisationStation';

const ContentVehicle: React.FC<React.PropsWithChildren<ContentVehicleProps>> = (
  props: ContentVehicleProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.vehicle_database === 'undefined') {
    return <></>;
  }
  if (typeof props.data.hiorgs === 'undefined') {
    return <></>;
  }
  const { vehicle_database } = props.data;
  const { hiorgs } = props.data;
  return (
    <ErrorBoundary>
      {hiorgs.map((item, idx) => (
        <OrganisationStation
          key={idx}
          organisation={item.hiorg}
          stations={vehicle_database[item.id]}
        />
      ))}
    </ErrorBoundary>
  );
};
export default ContentVehicle;
