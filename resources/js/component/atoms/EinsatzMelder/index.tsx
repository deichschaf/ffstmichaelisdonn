import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { EinsatzMelderProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import FAR from '../Icon/FAR';
import FAS from '../Icon/FAS';
import { Link } from 'react-router-dom';

const EinsatzMelder: React.FC<React.PropsWithChildren<EinsatzMelderProps>> = (
  props: EinsatzMelderProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }

  const emergency = props.data.last_emergency;
  return (
    <ErrorBoundary>
      <div className="melder">
        <Row>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
            <FAR className="calendar-days" />
          </Col>
          <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
            {emergency.begin_date}
          </Col>
        </Row>
        <Row>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
            <FAR className="clock" />
          </Col>
          <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
            {emergency.begin_time} Uhr
          </Col>
        </Row>
        <Row>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
            <FAS className="fax" />
          </Col>
          <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
            {emergency.einsatz_art}
          </Col>
        </Row>
        <Row>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
            <FAS className="location-dot" />
          </Col>
          <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
            {emergency.einsatz_ort}
          </Col>
        </Row>
        <Row>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
            <FAS className="list" />
          </Col>
          <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
            <Link to="/einsaetze">Einsätzeübersicht</Link>
          </Col>
        </Row>
      </div>
    </ErrorBoundary>
  );
};
export default EinsatzMelder;
