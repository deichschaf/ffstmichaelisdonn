import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FiretruckOverviewComponentProps } from '../../../props/props';
import FireTruckImage from '../../molecules/FireTruckImage';
import FireTruckOverviewData from '../../molecules/FireTruckOverviewData';
import ErrorBoundary from '../errorboundary';

const FireTruckOverviewComponent: React.FC<
  React.PropsWithChildren<FiretruckOverviewComponentProps>
> = (props: FiretruckOverviewComponentProps): JSX.Element => {
  if (typeof props.id === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
          <FireTruckImage data={props.image} />
        </Col>
        <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
          <FireTruckOverviewData data={props.data} />
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default FireTruckOverviewComponent;
