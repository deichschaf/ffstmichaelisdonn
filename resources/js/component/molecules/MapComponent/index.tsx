import React from 'react';
import { MapContainer, Marker, Popup, TileLayer } from 'react-leaflet';
import Leaflet, { LatLngTuple } from 'leaflet';
import { MapProps } from '../../../props/props';

Leaflet.Icon.Default.imagePath = '~leaflet';

// delete Leaflet.Icon.Default.prototype._getIconUrl;

Leaflet.Icon.Default.mergeOptions({
  // eslint-disable-next-line global-require
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  // eslint-disable-next-line global-require
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  // eslint-disable-next-line global-require
  shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

const MapComponent: React.FC<React.PropsWithChildren<MapProps>> = (
  props: MapProps,
): JSX.Element => {
  if (typeof props.lat === 'undefined' || typeof props.lon === 'undefined') {
    return <></>;
  }
  if (props.lat === null || props.lon === null) {
    return <></>;
  }
  const position = [props.lat, props.lon] as LatLngTuple;

  return (
    <MapContainer center={position} zoom={13} scrollWheelZoom={false}>
      <TileLayer
        attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
      />
      <Marker position={position}>
        <Popup>
          A pretty CSS3 popup. <br /> Easily customizable.
        </Popup>
      </Marker>
    </MapContainer>
  );
};
export default MapComponent;
