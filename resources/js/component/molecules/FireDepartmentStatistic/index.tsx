import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FireDepartmentStatisticProps } from '../../../props/props';
import CountUpWithIcon from '../../atoms/CountUpWithIcon';
import ErrorBoundary from '../../organisms/errorboundary';

const FireDepartmentStatistic: React.FC<React.PropsWithChildren<FireDepartmentStatisticProps>> = (
  props: FireDepartmentStatisticProps,
): JSX.Element => {
  if (typeof props.active_user === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
          <CountUpWithIcon
            icontype="fas"
            icon="users"
            maxcount={props.active_user}
            description="aktive Mitglieder"
            startcount={0}
          />
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
          <CountUpWithIcon
            icontype="fas"
            icon="truck"
            maxcount={props.trucks}
            description="Fahrzeuge"
            startcount={0}
          />
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
          <CountUpWithIcon
            icontype="fas"
            icon="fire"
            maxcount={props.alarms}
            description="Einsätze"
            startcount={0}
          />
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default FireDepartmentStatistic;
