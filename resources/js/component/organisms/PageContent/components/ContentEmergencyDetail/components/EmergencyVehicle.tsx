import React from 'react';
import Globalvars from '../../../../../../globalvars';
import { EmergencyVehicleProps } from '../../../../../../props/props';
import PictureSourcSet from '../../../../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../../../errorboundary';
import { Link } from 'react-router-dom';

const EmergencyVehicle: React.FC<React.PropsWithChildren<EmergencyVehicleProps>> = (
  props: EmergencyVehicleProps
): JSX.Element => {
  const link = '/fahrzeuge/';
  return (
    <ErrorBoundary>
      <Link to={link + props.id}>
        <PictureSourcSet
          className="picture"
          img={props.img}
          path={Globalvars.getFilePath() + '/fahrzeuge/'}
          images={props.images}
        />
      </Link>
      {typeof props.bos_kennung !== 'undefined' &&
      props.bos_kennung !== '' &&
      props.bos_kennung !== null ? (
        <div>
          <Link to={link + props.id}>
            Florian Dithmarschen
            {props.bos_kennung}
          </Link>
        </div>
      ) : (
        <></>
      )}
      <div>
        <Link to={link + props.id}>{props.fahrzeug}</Link>
      </div>
    </ErrorBoundary>
  );
};
export default EmergencyVehicle;
