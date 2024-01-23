import React from 'react';
import { MapContainer, Marker } from 'react-leaflet';
import { LatLngTuple } from 'leaflet';
import { EmergencyAreaMapProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const EmergencyAreaMap: React.FC<React.PropsWithChildren<EmergencyAreaMapProps>> = (
  props: EmergencyAreaMapProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.emergencyarea === 'undefined') {
    return <></>;
  }
  const position = [53.96613970516836, 9.062417862415392] as LatLngTuple;

  return (
    <ErrorBoundary>
      <MapContainer center={position} zoom={13} scrollWheelZoom={false}>
        <Marker position={position} />
      </MapContainer>
    </ErrorBoundary>
  );
};

export default EmergencyAreaMap;
