import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FireDepartmentFieldTypeProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const FireDepartmentFieldType: React.FC<React.PropsWithChildren<FireDepartmentFieldTypeProps>> = (
  props: FireDepartmentFieldTypeProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} className="chart_inside">
        <div>
          <div className="title">{props.name}</div>
          <div className="chart_bg" style={{ width: `${props.percent}%` }}>
            <div className="chart_data bg-alert">
              <span>{props.percent}%</span>
            </div>
          </div>
        </div>
      </Col>
    </Row>
  </ErrorBoundary>
);
export default FireDepartmentFieldType;
