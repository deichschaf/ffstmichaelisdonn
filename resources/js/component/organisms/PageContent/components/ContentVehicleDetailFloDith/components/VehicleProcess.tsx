import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { VehicleProcessProps } from '../../../../../../props/props';
import ErrorBoundary from '../../../../errorboundary';
import { Link } from 'react-router-dom';

const VehicleProcess: React.FC<React.PropsWithChildren<VehicleProcessProps>> = (
  props: VehicleProcessProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const { data } = props;
  return (
    <ErrorBoundary>
      <Row className="colorchanger">
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
          {data.von}
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
          {data.bis}
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4}>
          <Link to={`/fahrzeugdatenbank/ort/${data.standort_id}/${data.standort_url}`}>
            {data.standort_name}
          </Link>
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4}>
          <Link to={`/fahrzeugdatenbank/fahrzeug/${data.fahrzeug_id}/titel/${data.fahrzeug_url}`}>
            {data.fahrzeug}
          </Link>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default VehicleProcess;
