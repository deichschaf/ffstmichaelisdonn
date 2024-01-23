import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { OrganisationStationProps } from '../../../../../../props/props';
import ErrorBoundary from '../../../../errorboundary';
import OrganisationHeadline from './OrganisationHeadline';
import StationCard from './StationCard';

const OrganisationStation: React.FC<React.PropsWithChildren<OrganisationStationProps>> = (
  props: OrganisationStationProps,
): JSX.Element => {
  if (typeof props.organisation === 'undefined') {
    return <></>;
  }
  if (typeof props.stations === 'undefined') {
    return <></>;
  }
  if (props.stations.length === 0) {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <OrganisationHeadline headline={props.organisation} />
      {props.stations.map((item, idx) => (
        <StationCard key={idx} organisation={props.organisation} data={item} />
      ))}
    </ErrorBoundary>
  );
};
export default OrganisationStation;
