import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { VehicleProcessOverviewProps } from '../../../../../../props/props';
import Spacer from '../../../../../molecules/Spacer';
import ErrorBoundary from '../../../../errorboundary';
import ContentSectorHeadline from '../../ContentSectorHeadline';
import ContentSeperator from '../../ContentSeperator';
import VehicleProcess from './VehicleProcess';

const VehicleProcessOverview: React.FC<React.PropsWithChildren<VehicleProcessOverviewProps>> = (
  props: VehicleProcessOverviewProps,
): JSX.Element => {
  if (typeof props.stationiert === 'undefined') {
    return <></>;
  }
  if (props.stationiert.length === 0) {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <>
        <Spacer />
        <ContentSectorHeadline>Stationierungen des Fahrzeugs:</ContentSectorHeadline>
        <Row>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
            von
          </Col>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
            bis
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4}>
            Standort
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4}>
            eingesetzt als
          </Col>
        </Row>
        {props.stationiert.map((item, idx) => (
          <VehicleProcess key={idx} data={item} />
        ))}
      </>
    </ErrorBoundary>
  );
};
export default VehicleProcessOverview;
