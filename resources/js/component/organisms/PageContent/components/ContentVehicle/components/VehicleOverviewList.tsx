import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { VehicleOverviewListProps } from '../../../../../../props/props';
import GridBox from '../../../../../molecules/GridBox';
import ErrorBoundary from '../../../../errorboundary';
import VehicleList from './VehicleList';

const VehicleOverviewList: React.FC<React.PropsWithChildren<VehicleOverviewListProps>> = (
  props: VehicleOverviewListProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <GridBox lable={props.title}>
        <Row>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0} className="text-bold" />
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0} className="text-bold">
            Funkrufname
          </Col>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0} className="text-bold">
            Fahrzeugtyp
          </Col>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0} className="text-bold">
            Hersteller, Modell
          </Col>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0} className="text-bold">
            Baujahr
          </Col>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0} className="text-bold">
            Kennzeichen
          </Col>
        </Row>
        {props.data.map((row, idx) => (
          <VehicleList key={idx} data={row} />
        ))}
      </GridBox>
    </ErrorBoundary>
  );
};
export default VehicleOverviewList;
