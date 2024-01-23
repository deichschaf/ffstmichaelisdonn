import React from 'react';
import { MapContainer, Marker, Polygon, Popup, TileLayer, Tooltip } from 'react-leaflet';
import L, { LatLngTuple } from 'leaflet';
import { ContentEmergencyAreaProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';

const ContentEmergencyArea: React.FC<React.PropsWithChildren<ContentEmergencyAreaProps>> = (
  props: ContentEmergencyAreaProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.emergencyarea === 'undefined') {
    return <></>;
  }
  const position = [53.96613970516836, 9.062417862415392] as LatLngTuple;

  const { stmichaelisdonn } = props.data.emergencyarea.area;
  const { ramhusen } = props.data.emergencyarea.area;

  const stmichaelisdonnOptions = { color: 'red' };
  const ramhusenOptions = { color: 'blue' };

  const fire = L.divIcon({
    html: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M288 350.1l0 1.9H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L447.3 128.1c-12.3-1-25 3-34.8 11.7c-35.4 31.6-65.6 67.7-87.3 102.8C304.3 276.5 288 314.9 288 350.1zM453.5 163.8c19.7 17.8 38.2 37 55.5 57.7c7.9-9.9 16.8-20.7 26.5-29.5c5.6-5.1 14.4-5.1 20 0c24.7 22.7 45.6 52.7 60.4 81.1c14.5 28 24.2 56.7 24.2 76.9C640 437.9 568.7 512 480 512c-89.7 0-160-74.2-160-161.9c0-26.4 12.7-58.6 32.4-90.6c20-32.4 48.1-66.1 81.4-95.8c5.6-5 14.2-5 19.8 0zM530 433c30-21 38-63 20-96c-2-4-4-8-7-12l-36 42s-58-74-62-79c-30 37-45 58-45 82c0 49 36 78 81 78c18 0 34-5 49-15z"/></svg>',
    className: 'svg_firedepartment',
    iconSize: [24, 40],
    iconAnchor: [12, 40],
  });

  const { unitstations } = props.data.emergencyarea;

  return (
    <ErrorBoundary>
      <MapContainer center={position} zoom={12} scrollWheelZoom={false} className="emergencyarea">
        <TileLayer
          attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />
        <Polygon pathOptions={stmichaelisdonnOptions} positions={stmichaelisdonn}>
          <Tooltip sticky>Sankt Michaelisdonn</Tooltip>
        </Polygon>
        <Polygon pathOptions={ramhusenOptions} positions={ramhusen}>
          <Tooltip sticky>Ramhusen</Tooltip>
        </Polygon>
        {unitstations.map((item, idx) => (
          <Marker key={idx} icon={fire} position={item.location}>
            <Tooltip sticky>{item.name}</Tooltip>
          </Marker>
        ))}
      </MapContainer>
    </ErrorBoundary>
  );
};
export default ContentEmergencyArea;
